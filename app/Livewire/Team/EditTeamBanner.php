<?php

namespace App\Livewire\Team;

use Livewire\Component;
use App\Models\Team_member;
use App\Models\Team;
use Livewire\WithFileUploads;

class EditTeamBanner extends Component
{
    use WithFileUploads;
    public $team, $team_id;
    public $banner;
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
        $this->team_id = $team;
    }

    public function render()
    {
        $this->team = Team::find($this->team_id);
		$team_admins = Team_member::where('team_id',$this->team_id)->where('member_position_id',4)->where('invitation_status',1)->pluck('member_id');
		$admins = $team_admins->toArray();
        return view('livewire.team.edit-team-banner',compact('admins'));
    }
    public function edit_team_banner()
    {
        $this->banner->store('banner', 'public');
	    $baner = $this->banner->hashName();
        $teambanner = Team::find($this->team_id);
        $teambanner->team_banner = $baner;
        $teambanner->save();
        if($teambanner){
            $this->dispatch('CloseteambannerModal');
        }
    }

    public function open_editteam_banner()
	{
		$this->dispatch('OpenteambannerModal');
	}
	public function close_editteam_banner()
	{
		$this->dispatch('CloseteambannerModal');
	}
}
