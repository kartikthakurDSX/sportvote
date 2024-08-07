<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Match_fixture_stat;
use App\Models\Team;
use App\Models\Match_fixture;
use App\Models\Competition;
use App\Models\Match_fixture_lapse;
use App\Models\StatTrack;
use App\Models\Sport_stat;

class DetailedMatchReport extends Component
{
    public $match_fixture_id;
    public $fixture_id;
    public $listeners = ['refreshData'];
    public $fixture_lapse_type;



    public function refresh()
    {
        $this->dispatch('$refresh');
        // Your logic to refresh data goes here
        // For example, you can fetch updated data and update public properties used in the component
    }
    public function refreshData()
    {
        // Your logic to refresh data goes here
        // For example, you can fetch updated data and update public properties used in the component
        $this->dispatch('refreshDataComplete'); // Optional: Emit an event to signal that data refresh is complete
    }

    public function mount($match_fixture_id)
    {
        $this->fixture_id = $match_fixture_id;
    }

    public function render()
    {
        $fixture_stat_record = Match_fixture_stat::where('match_fixture_id', $this->fixture_id)
            ->where('half_type', 1)
            ->with('sport_stat', 'player', 'team')
            ->orderBy('stat_time_record', 'DESC')
            ->get();

        $fixture_stat_record_second_half = Match_fixture_stat::where('match_fixture_id', $this->fixture_id)
            ->where('half_type', 2)
            ->with('sport_stat', 'player', 'team')
            ->orderBy('stat_time_record', 'DESC')
            ->get();

        $match_fixture = Match_fixture::find($this->fixture_id);
        $teamOne = Team::find($match_fixture->teamOne_id);
        $teamTwo = Team::find($match_fixture->teamTwo_id);
        $como_report_type = Competition::select('id', 'report_type')
            ->find($match_fixture->competition_id);

        $match_pause_first_half = Match_fixture_lapse::where('match_fixture_id', $this->fixture_id)
            ->where('lapse_type', 6)
            ->latest()
            ->first();

        $match_play_first_half = Match_fixture_lapse::where('match_fixture_id', $this->fixture_id)
            ->where('lapse_type', 5)
            ->latest()
            ->first();


        if ($como_report_type->report_type == 1) {
            $player_stats = Sport_stat::whereIn('stat_type_id', [0, 1])
                ->whereIn('stat_type', [0, 1])
                ->get();
        } else {
            $detailed_stats = StatTrack::select('Stat_ids')->where('tracking_type', 1)->where('tracking_for', $match_fixture->competition_id)
                ->where('is_active', 1)
                ->latest()
                ->first();
            if (!empty($detailed_stats)) {
                $stats_array = explode(',', $detailed_stats->Stat_ids);
            } else {
                $stats_array = [1, 2, 3, 5, 47];
            }
            $player_stats = Sport_stat::whereIn('id', $stats_array)
                ->where('is_active', 1)
                ->get();
        }
        $count_firsthalf_pause = Match_fixture_stat::where('match_fixture_id', $this->fixture_id)
            ->where('sport_stats_id', 16)
            ->where('half_type', 1)
            ->count();
        $count_secondhalf_pause = Match_fixture_stat::where('match_fixture_id', $this->fixture_id)
            ->where('sport_stats_id', 18)
            ->where('half_type', 2)
            ->count();

        $firsthalf_pause = Match_fixture_stat::where('match_fixture_id', $this->fixture_id)
            ->whereIn('sport_stats_id', [16, 17])
            ->where('half_type', 1)
            ->get();
        $pause_time = array();

        foreach ($firsthalf_pause as $pause) {
            if ($pause && isset($pause->created_at)) {
                if ($pause->sport_stats_id == 17) {
                    $previous_id = $pause->id - 1;
                    $previous_pause_time = Match_fixture_stat::find($previous_id);
                    if ($previous_pause_time && isset($previous_pause_time->created_at)) {
                        $dateTimeObject1 = date_create($previous_pause_time->created_at);
                        $dateTimeObject2 = date_create($pause->created_at);
                        $difference = date_diff($dateTimeObject1, $dateTimeObject2);
                        $stat_diff =  $difference->format('%H:%I:%S');
                        $pause_time[] = $stat_diff;
                    }
                }
            }
        }


        $collect_stat_diff_time = array();
        foreach ($pause_time as $tttt) {
            $collect_stat_diff_time[] =  strtotime($tttt);
        }
        $sum_stat_time = array_sum($collect_stat_diff_time);
        $first_half_pp_time = date("i:s", $sum_stat_time);

        $second_half_pause = Match_fixture_stat::where('match_fixture_id', $this->fixture_id)
            ->whereIn('sport_stats_id', [18, 19])
            ->where('half_type', 2)
            ->get();
        $second_pause_time = array();
        //dd($second_half_pause);
        foreach ($second_half_pause as $pause) {
            // $second_pause_time[] = $pause->sport_stats_id.' '.$pause->created_at;
            if ($pause->sport_stats_id == 19) {
                $previous_id = $pause->id - 1;
                $previous_pause_time = Match_fixture_stat::find($previous_id);

                // Ensure $previous_pause_time is not null before accessing its created_at property
                if ($previous_pause_time) {
                    $dateTimeObject1 = date_create($previous_pause_time->created_at);
                    $dateTimeObject2 = date_create($pause->created_at);
                    $difference = date_diff($dateTimeObject1, $dateTimeObject2);
                    $stat_diff =  $difference->format('%H:%I:%S');
                    $second_pause_time[] = $stat_diff;
                }
            }
        }

        $collect_stat_diff_time = array();
        foreach ($second_pause_time as $tttt) {
            $collect_stat_diff_time[] =  strtotime($tttt);
        }
        $sum_stat_time = array_sum($collect_stat_diff_time);
        $second_half_pp_time = date("i:s", $sum_stat_time);


        $latest_fixture_stat = Match_fixture_stat::select('stat_time')
            ->where('match_fixture_id', $this->fixture_id)
            ->where('sport_stats_id', 12)
            ->latest()
            ->first();

        $latest_play_first_half = Match_fixture_lapse::where('match_fixture_id', $this->fixture_id)
            ->where('lapse_type', 5)
            ->orderBy('id', 'desc')
            ->latest()
            ->first();

        $first_half_start = Match_fixture_lapse::where('match_fixture_id', $this->fixture_id)
            ->where('lapse_type', 1)
            ->latest()
            ->first();

        if ($latest_play_first_half) {
            $dateTimeObject1 = date_create($latest_play_first_half->created_at);
            $dateTimeObject2 = date_create($first_half_start->created_at);
            $difference = date_diff($dateTimeObject1, $dateTimeObject2);
            $stat =  $difference->format('%I:%S');
        }

        // Goal calculation
        $goalstats_teamone = Match_fixture_stat::where('match_fixture_id', $match_fixture->id)
            ->where('team_id', $teamOne->id)
            ->where('sport_stats_id', 1)
            ->get();
        $goalstats_teamtwo = Match_fixture_stat::where('match_fixture_id', $match_fixture->id)
            ->where('team_id', $teamTwo->id)
            ->where('sport_stats_id', 1)
            ->get();
        $owngoalstats_teamone = Match_fixture_stat::where('match_fixture_id', $match_fixture->id)
            ->where('team_id', $teamOne->id)
            ->where('sport_stats_id', 54)
            ->get();
        $owngoalstats_teamtwo = Match_fixture_stat::where('match_fixture_id', $match_fixture->id)
            ->where('team_id', $teamTwo->id)
            ->where('sport_stats_id', 54)
            ->get();

        if ($goalstats_teamone) {
            $goal_countTeam1 = $goalstats_teamone->count();
        } else {
            $goal_countTeam1 = 0;
        }
        if ($goalstats_teamtwo) {
            $goal_countTeam2 = $goalstats_teamtwo->count();
        } else {
            $goal_countTeam2 = 0;
        }

        if ($owngoalstats_teamone) {
            $ownGoal_countTeam1 = $owngoalstats_teamone->count();
        } else {
            $ownGoal_countTeam1 = 0;
        }
        if ($owngoalstats_teamtwo) {
            $ownGoal_countTeam2 = $owngoalstats_teamtwo->count();
        } else {
            $ownGoal_countTeam2 = 0;
        }

        $totalTeam1Goal = $goal_countTeam1 + $ownGoal_countTeam1;
        $totalTeam2Goal = $goal_countTeam2 + $ownGoal_countTeam2;


        return view('livewire.detailed-match-report', compact('fixture_stat_record', 'teamOne', 'teamTwo', 'player_stats', 'totalTeam1Goal', 'totalTeam2Goal', 'match_fixture', 'fixture_stat_record_second_half', 'count_firsthalf_pause', 'count_secondhalf_pause', 'first_half_pp_time', 'second_half_pp_time', 'match_pause_first_half', 'match_play_first_half', 'latest_fixture_stat'));
    }
}
