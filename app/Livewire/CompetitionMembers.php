<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Comp_member;
use App\Models\Competition_team_request;

class CompetitionMembers extends Component
{
    public $competition;

    public function mount($comp_id)
    {
        $this->competition = $comp_id;
    }
    public function render()
    {
        $comp_id = $this->competition;
        $comp_member = Comp_member::where('comp_id',$comp_id)->with('competition','member','member_position')->get();
        $comp_team = Competition_team_request::where('competition_id',$comp_id)->with('competition','team')->get();
        return view('livewire.competition-members',compact('comp_member','comp_team'));
    }

    public function remove_member($id)
    {
        $comp_member = Comp_member::find($id);
        $comp_member->invitation_status = 3;
        $comp_member->save();
    }

    public function remove_team($id)
    {
        $comp_team = Competition_team_request::find($id);
        $comp_team->request_status = 3;
        $comp_team->save();
    }

}
