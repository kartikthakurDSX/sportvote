<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use App\Models\Match_fixture;
use App\Models\Match_fixture_stat;
use App\Models\voting;
use Livewire\Component;
use Livewire\WithPagination;

class UserVoteIntraction extends Component
{
    use WithPagination;
    public $listeners = ['refreshData'];


	public function refresh()
    {
		$this->dispatch('$refresh');
    }
    public function refreshData()
    {
        $this->dispatch('refreshDataComplete'); // Optional: Emit an event to signal that data refresh is complete
    }
	public function render()
    {
        if(Auth::check())
        {
            $user_id = Auth::user()->id;
        }
        else
        {
            $user_id = "";
        }

		$uservoteintractions = voting::where('fan_id', $user_id)->with('user', 'team', 'player', 'matchFixture')->latest()->paginate(3,['*'], 'user_vote_intraction')->onEachSide(1);
		// dd($uservoteintractions);
        return view('livewire.user-vote-intraction',['uservoteintraction' => $uservoteintractions]);
    }

}
