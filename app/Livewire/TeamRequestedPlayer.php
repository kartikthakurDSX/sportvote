<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Team_member;
use App\Models\Notification;
use App\Models\Member_position;
use Livewire\WithPagination;

class TeamRequestedPlayer extends Component
{
    use WithPagination;
    public $adminstration;
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

	public function mount($team)
    {
        $this->adminstration = $team;
    }
    public function render()
    {
		$team = $this->adminstration;
		$player_position_ids = Member_position::where('member_type',1)->pluck('id');
		$team_member = Team_member::where('team_id',$team->id)->whereIn('member_position_id',$player_position_ids)->where('invitation_status',0)->with('member_position','members')->latest()->paginate(4);
        return view('livewire.team-requested-player',compact('team_member'));
    }

	public function cancel_request($id)
	{
		$team_member = Team_member::find($id);
		$team_member->invitation_status = 3;
		$team_member->save();
		// delete notification
		$delete_noti = Notification::where('notify_module_id',2)->where('type_id',$id)->delete();

	}
}
