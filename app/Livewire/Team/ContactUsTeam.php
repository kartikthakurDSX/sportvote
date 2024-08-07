<?php

namespace App\Livewire\Team;
use App\Models\Team;
use Livewire\Component;

class ContactUsTeam extends Component
{
    public $teamid;
    public function mount($team_id)
    {
        $this->teamid = $team_id;

    }
    public function render()
    {
        $team = Team::select('id','team_email','team_phone_number','team_address')->find( $this->teamid);
        $email = $team->team_email;
        $phone_number = $team->team_phone_number;
        $address = $team->team_address;
        return view('livewire.team.contact-us-team',compact('email','phone_number','address'));
    }
}
