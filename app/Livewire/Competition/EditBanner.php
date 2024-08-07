<?php

namespace App\Livewire\Competition;
use App\Models\Competition;
use App\Models\Comp_member;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditBanner extends Component
{
	use WithFileUploads;
	public $competition_id;
	public $banner;
    public $admins;
    public $competition;
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
        $this->competition_id = $comp_id;
    }

	public function open_edit_banner()
	{
		$this->dispatch('OpenbannerModal');
	}
	public function close_edit_banner()
	{
		$this->dispatch('ClosebannerModal');
	}
	public function edit_comp_banner()
    {
        $this->banner->store('files', 'public');
	    $banner = $this->banner->hashName();
        $compbanner = Competition::find($this->competition_id);
        $compbanner->comp_banner = $banner;
        $compbanner->save();
        if($compbanner){
            $this->dispatch('ClosebannerModal');
        }
		return redirect(route('competition.show', $this->competition_id));
    }
    // public function render()
    // {
    //     $this->competition = Competition::find($this->competition_id);
	// 	$comp_admins = Comp_member::where('comp_id',$this->competition->id)->where('member_position_id',7)->where('invitation_status',1)->where('is_active', 1)->with('member')->pluck('member_id');
	// 	$this->admins = $comp_admins->toArray();
    //     return view('livewire.competition.edit-banner');
    // }
    public function render()
    {
        $this->competition = Competition::findOrFail($this->competition_id);

        $comp_admins = Comp_member::where('comp_id', $this->competition->id)
            ->where('member_position_id', 7)
            ->where('invitation_status', 1)
            ->where('is_active', 1)
            ->with('member')
            ->select('member_id')
            ->pluck('member_id');

        $this->admins = $comp_admins->toArray();

        return view('livewire.competition.edit-banner');
    }

}
