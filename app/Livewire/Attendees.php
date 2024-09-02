<?php

namespace App\Livewire;

use App\Models\Comp_member;
use App\Models\Competition;
use App\Models\Competition_attendee;
use App\Models\Fixture_squad;
use App\Models\Match_fixture;
use App\Models\Match_fixture_lapse;
use App\Models\Match_fixture_stat;
use App\Models\Sport_stat;
use App\Models\SportGroundPosition;
use App\Models\Team;
use App\Models\User;
use App\Models\voting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Attendees extends Component
{
    public $match_fixture_id;
    public $fixture_id;
    public $player_id;
    public $vote;
    public $player_position;
    public $refree_id;
    public $selectedReferee_id;
    public $refree_info;

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
        $match_fixture = Match_fixture::find($this->fixture_id);    // Get the details of the match fixture
        $competition = Competition::find($match_fixture->competition_id);   //  Get the details of the competition
        $teamOne = Team::find($match_fixture->teamOne_id);  //  Details of team one
        $teamTwo = Team::find($match_fixture->teamTwo_id);  //  Details of team two

        //  Players who gonna attend the match for team one
        $teamOne_attendees = Competition_attendee::where('team_id', $teamOne->id)
            ->where('competition_id', $match_fixture->competition_id)
            ->with('player')
            ->get();

        //  Players who gonna attend the match for team two
        $teamTwo_attendees = Competition_attendee::where('team_id', $teamTwo->id)
            ->where('competition_id', $match_fixture->competition_id)
            ->with('player')
            ->get();

        // Details of the team and player, ground position for team one
        $fixture_squad_teamOne = Fixture_squad::where('match_fixture_id', $match_fixture->id)
            ->where('team_id', $teamOne->id)
            ->with('team', 'player')
            ->where('is_active', 1)
            ->get();

        // Details of the team and player, ground position for team two
        $fixture_squad_teamTwo = Fixture_squad::where('match_fixture_id', $match_fixture->id)
            ->where('team_id', $teamTwo->id)
            ->with('team', 'player')
            ->where('is_active', 1)
            ->get();

        // Get what is the last status of the match fixture(play, pause, resume, finish 1st half, finish 2nd half)
        $fixture_lapse_type = Match_fixture_lapse::where('match_fixture_id', $match_fixture->id)
            ->orderBy('id', 'desc')
            ->latest()
            ->first();

        // Get the goals in the overall match
        $player_goal = Match_fixture_stat::where('match_fixture_id', $match_fixture->id)
            ->where('sport_stats_id', 1)
            ->get();

        // Get all the details where stat is of type player
        $player_stats = Sport_stat::where('stat_type_id', 1)->get();

        //  Get all the player positions in the ground for the sport
        $ground_map_position = SportGroundPosition::all();

        // Get the record where fan id matches the logged in user id
        $voting = Voting::where('match_fixture_id', $this->fixture_id)
            ->where('fan_id', Auth::user()->id)
            ->first();

        // Scorer of the match by goal
        $collection = Match_fixture_stat::where('match_fixture_id', $this->fixture_id)
            ->where('sport_stats_id', 1)
            ->where('stat_type', 1)
            ->get();

        //  Finding who's the top scorer of the match
        $top_scorer = $collection->groupBy('player_id');
        $players_goals = [];

        foreach ($top_scorer as $scorer_id => $goal_count) {
            $players_goals[$scorer_id] = $goal_count->count();
        }

        $scorerofthematch = count($players_goals) > 0 ?
            Match_fixture_stat::select('player_id')
            ->where('match_fixture_id', $this->fixture_id)
            ->where('sport_stats_id', 1)
            ->where('stat_type', 1)
            ->whereIn('player_id', array_keys($players_goals, max($players_goals)))
            ->latest()
            ->first() :
            null;

        // Man of the match by vote
        $checkPlayervoting = Voting::groupBy('player_id')
            ->where('match_fixture_id', $this->fixture_id)
            ->selectRaw('count(*) as total, player_id')
            ->get();

        $manoftheMatch_player_id = $checkPlayervoting->toArray();
        $manoftheMatch = !empty($manoftheMatch_player_id) ? max($manoftheMatch_player_id) : null;

        // Voting time
        $finish_time = $match_fixture->finishdate_time;
        $dateTimeObject1 = date_create($finish_time);
        $dateTimeObject2 = now();
        $difference = date_diff($dateTimeObject1, $dateTimeObject2);
        $voting_minutes = $difference->days * 24 * 60;
        $voting_minutes += $difference->h * 60;
        $voting_minutes += $difference->i;

        // Identify players for a particular fixture
        $teamOne_player = [];
        $teamTwo_player = [];

        foreach ($teamOne_attendees as $tm1) {
            $teamOne_player[] = $tm1->attendee_id;
        }

        foreach ($teamTwo_attendees as $tm1) {
            $teamTwo_player[] = $tm1->attendee_id;
        }

        $team_player = array_merge($teamOne_player, $teamTwo_player);
        $refrees = User::whereNotIn('id', $team_player)->get();
        $comp_referees = Comp_member::where('comp_id', $match_fixture->competition_id)
            ->where('member_position_id', 6)
            ->where('invitation_status', 1)
            ->where('is_active', 1)
            ->with('member')
            ->get();

        $query1 = Fixture_squad::select('player_id')
            ->where('match_fixture_id', $match_fixture->id)
            ->where('team_id', $teamOne->id)
            ->where('is_active', 1)
            ->get();

        $subplyr1 = Competition_attendee::where('team_id', $teamOne->id)
            ->where('competition_id', $match_fixture->competition_id)
            ->whereNotIn('attendee_id', $query1)
            ->with('player')->get();

        $query2 = Fixture_squad::select('player_id')
            ->where('match_fixture_id', $match_fixture->id)
            ->where('team_id', $teamTwo->id)
            ->where('is_active', 1)
            ->get();

        $subplyr2 = Competition_attendee::where('team_id', $teamTwo->id)
            ->where('competition_id', $match_fixture->competition_id)
            ->whereNotIn('attendee_id', $query2)
            ->with('player')->get();

        return view('livewire.attendees', compact('fixture_lapse_type', 'voting', 'ground_map_position', 'voting_minutes', 'manoftheMatch', 'scorerofthematch', 'player_stats', 'match_fixture', 'fixture_squad_teamOne', 'fixture_squad_teamTwo', 'competition', 'teamOne', 'teamTwo', 'teamOne_attendees', 'teamTwo_attendees', 'player_goal', 'refrees', 'comp_referees', 'subplyr1', 'subplyr2'));
    }

    public function vote($id, $team_id)
    {
        // dd($id);
        $check_vote = Voting::where('match_fixture_id', $this->fixture_id)
            ->where('fan_id', Auth::user()->id)
            ->first();

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
    }

    public function alertstopmatch()
    {
        $this->dispatch('swal:modal', ['message' => 'You can not enter the players stats due to match is Stoped Or Paused']);
    }
    public function alert_redcard_player()
    {
        $this->dispatch('swal:modal', [

            'message' => 'RED Card Received, No More Stats Allowed',

        ]);
    }
    public function alert_yellowcard_player()
    {
        $this->dispatch('swal:modal', [

            'message' => '2 YELLOW Card Received, No More Stats Allowed',

        ]);
    }
    public function refree_info()
    {
        $this->refree_info = User::find($this->refree_id);
        //dd($this->refree_id);
    }
    public function selectReferee()
    {
        if ($this->selectedReferee_id != "") {
            $update_matchFixture = Match_fixture::find($this->fixture_id);
            $update_matchFixture->refree_id = $this->selectedReferee_id;
            $update_matchFixture->save();
            $this->refree_id = $update_matchFixture->refree_id;
            $this->dispatch('closeSelectRefereeModal');
        }
    }
}
