<?php

namespace App\Livewire\Dashboard;
use App\Models\Match_fixture_stat;
use App\Models\Match_fixture;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyStat extends Component
{
	public $is_stat = 1;
	public $my_teams;
	public $my_team_logo;
    public function render()
    {
		$my_stat = Match_fixture_stat::where('player_id', Auth::user()->id)->get();
		if($my_stat->isNotEmpty())
		{
			$this->teams = $my_stat->groupBy('team_id');
			$my_stat_team = Match_fixture_stat::where('player_id', Auth::user()->id)->first();
			$this->my_team_logo = Team::find($my_stat_team->team_id);
		}
		else
		{
			$this->is_stat = 0;
		}

        return view('livewire.dashboard.my-stat');
    }
}
