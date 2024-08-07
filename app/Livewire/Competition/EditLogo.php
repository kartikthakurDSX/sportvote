<?php

namespace App\Livewire\Competition;

use App\Models\Competition;
use App\Models\Comp_member;
use Livewire\Component;

class EditLogo extends Component
{
    public $complogo_id;

    public $listeners = ['refreshData'];


    public function refresh()
    {
        $this->dispatch('$refresh');
    }
    public function refreshData()
    {
        $this->dispatch('refreshDataComplete'); // Optional: Emit an event to signal that data refresh is complete
    }

    public function mount($comp_id)
    {
        $this->complogo_id = $comp_id;
    }

    public function render()
    {
        $competition = Competition::findOrFail($this->complogo_id);

        $comp_admins = Comp_member::with('member')
            ->whereIn('member_position_id', [7])
            ->where('invitation_status', 1)
            ->where('is_active', 1)
            ->where('comp_id', $competition->id)
            ->pluck('member_id');

        $admins = $comp_admins->toArray();

        return view('livewire.competition.edit-logo', compact('competition', 'admins'));
    }

    public function open_editcomp_logo()
    {
        $this->dispatch('OpencomplogoModal');
    }

    public function close_comp_logo()
    {
        $this->dispatch('ClosecomplogoModal');
    }
}



// namespace App\Livewire\Competition;
// use App\Models\Competition;
// use App\Models\Comp_member;
// use Livewire\Component;

// class EditLogo extends Component
// {
// 	public $complogo_id;
// 	public function mount($comp_id)
//     {
//         $this->complogo_id = $comp_id;
//     }
//     public function render()
//     {
// 		$competition = Competition::find($this->complogo_id);
// 		$comp_admins = Comp_member::where('comp_id',$competition->id)->where('member_position_id',7)->where('invitation_status',1)->where('is_active', 1)->with('member')->pluck('member_id');
// 		$admins = $comp_admins->toArray();
//         return view('livewire.competition.edit-logo',compact('competition','admins'));
//     }
// 	public function open_editcomp_logo()
// 	{
// 		$this->dispatch('OpencomplogoModal');
// 	}
// 	public function close_comp_logo()
// 	{
// 		$this->dispatch('ClosecomplogoModal');
// 	}

// }

