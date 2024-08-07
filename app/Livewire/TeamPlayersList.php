<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Team_member;

class TeamPlayersList extends Component
{
    public $player;

    public function mount($team)
    {
        $this->player = $team;
    }
    public function render()
    {
        $team = $this->player;
        $team_members = Team_member::where('team_id',$team)->with('team','members','member_position')->get();
        return view('livewire.team-players-list',compact('team_members'));
    }
}
