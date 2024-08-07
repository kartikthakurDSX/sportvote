<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Competition_attendee;
use Illuminate\Support\Facades\Auth;


class PlayerStat extends Component
{
    public function render()
    {
        $competition_attendee = Competition_attendee::where('attendee_id',Auth::user()->id)->get();
        return view('livewire.player-stat',['competition_attende' => $competition_attendee]);
    }
}
