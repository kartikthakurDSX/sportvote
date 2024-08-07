<?php

namespace App\Livewire\Competition;

use App\Models\Match_fixture;
use App\Models\Team;
use App\Models\StatDecisionMaker;
use App\Models\Match_fixture_stat;
use Livewire\Component;

class LeaguePointTable extends Component
{
    public $comp_id;
    public $listeners = ['refreshData'];


    public function refresh()
    {
        $this->dispatch('$refresh');
    }
    public function refreshData()
    {
        $this->dispatch('refreshDataComplete'); // Optional: Emit an event to signal that data refresh is complete
    }

    public function mount($competition)
    {
        $this->comp_id = $competition;
    }
    public function render()
    {

        $played_fixtures = Match_fixture::where('competition_id', $this->comp_id)->where('finishdate_time', '!=', NULL)->get();
        if ($played_fixtures->count() > 0) {
            $fixtures = $played_fixtures;
        } else {
            $fixtures = Match_fixture::where('competition_id', $this->comp_id)->get();
        }

        // stat_id 6=> played, 7=> Won, 8=>lost, 9=>draw, 11=> goal for, 41=> goal_differnece, 50=> goal_against
        $decision_maker = StatDecisionMaker::where('decision_stat_for', 1)->where('stat_type', 1)->where('type_id', $this->comp_id)->orderBy('stat_order')->where('is_active', 1)->with('sport_stat')->get();
        $decision_maker_array = array();
        foreach ($decision_maker as $d) {
            $decision_maker_array[] = $d->stat_id;
        }

        //dd($decision_maker_array);
        $comp_teamOne_ids = array();
        $comp_teamTwo_ids = array();
        foreach ($fixtures as $fix) {
            $comp_teamOne_ids[] = $fix->teamOne_id;
            $comp_teamTwo_ids[] = $fix->teamTwo_id;
        }
        $team_ids = array_unique(array_merge($comp_teamOne_ids, $comp_teamTwo_ids));
        //dd($team_ids);
        $table_data = array();
        $w = 0;
        $Key2 = 0;
        foreach ($team_ids as $team_id) {

            $team_name_logo = Team::select('id', 'name', 'team_logo', 'location')->find($team_id);
            $team_name = $team_name_logo->name;
            $team_logo = $team_name_logo->team_logo;
            $team_location = $team_name_logo->location;
            $team_id = $team_name_logo->id;
            $played = Match_fixture::where(function ($query) use ($team_id) {
                $query->where('teamOne_id', '=', $team_id)
                    ->orWhere('teamTwo_id', '=', $team_id);
            })->where('competition_id', $this->comp_id)->where('finishdate_time', '!=', Null)->count();
            $won = Match_fixture::where('competition_id', $this->comp_id)->where('winner_team_id', $team_id)->count();
            $draw = Match_fixture::where(function ($query) use ($team_id) {
                $query->where('teamOne_id', '=', $team_id)
                    ->orWhere('teamTwo_id', '=', $team_id);
            })->where('competition_id', $this->comp_id)->where('fixture_type', 1)->count();

            $lost =  Match_fixture::where(function ($query) use ($team_id) {
                $query->where('teamOne_id', '=', $team_id)
                    ->orWhere('teamTwo_id', '=', $team_id);
            })->where('competition_id', $this->comp_id)->where('winner_team_id', '!=', $team_id)->count();

            //goal data
            $goals_for = Match_fixture_stat::where('competition_id', $this->comp_id)->where('team_id', $team_id)->whereIn('sport_stats_id', [1, 54])->where('is_active', 1)->count();
            $againts_team = Match_fixture::where(function ($query) use ($team_id) {
                $query->where('teamOne_id', '=', $team_id)
                    ->orWhere('teamTwo_id', '=', $team_id);
            })->where('competition_id', $this->comp_id)->where('finishdate_time', '!=', Null)->get();
            $againts_goals = 0;
            // dd($againts_team);
            foreach ($againts_team as $a_team) {
                if ($a_team->teamOne_id == $team_id) {
                    // $a_team_ids[] = $a_team->teamTwo_id;
                    $goal_a = Match_fixture_stat::where('competition_id', $this->comp_id)->where('team_id', $a_team->teamTwo_id)->where('match_fixture_id', $a_team->id)->whereIn('sport_stats_id', [1, 54])->where('is_active', 1)->count();
                    $againts_goals = $againts_goals + $goal_a;
                } else {
                    $goal_a = Match_fixture_stat::where('competition_id', $this->comp_id)->where('team_id', $a_team->teamOne_id)->where('match_fixture_id', $a_team->id)->whereIn('sport_stats_id', [1, 54])->where('is_active', 1)->count();
                    $againts_goals = $againts_goals + $goal_a;
                }
            }
            $goal_differ = $goals_for - $againts_goals;

            // stat_id 6=> played, 7=> Won, 8=>lost, 9=>draw, 11=> goal for, 41=> goal_differnece, 50=> goal_against
            if (count($decision_maker_array) > 1) {
                if (array_key_exists(1, $decision_maker_array)) {
                    if ($decision_maker_array[1] == 6) {
                        $second_priority =  $played;
                    } elseif ($decision_maker_array[1] == 7) {
                        $second_priority =  $won;
                    } elseif ($decision_maker_array[1] == 8) {
                        $second_priority =  $lost;
                    } elseif ($decision_maker_array[1] == 9) {
                        $second_priority =  $draw;
                    } elseif ($decision_maker_array[1] == 11) {
                        $second_priority =  $goals_for;
                    } elseif ($decision_maker_array[1] == 41) {
                        $second_priority =  $goal_differ;
                    } elseif ($decision_maker_array[1] == 50) {
                        $second_priority =  $againts_goals;
                    } else {
                        $second_priority =  $won;
                    }
                } else {
                    $second_priority =  $won;
                }

                // third priority
                if (array_key_exists(2, $decision_maker_array)) {
                    if ($decision_maker_array[2] == 6) {
                        $third_priority =  $played;
                    } elseif ($decision_maker_array[2] == 7) {
                        $third_priority =  $won;
                    } elseif ($decision_maker_array[2] == 8) {
                        $third_priority =  $lost;
                    } elseif ($decision_maker_array[2] == 9) {
                        $third_priority =  $draw;
                    } elseif ($decision_maker_array[2] == 11) {
                        $third_priority =  $goals_for;
                    } elseif ($decision_maker_array[2] == 41) {
                        $third_priority =  $goal_differ;
                    } elseif ($decision_maker_array[2] == 50) {
                        $third_priority =  $againts_goals;
                    } else {
                        $third_priority =  $won;
                    }
                } else {
                    $third_priority =  $won;
                }
            } else {
                $second_priority = $won;
                $third_priority = $won;
            }
            $win_points = $won * 3;
            $draw_points = $draw * 1;
            $points = $win_points + $draw_points;

            $tableData = array(
                "points" => $points, "second_priority" => $second_priority, "third_priority" => $third_priority, "team_name" => $team_name, "team_logo" => $team_logo,
                "team_id" => $team_id, "played" => $played, "won" => $won, "draw" => $draw, "lost" => $lost, "goals_for" => $goals_for, "againts_goals" => $againts_goals, "goal_differ" => $goal_differ
            );
            array_push($table_data, $tableData);
            $w++;
        }

        return view('livewire.competition.league-point-table', compact('table_data'));
    }
}
