<?php

namespace App\Livewire\Playerprofile;
use App\Models\Match_fixture_stat;
use App\Models\Match_fixture;
use App\Models\Team;
use App\Models\Team_member;
use App\Models\User_profile;
use Livewire\Component;

class MyStat extends Component
{
	public $playerid;
	public $competition_id;
	public $comp_id;
	public $deak_id;
	public $team;
	public $squad_position;
	public $all_goals;
	public $all_yellow_card;
	public $all_red_card;
	public $all_passed;
	public $my_goals;
	public $my_yellow_card;
	public $my_red_card;
	public $my_passed;
	public $passes_prec;
	public $goal_prec;
	public $yellow_card_prec;
	public $red_card_prec;
	public $onload = 1;
	public $comp_index = 0;
	public $comp_ids = [];
	public $next_comp_id;
	public $next_comp_matches;

	public $next_team;
	public $next_squad_position;
	public $next_all_passed;
	public $next_all_yellow_card;
	public $next_all_red_card;
	public $next_all_goals;

	public function mount($player_id)
	{
		$this->playerid = $player_id;
	}
    public function render()
    {
		$check_player = User_profile::where('user_id',$this->playerid)->first();
		if(!empty($check_player))
		{
			$my_stat = Match_fixture_stat::where('player_id', $this->playerid)->get();
			$fixture_played = array();
			foreach($my_stat as $stat)
			{
				$fixture_played[] = $stat->match_fixture_id;
			}
			$fixture_ids = array_values(array_unique($fixture_played));
			$competitions = Match_fixture::whereIn('id',$fixture_ids)->pluck('competition_id');
			$this->comp_ids = array_values(array_unique($competitions->toArray()));
			if($this->onload == 1)
			{
				$first_comp_matches = Match_fixture::where('competition_id',$this->comp_ids[$this->comp_index])->pluck('id')->first();
				$first_team = Match_fixture_stat::where('match_fixture_id',$first_comp_matches)->where('player_id',$this->playerid)->first();
				$first_match_fixture = $first_team->match_fixture_id;
					$this->team = Team::find($first_team->team_id);
					$this->squad_position = Team_member::where('team_id',$this->team->id)->where('member_id',$this->playerid)->with('member_position')->first();

					$this->all_goals = 0;
					$this->all_yellow_card = 0;
					$this->all_red_card = 0;
					$this->all_passed = 0;
					$all_stats = Match_fixture_stat::where('match_fixture_id',$first_match_fixture)->where('team_id',$this->team->id)->get();
					foreach($all_stats as $stat)
					{
						if($stat->sport_stats_id == 1)
						{
							$this->all_goals++ ;
						}
						if($stat->sport_stats_id == 2)
						{
							$this->all_yellow_card++ ;
						}
						if($stat->sport_stats_id == 3)
						{
							$this->all_red_card++ ;
						}
						if($stat->sport_stats_id == 5)
						{
							$this->all_passed++;
						}
					}

					$this->my_goals = 0;
					$this->my_yellow_card = 0;
					$this->my_red_card = 0;
					$this->my_passed = 0;
					$my_team_stat = Match_fixture_stat::where('match_fixture_id',$first_match_fixture)->where('team_id',$this->team->id)->where('player_id',$this->playerid)->get();
					foreach($my_team_stat as $stat)
					{
						if($stat->sport_stats_id == 1)
						{
							$this->my_goals++ ;
						}
						if($stat->sport_stats_id == 2)
						{
							$this->my_yellow_card++ ;
						}
						if($stat->sport_stats_id == 3)
						{
							$this->my_red_card++ ;
						}
						if($stat->sport_stats_id == 5)
						{
							$this->my_passed++;
						}
					}
					if($this->all_passed > 0)
					{
						$this->passes_prec = $this->my_passed / $this->all_passed;
					}
					else
					{
						$this->passes_prec = "0.00";
					}
					if($this->all_red_card > 0)
					{
						$this->red_card_prec = $this->my_red_card / $this->all_red_card;
					}
					else
					{
						$this->red_card_prec = "0.00";
					}
					if($this->all_yellow_card > 0)
					{
						$this->yellow_card_prec = $this->my_yellow_card / $this->all_yellow_card;
					}
					else
					{
						$this->yellow_card_prec = "0.00";
					}
					if($this->all_goals > 0)
					{
						$this->goal_prec = $this->my_goals / $this->all_goals;
					}
					else
					{
						$this->goal_prec = "0.00";
					}
			}

		}
		else
		{
			dd('Not a player profile');
		}

        return view('livewire.playerprofile.my-stat');
    }
	public function next_data()
	{
		$max_count = count($this->comp_ids);
		if($this->comp_index < $max_count)
		{
			$this->comp_index = $this->comp_index + 1;
		}
		else
		{
			$this->comp_index = 0;
		}

	}
	public function prev_data()
	{

		if($this->comp_index > 0)
		{
			$this->comp_index = $this->comp_index - 1;
		}
		else
		{
			$this->comp_index = 0;
		}

	}
}
