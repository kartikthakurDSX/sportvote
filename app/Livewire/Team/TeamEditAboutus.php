<?php

namespace App\Livewire\Team;
use App\Models\Team;
use App\Models\Team_member;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Trix;
use Livewire\Component;

class TeamEditAboutus extends Component
{
	public $body;
	public $is_save = 1;
	public $max_char;
	public $msg;

	public function mount($id)
	{
		$this->team_id = $id;
		$team = Team::find($this->team_id);
		$this->body = $team->description;
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
		$edit_team_desc = Team::find($this->team_id);
		$edit_team_desc->description = $this->body;
		$edit_team_desc->save();
		$this->dispatch('ClosedescModal');
		return redirect(route('team.show', $this->team_id));
    }


	public $team_desc;
	public $team_id;



	protected function rules()
    {

        return [
            'team_desc' => 'required|string',
        ];

    }
    protected $messages = [
        'team_desc.required' => 'Team description cannot be empty.',
    ];


    public function render()
    {
		$team = Team::find($this->team_id);
		$team_admins = Team_member::where('team_id',$this->team_id)->where('member_position_id',4)->where('invitation_status',1)->pluck('member_id');
		$admins = $team_admins->toArray();
        return view('livewire.team.team-edit-aboutus',compact('team','admins'));
    }

	public function edit_team_desc()
	{
		//$this->dispatch('ck_editor');
		$this->dispatch('OpendescModal');
	}

	public function closemodal()
	{
		$this->dispatch('ClosedescModal');
		return redirect(route('team.show', $this->team_id));
	}


}
