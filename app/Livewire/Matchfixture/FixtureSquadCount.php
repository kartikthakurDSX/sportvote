<?php

namespace App\Livewire\Matchfixture;
use App\Models\SportGroundPosition;
use App\Models\Fixture_squad;
use Livewire\Component;

class FixtureSquadCount extends Component
{
    public $macth_fixture_id;
    public $team_id;
    public function mount($team_id, $match_fixture_id)
    {
        $this->macth_fixture_id = $match_fixture_id;
        $this->team_id = $team_id;
    }
    public function render()
    {
        $defender_position_ids = SportGroundPosition::where('ground_coordinates',2)->pluck('id');
		$team_defender = Fixture_squad::where('match_fixture_id',$this->macth_fixture_id)->where('team_id',$this->team_id)->whereIn('sport_ground_positions_id',$defender_position_ids)->where('is_active',1)->count();
		$defensive_ids = SportGroundPosition::where('ground_coordinates',3)->pluck('id');
		$team_defensive = Fixture_squad::where('match_fixture_id',$this->macth_fixture_id)->where('team_id',$this->team_id)->whereIn('sport_ground_positions_id',$defensive_ids)->where('is_active',1)->count();
		$medfielder_ids = SportGroundPosition::where('ground_coordinates',4)->pluck('id');
		$team_midfielder = Fixture_squad::where('match_fixture_id',$this->macth_fixture_id)->where('team_id',$this->team_id)->whereIn('sport_ground_positions_id',$medfielder_ids)->where('is_active',1)->count();
		$attacking_ids = SportGroundPosition::where('ground_coordinates',5)->pluck('id');
		$team_attacking = Fixture_squad::where('match_fixture_id',$this->macth_fixture_id)->where('team_id',$this->team_id)->whereIn('sport_ground_positions_id',$attacking_ids)->where('is_active',1)->count();
		$forward_ids = SportGroundPosition::where('ground_coordinates',6)->pluck('id');
		$team_forward = Fixture_squad::where('match_fixture_id',$this->macth_fixture_id)->where('team_id',$this->team_id)->whereIn('sport_ground_positions_id',$forward_ids)->where('is_active',1)->count();
        return view('livewire.matchfixture.fixture-squad-count',compact('team_defender','team_defensive','team_midfielder','team_attacking','team_forward'));

    }
    public function close_modal()
    {
        $this->dispatch('closeModal');
    }
}
