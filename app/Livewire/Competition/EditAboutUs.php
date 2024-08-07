<?php

namespace App\Livewire\Competition;
use App\Models\Competition;
use App\Models\Comp_member;
use Livewire\Component;
use App\Livewire\Trix;

class EditAboutUs extends Component
{
    public $body;
	public $is_save = 1;
	public $max_char;
	public $msg;

	public function mount($competition)
    {
        $this->comp_id = $competition;
		$competition = Competition::find($this->comp_id);
		$this->body = $competition->description;
	}
	public $listeners = [
        Trix::EVENT_VALUE_UPDATED // trix_value_updated()
    ];
	public function trix_value_updated($value){
		if(strlen($value) < 500)
		{
			$this->body = $value;
			$this->is_save = 1;
			$this->max_char =   500 - strlen($value);
		}
		else
		{
			$this->is_save = 0;
			$this->max_char =   500 - strlen($value);
			$this->msg = "You can not use more than 500 characters.";
		}
    }
	public function save(){
        //dd($this->body);
		$edit_comp_desc = Competition::find($this->comp_id);
		$edit_comp_desc->description = $this->body;
		$edit_comp_desc->save();
		$this->dispatch('ClosedescModal');
		//return redirect(route('competition.show', $this->comp_id));
    }

	public $comp_id;
	public $comp_desc;

    public function render()
    {

		$competition = Competition::find($this->comp_id);
		$comp_admins = Comp_member::where('comp_id',$this->comp_id)->where('member_position_id',7)->where('invitation_status',1)->where('is_active', 1)->pluck('member_id');
		$admins = $comp_admins->toArray();
        return view('livewire.competition.edit-about-us',compact('competition','admins'));
    }
	public function edit_comp_desc()
	{
		// $this->dispatch('ck_editor');
		$this->dispatch('OpendescModal');
	}
	public function closemodal()
	{
		$this->dispatch('ClosedescModal');
		//return redirect(route('competition.show', $this->comp_id));
	}
	// public function save_desc()
	// {
	// 	$edit_comp_desc = Competition::find($this->comp_id);
	// 	$edit_comp_desc->description = $this->comp_desc;
	// 	$edit_comp_desc->save();
	// 	$this->dispatch('ClosedescModal');
	// 	return redirect(route('competition.show', $this->comp_id));
	// }
}
