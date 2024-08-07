<?php

namespace App\Livewire\Competition;

use App\Models\Comp_sponser;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditcommunitySponsor extends Component
{

    use WithFileUploads;
    public $competition;
    public $sponsor_id;
    public $sponsor_name;
    public $sponsor_image;

    public function mount($competition)
    {
        $this->comp_id = $competition;
        $comp_sponsor = Comp_sponser::where('type', 2)
        ->where('user_id', Auth::user()->id)->where('comp_id', $this->comp_id)
        ->first();
		if(!empty($comp_sponsor))
		{
        $this->sponsor_id = $comp_sponsor->id;
        $this->sponsor_name = $comp_sponsor->sponsor_name;
		}
    }

    public function render()
    {
        $comp_sponsor = Comp_sponser::where('type', 2)
                        ->where('user_id', Auth::user()->id)->where('comp_id', $this->comp_id)
                        ->first();
		if(!empty($comp_sponsor))
		{
			$sponsorimage = $comp_sponsor->sponsor_image;
		}
		else
		{
			$sponsorimage = "";
		}

        return view('livewire.competition.editcommunity-sponsor', compact('sponsorimage'));
    }

    public function editcommunity_sponsor()
    {
        $this->sponsor_image->store('image','public');
	    $sponsor_image = $this->sponsor_image->hashName();
        $sponsor = Comp_sponser::find($this->sponsor_id);
        $sponsor->type = 2;
        $sponsor->sponsor_name = $this->sponsor_name;
        $sponsor->sponsor_image = $sponsor_image;
        $sponsor->save();
        $this->dispatch('CloseeditcommunitysponserModal');
    }

    public function open_editcommunity_sponsor()
	{
		$this->dispatch('OpeneditcommunitysponserModal');
	}
	public function close_editcommunity_sponsor()
	{
		$this->dispatch('CloseeditcommunitysponserModal');
	}

}
