<?php

namespace App\Livewire\Competition;
use App\Models\User;
use Livewire\Component;

class AddAdmin extends Component
{
    public function render()
    {

		$user = User::get();
        return view('livewire.competition.add-admin',compact('user'));
    }

		public function add_admins()
	{
		$this->dispatch('addadmin');
		$this->dispatch('addadminModal');

	}

	public function closeadminmodal()
	{
		$this->dispatch('closeadminmodal');
	}
}
