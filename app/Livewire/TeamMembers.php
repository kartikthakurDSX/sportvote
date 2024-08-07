<?php

namespace App\Livewire;
use App\Models\Team_member;
use Livewire\Component;

class TeamMembers extends Component
{
    public $team;

    public function mount($team_id)
    {
        $this->team = $team_id;
    }
    public function render()
    {
        $team_id = $this->team;
        $team_member = Team_member::where('team_id',$team_id)->with('member_position','members')->get();
        return view('livewire.team-members',compact('team_member'));
    }
    public function remove_member($id)
    {
        $team_member = Team_member::find($id);
        $team_member->invitation_status = 3;
        $team_member->save();
    }
}
