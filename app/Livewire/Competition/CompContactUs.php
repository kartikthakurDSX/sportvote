<?php

namespace App\Livewire\Competition;
use App\Models\Competition;
use Livewire\Component;

class CompContactUs extends Component
{
    public $compid;
    public function mount($comp_id)
    {
        $this->compid = $comp_id;
    }
    public function render()
    {
        $comp_info = Competition::select('id','comp_email','comp_phone_number','comp_address')->find($this->compid);
        $comp_email = $comp_info->comp_email;
        $comp_phone_number = $comp_info->comp_phone_number;
        $comp_address = $comp_info->comp_address;
        return view('livewire.competition.comp-contact-us',compact('comp_email','comp_phone_number','comp_address'));
    }
}
