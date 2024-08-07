<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Team;
use App\Models\SportGroundPosition;
use App\Models\Match_fixture;
use App\Models\Competition;
use App\Models\Competition_attendee;

class MatchFixtureSquardTeamOne extends Component
{
    public $fixture_id;

    public function mount($match_fixture_id)
    {
        $this->fixture_id = $match_fixture_id;
    }
    public function render()
    {
        $match_fixture = Match_fixture::find($this->fixture_id);
        $teamOne = Team::find($match_fixture->teamOne_id);
        $ground_map_position = SportGroundPosition::all();
        $competition = Competition::find($match_fixture->competition_id);
        $teamOne_attendees = Competition_attendee::where('team_id',$teamOne->id)->where('competition_id',$match_fixture->competition_id)->get();
        return view('livewire.match-fixture-squard-team-one',compact('teamOne','ground_map_position','competition','match_fixture','teamOne_attendees'));
    }
}
