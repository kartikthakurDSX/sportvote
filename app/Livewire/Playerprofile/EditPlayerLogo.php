<?php

namespace App\Livewire\Playerprofile;

use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditPlayerLogo extends Component
{
    use WithFileUploads;

    public $player_id ;

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

    public function mount($player)
    {
        $this->player_id = $player;
    }
    public function render()
    {
        $player_info = User::find($this->player_id);
        return view('livewire.playerprofile.edit-player-logo',compact('player_info'));
    }

    public function open_editplayerprofile_logo()
	{
		$this->dispatch('OpenplayerprofilelogoModal');
	}
	public function close_editplayerprofile_logo()
	{
		$this->dispatch('CloseplayerprofilelogoModal');
	}
}
