<?php

namespace App\Livewire\Team;

use App\Models\Team_member;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditTeamLogo extends Component
{
    use WithFileUploads;

	public $team, $team_id;
	public $teamlogo_id;
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
		$logo = Team::find($this->team_id);
		$this->teamlogo_id = $logo->id;
		$team_admins = Team_member::where('team_id',$this->team_id)->where('member_position_id',4)->where('invitation_status',1)->pluck('member_id');
		$admins = $team_admins->toArray();
        return view('livewire.team.edit-team-logo', compact('logo','admins'));
    }

    public function open_editteam_logo()
	{
		$this->dispatch('OpenteamlogoModal');
	}
	public function close_editteam_logo()
	{
		$this->dispatch('CloseteamlogoModal');
	}
}
