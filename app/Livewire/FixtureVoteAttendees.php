<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Match_fixture;
use App\Models\Competition;
use App\Models\Team;
use App\Models\Competition_attendee;
use App\Models\Fixture_squad;
use App\Models\Match_fixture_stat;
use App\Models\Sport_stat;
use App\Models\voting;
use App\Models\SportGroundPosition;
use App\Models\Match_fixture_lapse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FixtureVoteAttendees extends Component
{
    public $match_fixture_id;
    public $fixture_id;
    public $player_id;
    public $vote;
    public $player_position;
    public $listeners = ['refreshData'];


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
        $match_fixture = Match_fixture::find($this->fixture_id);
        $competition = Competition::find($match_fixture->competition_id);
        $teamOne = Team::find($match_fixture->teamOne_id);
        $teamTwo = Team::find($match_fixture->teamTwo_id);
        $teamOne_attendees = Competition_attendee::where('team_id', $teamOne->id)->where('competition_id', $match_fixture->competition_id)->with('player')->get();
        $teamTwo_attendees = Competition_attendee::where('team_id', $teamTwo->id)->where('competition_id', $match_fixture->competition_id)->with('player')->get();
        $fixture_squad_teamOne = Fixture_squad::where('match_fixture_id', $match_fixture->id)->where('team_id', $teamOne->id)->with('team', 'player')->where('is_active', 1)->get();
        $fixture_squad_teamTwo = Fixture_squad::where('match_fixture_id', $match_fixture->id)->where('team_id', $teamTwo->id)->with('team', 'player')->where('is_active', 1)->get();
        $fixture_lapse_type = Match_fixture_lapse::where('match_fixture_id', $match_fixture->id)->orderBy('id', 'desc')->latest()->first();
        $player_goal = Match_fixture_stat::where('match_fixture_id', $match_fixture->id)->where('sport_stats_id', 1)->get();
        $player_stats = Sport_stat::where('stat_type_id', 1)->get();
        $ground_map_position = SportGroundPosition::all();

        // Scoreer of the match by goal
        $collection = Match_fixture_stat::where('match_fixture_id', $this->fixture_id)->where('sport_stats_id', 1)->where('stat_type', 1)->get();
        $top_scorer = $collection->groupBy('player_id');
        $players_goals = array();
        foreach ($top_scorer as $scorer_id => $goal_count) {
            $players_goals[$scorer_id] = $goal_count->count();
        }
        if (count($players_goals) > 0) {
            $max_scorer =  array_keys($players_goals, max($players_goals));
            $scorerofthematch = Match_fixture_stat::select('player_id')->where('match_fixture_id', $this->fixture_id)->where('sport_stats_id', 1)->where('stat_type', 1)->whereIn('player_id', $max_scorer)->latest()->first();
        } else {
            $scorerofthematch = "";
        }
        // Man of the match by vote
        $checkPlayervoting = Voting::groupBy('player_id')->where('match_fixture_id', $this->fixture_id)->where('status_desc', 0)->selectRaw('count(*) as total, player_id')->get();
        $manoftheMatch_player_id = $checkPlayervoting->toArray();
        $player_totalvot_array = array();
        foreach ($checkPlayervoting as $votingvalue) {
            $player_totalvot = $votingvalue['total'];
            $maxvoting_count = max(array_column($manoftheMatch_player_id, "total"));
            if ($player_totalvot == $maxvoting_count) {
                $array = array($votingvalue['player_id'] => $votingvalue['total']);
                array_push($player_totalvot_array, $array);
            }
        }
        if (!(empty($manoftheMatch_player_id))) {
            $manoftheMatchplayer = max($manoftheMatch_player_id);
            if (count($player_totalvot_array) > 0 && count($player_totalvot_array) == 1) {
                $manoftheMatch = max($manoftheMatch_player_id);
            } else {
                $mvpPlayer_team_ids = voting::where('match_fixture_id', $match_fixture->id)->where('status_desc', 0)->orderBy('id', "DESC")->first();
                $manoftheMatch = array("total" => 1, "player_id" => $mvpPlayer_team_ids->player_id);
            }
        } else {
            $manoftheMatch = "";
        }
        // voting time change man of the match by player of the match

        $match_fixture_start_time = $match_fixture->startdate_time;
        $match_fixture_finishdate_time = $match_fixture->finishdate_time;

        if ($match_fixture_start_time != null && $match_fixture_finishdate_time != null) {
            $match_fixtureVoting_time = $competition->vote_mins;
            $convert_voting_timeTo_sec = $match_fixtureVoting_time * 60;
            $strtotime_match_fixture_finishdate_time = strtotime($match_fixture_finishdate_time) + $convert_voting_timeTo_sec;
            $current_time = strtotime(now());
            if ($current_time >= $strtotime_match_fixture_finishdate_time) {
                if (!(empty($manoftheMatch_player_id))) {
                    $mvp_player_id = $manoftheMatch['player_id'];
                    $mvpPlayer_team_id = voting::where('match_fixture_id', $this->fixture_id)->where('player_id', $mvp_player_id)->where('status_desc', 0)->first();
                    // dd($mvpPlayer_team_id);
                    $check_mvp_record = voting::where('match_fixture_id', $this->fixture_id)->where('status_desc', 1)->get();
                    if (count($check_mvp_record) == 0) {

                        $match_mvp_record = new voting();
                        $match_mvp_record->match_fixture_id = $this->fixture_id;
                        $match_mvp_record->team_id = $mvpPlayer_team_id->team_id;
                        $match_mvp_record->player_id = $mvp_player_id;
                        $match_mvp_record->status_desc = 1;
                        $match_mvp_record->save();
                    }
                }

                $playerofthematch = $manoftheMatch;
            } else {

                $playerofthematch = '';
            }
        } else {

            $playerofthematch = '';
        }

        $finish_time = $match_fixture->finishdate_time;
        $dateTimeObject1 = date_create($finish_time);
        $dateTimeObject2 = now();
        $difference = date_diff($dateTimeObject1, $dateTimeObject2);
        $voting_minutes = $difference->days * 24 * 60;
        $voting_minutes += $difference->h * 60;
        $voting_minutes += $difference->i;
        // dd($voting_minutes);

        $query1 = Fixture_squad::select('player_id')->where('match_fixture_id', $match_fixture->id)->where('team_id', $teamOne->id)->where('is_active', 1)->get();

        $query2 = Fixture_squad::select('player_id')->where('match_fixture_id', $match_fixture->id)->where('team_id', $teamTwo->id)->where('is_active', 1)->get();

        $subplyr1 = Competition_attendee::where('team_id', $teamOne->id)->where('competition_id', $match_fixture->competition_id)

            ->whereNotIn('attendee_id', $query1)
            ->with('player')->get();

        $subplyr2 = Competition_attendee::where('team_id', $teamTwo->id)->where('competition_id', $match_fixture->competition_id)

            ->whereNotIn('attendee_id', $query2)
            ->with('player')->get();


        if (Auth::check()) {
            $voting = Voting::where('match_fixture_id', $this->fixture_id)->where('fan_id', Auth::user()->id)->first();
            return view('livewire.fixture-vote-attendees', compact('fixture_lapse_type', 'voting', 'ground_map_position', 'voting_minutes', 'manoftheMatch', 'scorerofthematch', 'player_stats', 'match_fixture', 'fixture_squad_teamOne', 'fixture_squad_teamTwo', 'competition', 'teamOne', 'teamTwo', 'teamOne_attendees', 'teamTwo_attendees', 'player_goal', 'playerofthematch', 'subplyr1', 'subplyr2'));
        } else {
            return view('livewire.fixture-vote-attendees', compact('fixture_lapse_type', 'ground_map_position', 'voting_minutes', 'manoftheMatch', 'scorerofthematch', 'player_stats', 'match_fixture', 'fixture_squad_teamOne', 'fixture_squad_teamTwo', 'competition', 'teamOne', 'teamTwo', 'teamOne_attendees', 'teamTwo_attendees', 'player_goal', 'playerofthematch'));
        }
    }

    public function vote($id, $team_id)
    {
        $check_vote = Voting::where('match_fixture_id', $this->fixture_id)->where('fan_id', Auth::user()->id)->first();

        if ($check_vote) {
            $voting = Voting::find($check_vote->id);
            $voting->team_id = $team_id;
            $voting->player_id = $id;
            $voting->save();
        } else {
            $voting = new Voting();
            $voting->match_fixture_id = $this->fixture_id;
            $voting->team_id = $team_id;
            $voting->player_id = $id;
            $voting->fan_id = Auth::user()->id;
            $voting->save();
        }

        $this->dispatch('swal:modal', [
            'message' => 'Your vote submitted successfully',
        ]);
    }


}
