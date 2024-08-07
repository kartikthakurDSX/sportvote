<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Comp_member;
use App\Models\Member_position;
use App\Models\Notification;

use Livewire\WithPagination;

class CompetitionAdminstration extends Component
{
    use WithPagination;
    public $adminstration;

    public function mount($competition)
    {
        $this->adminstration = $competition;
    }
    public function render()
    {
		$this->dispatch('addadmin');
        $competition = $this->adminstration;
        $competition_member = Comp_member::where('comp_id',$competition->id)->where('member_position_id',7)->whereIn('invitation_status',[0,1])->where('is_active', 1)->with('member','member_position')->latest()->paginate(4);
        $comp_admins = Comp_member::where('comp_id',$competition->id)->where('member_position_id',7)->where('invitation_status',1)->where('is_active', 1)->pluck('member_id');
		$admins = $comp_admins->toArray();
        return view('livewire.competition-adminstration',compact('competition_member','competition'));
    }
	public function cancel_request($id)
	{
		$comp_member = Comp_member::find($id);
		$comp_member->invitation_status = 3;
		$comp_member->save();
        $notification = Notification::where('notify_module_id',4)->where('type_id',$id)->where('reciver_id',$comp_member->member_id)->update(['is_active' => 0, 'is_seen' => 1]);

	}

}
