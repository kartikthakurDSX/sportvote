<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\user_sport_cerification;
use App\Models\user_sport_membership;
use App\Models\user_profile;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Certificate extends Component
{
    use WithPagination;
    public function render()
    {

        $certification = user_sport_cerification::where('user_id',Auth::user()->id)->with('user','sports')->paginate(4,['*'], 'certificate');
        $membership = user_sport_membership::where('user_id',Auth::user()->id)->with('user','sports')->paginate(4,['*'], 'membership');
        $userplayer = user_profile::where('user_id',Auth::user()->id)->with('sport','sport_level','sport_attitude','level')->paginate(4,['*'], 'userplayer');
        return view('livewire.certificate',['certification' => $certification, 'membership' => $membership,'userplayer' => $userplayer]);
    }
}
