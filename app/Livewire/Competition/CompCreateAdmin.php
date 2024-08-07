<?php

namespace App\Livewire\Competition;
use App\Models\Comp_member;
use Livewire\Component;

class CompCreateAdmin extends Component
{
	public $id;
	public function mount($comp_id)
	{
		$this->id = $comp_id;
	}
    public function render()
    {
		dd($this->id);
		$competition_member = Comp_member::where('comp_id',$this->comp_id)->with('member','member_position')->get();
        return view('livewire.competition.comp-create-admin',compact('competition_member'));
    }
}
