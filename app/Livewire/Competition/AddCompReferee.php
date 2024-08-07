<?php

namespace App\Livewire\Competition;

use Livewire\Component;
use App\Models\Comp_member;
use App\Models\Member_position;
use App\Models\Notification;

use Livewire\WithPagination;
class AddCompReferee extends Component
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
    $competition_member = Comp_member::where('comp_id',$competition->id)->where('member_position_id', 6)->whereIn('invitation_status',[0,1])->where('is_active', 1)->with('member','member_position')->latest()->paginate(4);
    $this->adminstration = $competition;
    return view('livewire.competition.add-comp-referee',compact('competition_member','competition'));
  }
	public function cancel_request($id)
	{
		$comp_member = Comp_member::find($id);
		$comp_member->invitation_status = 3;
		$comp_member->save();
    $notification = Notification::where('notify_module_id',4)->where('type_id',$id)->where('reciver_id',$comp_member->member_id)->update(['is_active' => 0, 'is_seen' => 1]);
	}
}
