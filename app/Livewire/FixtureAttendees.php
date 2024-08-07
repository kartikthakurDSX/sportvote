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
use Illuminate\Support\Facades\Auth;

class FixtureAttendees extends Component
{


    public $fixture_id;
    public $player_id;
    public $vote;
    public $player_position;

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
        $teamOne_attendees = Competition_attendee::where('team_id',$teamOne->id)->where('competition_id',$match_fixture->competition_id)->with('player')->get();
        $teamTwo_attendees = Competition_attendee::where('team_id',$teamTwo->id)->where('competition_id',$match_fixture->competition_id)->with('player')->get();
        $fixture_squad_teamOne = Fixture_squad::where('match_fixture_id',$match_fixture->id)->where('team_id',$teamOne->id)->with('team','player')->where('is_active',1)->get();
        $fixture_squad_teamTwo = Fixture_squad::where('match_fixture_id',$match_fixture->id)->where('team_id',$teamTwo->id)->with('team','player')->where('is_active',1)->get();
        $player_goal = Match_fixture_stat::where('match_fixture_id',$match_fixture->id)->where('sport_stats_id',1)->get();
        $player_stats = Sport_stat::where('stat_type_id',1)->get();
        $ground_map_position = SportGroundPosition::all();
        $voting = Voting::where('match_fixture_id',$this->fixture_id)->where('fan_id',Auth::user()->id)->first();

        $collection = Match_fixture_stat::groupBy('player_id')
        ->where('match_fixture_id',$this->fixture_id)
        ->where('sport_stats_id',1)
        ->selectRaw('count(*) as total, player_id')
        ->get();

        $stats = $collection->toArray();

        if(!(empty($stats)))
        {
            $scorerofthematch = max($stats);
        }
        else
        {
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
    //    dd($voting_minutes);
        return view('livewire.fixture-attendees',compact('voting','ground_map_position','voting_minutes','scorerofthematch','player_stats','match_fixture','fixture_squad_teamOne','fixture_squad_teamTwo', 'competition','teamOne','teamTwo','teamOne_attendees','teamTwo_attendees','player_goal'));
    }

    public function vote($id, $team_id)
    {
        // dd($id);
        $check_vote = voting::where('match_fixture_id',$this->fixture_id)->where('fan_id',Auth::user()->id)->first();
        if($check_vote)
        {
            $voting = voting::find($check_vote->id);
            $voting->team_id = $team_id;
            $voting->player_id = $id;
            $voting->save();
        }
        else
        {
            $voting = new voting();
            $voting->match_fixture_id = $this->fixture_id;
            $voting->team_id = $team_id;
            $voting->player_id = $id;
            $voting->fan_id = Auth::user()->id;
            $voting->save();
        }

    }

    // squad selection
    public function test()
    {
        dd('test');
    }
}
