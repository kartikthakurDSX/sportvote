<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Team_member;
use App\Models\User;
use App\Models\Member_position;
use Livewire\WithPagination;

class TeamAdminstration extends Component
{
    use WithPagination;
    public $adminstration;

    public function mount($team)
    {
        $this->adminstration = $team;
    }
    public function render()
    {
        $team = $this->adminstration;

        $member_position = Member_position::where('member_type',2)->get();

        $admin_position_ids = Member_position::where('member_type',2)->pluck('id');
		$team_member = Team_member::where('team_id',$team->id)->whereIn('member_position_id',$admin_position_ids)->with('member_position','members')->latest()->paginate(4);
        $team_admins = Team_member::where('team_id',$team->id)->where('member_position_id',4)->where('invitation_status',1)->pluck('member_id');
		$admins = $team_admins->toArray();
		$team_owner = User::find($team->user_id);
		$player_position_ids = Member_position::where('member_type',1)->where('is_active',1)->pluck('id');
		$requested_player = Team_member::with('member_position','members')->where('team_id',$team->id)->where('invitation_status',0)->where('is_active',1)->whereIn('member_position_id',$player_position_ids)->latest()->paginate(4);
        return view('livewire.team-adminstration',compact('team_member','team_owner','member_position','admins','requested_player'));
    }
	public function cancel_request($id)
	{
		$team_member = Team_member::find($id);
		$team_member->invitation_status = 3;
		$team_member->save();
	}
}
