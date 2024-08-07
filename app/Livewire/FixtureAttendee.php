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
use App\Models\Team_member;
use App\Models\User;
use App\Models\voting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FixtureAttendee extends Component
{

    public $fixture_id;
    public $player_id;
    public $vote;
    public $player_position;
    public $refree_id;
    public $refree_info;

    public function mount($match_fixture_id)
    {
        $this->fixture_id = $match_fixture_id;
    }

    public function render()
    {

        $match_fixture = Match_fixture::find($this->fixture_id);
        $competition = Competition::find($match_fixture->competition_id);

        $comp_admins = Comp_member::where('comp_id', $competition->id)->where('member_position_id', 7)->where('invitation_status', 1)->where('is_active', 1)->with('member')->pluck('member_id');
        $admins = $comp_admins->toArray();
        array_push($admins, $competition->user_id);


        //team_admins
        $teamOne_id = $match_fixture->teamOne_id;
        $teamTwo_id = $match_fixture->teamTwo_id;

        $teamOne = Team::find($match_fixture->teamOne_id);
        $teamTwo = Team::find($match_fixture->teamTwo_id);
        $teamOne_attendees = Competition_attendee::where('team_id', $teamOne->id)->where('competition_id', $match_fixture->competition_id)->get();
        $teamTwo_attendees = Competition_attendee::where('team_id', $teamTwo->id)->where('competition_id', $match_fixture->competition_id)->get();

        $team_admins = Team_member::where(function ($query) use ($teamOne_id, $teamTwo_id) {
            $query->where('team_id', '=', $teamOne_id)
                ->orWhere('team_id', '=', $teamTwo_id);
        })->where('member_position_id', 4)->where('invitation_status', 1)->with('member')->pluck('member_id');
        $team_admins_ids = $team_admins->toarray();
        array_push($team_admins_ids, $teamOne->user_id, $teamTwo->user_id);

        $all_admins = array_unique(array_merge($admins, $team_admins_ids));

        $fixture_squad_teamOne = Fixture_squad::where('match_fixture_id', $match_fixture->id)->where('team_id', $teamOne->id)->with('team', 'player')->where('is_active', 1)->get();
        $fixture_squad_teamTwo = Fixture_squad::where('match_fixture_id', $match_fixture->id)->where('team_id', $teamTwo->id)->with('team', 'player')->where('is_active', 1)->get();
        $player_goal = Match_fixture_stat::where('match_fixture_id', $match_fixture->id)->where('sport_stats_id', 1)->get();
        $player_stats = Sport_stat::where('stat_type_id', 1)->get();
        $ground_map_position = SportGroundPosition::all();
        $voting = voting::where('match_fixture_id', $this->fixture_id)->where('fan_id', Auth::user()->id)->first();

        $collection = Match_fixture_stat::groupBy('player_id')
        ->where('match_fixture_id', $this->fixture_id)
        ->where('sport_stats_id', 1)
        ->selectRaw('count(*) as total, player_id')
        ->get();

        $stats = $collection->toArray();

        if (!(empty($stats))) {
            $scorerofthematch = max($stats);
        } else {
            $scorerofthematch = "";
        }

        // voting time

        $finish_time = $match_fixture->finishdate_time;
        $dateTimeObject1 = date_create($finish_time);
        $dateTimeObject2 = now();
        $difference = date_diff($dateTimeObject1, $dateTimeObject2);
        $voting_minutes = $difference->days * 24 * 60;
        $voting_minutes += $difference->h * 60;
        $voting_minutes += $difference->i;


        $fixture_lapse_type = Match_fixture_lapse::where('match_fixture_id', $match_fixture->id)->orderBy('id', 'desc')->latest()->first();



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
        $checkPlayervoting = Voting::groupBy('player_id')->where('match_fixture_id', $this->fixture_id)->selectRaw('count(*) as total, player_id')->get();
        $manoftheMatch_player_id = $checkPlayervoting->toArray();
        if (!(empty($manoftheMatch_player_id))) {
            $manoftheMatch = max($manoftheMatch_player_id);
        } else {
            $manoftheMatch = "";
        }


        $teamOne_player = array();
        $teamTwo_player = array();
        foreach ($teamOne_attendees as $tm1) {
            $teamOne_player[] = $tm1->attendee_id;
        }
        foreach ($teamTwo_attendees as $tm1) {
            $teamTwo_player[] = $tm1->attendee_id;
        }

        $team_player = array_merge($teamOne_player, $teamTwo_player);

        $refrees = User::whereNotIn('id', $team_player)->get();

        $query1 = Fixture_squad::select('player_id')->where('match_fixture_id', $match_fixture->id)->where('team_id', $teamOne->id)->where('is_active', 1)->get();

        $subplyr1 = Competition_attendee::where('team_id', $teamOne->id)->where('competition_id', $match_fixture->competition_id)

            ->whereNotIn('attendee_id', $query1)
            ->with('player')->get();

        $query2 = Fixture_squad::select('player_id')->where('match_fixture_id', $match_fixture->id)->where('team_id', $teamTwo->id)->where('is_active', 1)->get();

        $subplyr2 = Competition_attendee::where('team_id', $teamTwo->id)->where('competition_id', $match_fixture->competition_id)

            ->whereNotIn('attendee_id', $query2)
            ->with('player')->get();


        $teamOne_admins = Team_member::where('team_id', $teamOne->id)->where('member_position_id', 4)->where('invitation_status', 1)->pluck('member_id');
        $teamOne_admins_ids = $teamOne_admins->toarray();
        array_push($teamOne_admins_ids, $teamOne->user_id);

        $teamTwo_admins = Team_member::where('team_id', $teamTwo->id)->where('member_position_id', 4)->where('invitation_status', 1)->pluck('member_id');
        $teamTwo_admins_ids = $teamTwo_admins->toarray();
        array_push($teamTwo_admins_ids, $teamTwo->user_id);

        return view('livewire.fixture-attendee', compact('admins','match_fixture', 'competition', 'voting_minutes', 'ground_map_position', 'fixture_squad_teamOne', 'fixture_squad_teamTwo', 'scorerofthematch', 'player_stats', 'teamOne', 'teamTwo', 'teamOne_attendees', 'teamTwo_attendees', 'player_goal', 'fixture_lapse_type', 'manoftheMatch', 'refrees', 'subplyr1', 'subplyr2','teamOne_admins_ids', 'teamTwo_admins_ids'));
    }

    public function vote($id, $team_id)
    {
        // dd($id);
        $check_vote = voting::where('match_fixture_id', $this->fixture_id)->where('fan_id', Auth::user()->id)->first();
        if ($check_vote) {
            $voting = voting::find($check_vote->id);
            $voting->team_id = $team_id;
            $voting->player_id = $id;
            $voting->save();
        } else {
            $voting = new voting();
            $voting->match_fixture_id = $this->fixture_id;
            $voting->team_id = $team_id;
            $voting->player_id = $id;
            $voting->fan_id = Auth::user()->id;
            $voting->save();
        }
    }

    public function alertstopmatch()
    {
        $this->dispatch('swal:modal', [

            'message' => 'You can not enter the players stats due to match is Stoped Or Paused',

        ]);
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
}
