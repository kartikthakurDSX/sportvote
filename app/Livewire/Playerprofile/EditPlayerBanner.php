<?php

namespace App\Livewire\Playerprofile;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditPlayerBanner extends Component
{
    use WithFileUploads;

    public $player, $player_id;
    public $listeners = ['refreshData'];


	public function refresh()
    {
		$this->dispatch('$refresh');
    }
    public function refreshData()
    {
        $this->dispatch('refreshDataComplete'); // Optional: Emit an event to signal that data refresh is complete
    }
    public function mount($player)
    {
        $this->player_id = $player;
    }

    public function render()
    {
        $playerprofilebanner = User::select('id','banner')->find($this->player_id);

		return view('livewire.playerprofile.edit-player-banner', compact('playerprofilebanner'));
    }

    public function open_editplayer_banner()
	{
		$this->dispatch('OpenplayerbannerModal');
	}
	public function close_editplayer_banner()
	{
		$this->dispatch('CloseplayerbannerModal');
	}
}
