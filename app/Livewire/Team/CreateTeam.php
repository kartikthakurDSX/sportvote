<?php

namespace App\Livewire\Team;

use Livewire\Component;
use App\Models\Team;
use App\Models\Team_member;
use Illuminate\Support\Facades\Auth;

class CreateTeam extends Component
{
	public $listeners = ['refreshData'];


	public function refresh()
    {
		$this->dispatch('$refresh');
        // Your logic to refresh data goes here
        // For example, you can fetch updated data and update public properties used in the component
    }
    public function refreshData()
    {
        // Your logic to refresh data goes here
        // For example, you can fetch updated data and update public properties used in the component
        $this->dispatch('refreshDataComplete'); // Optional: Emit an event to signal that data refresh is complete
    }

    public function render()
    {
		$team = Team::where('is_active',0)->latest()->first();
		if(!empty($team))
		{
			if($team->user_id == Auth::user()->id)
			{
				$team_members = Team_member::where('team_id',$team->id)->where('invitation_status','!=',3)->with('member_position','members')->get();
			}
			else
			{
				$team_members = "";
			}
		}
		else
		{
			$team_members = "";
		}

        return view('livewire.team.create-team',compact('team_members','team'));
    }
	public function cancel_request($id)
	{
		$team_mem = Team_member::find($id);
		$team_mem->invitation_status = 3;
		$team_mem->save();
	}


}
