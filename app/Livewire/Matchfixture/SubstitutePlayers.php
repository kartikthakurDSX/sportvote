<?php

namespace App\Livewire\Matchfixture;
use App\Models\Match_fixture;
use App\Models\Competition_attendee;
use App\Models\Fixture_squad;
use Livewire\Component;

class SubstitutePlayers extends Component
{
    public $fixture_id;
    public $team_id;
    public $lineup_player_fixture_id;
    public $substitute_player;
    public function mount($match_fixture_id, $team_id)
    {
        $this->fixture_id = $match_fixture_id;
        $this->team_id = $team_id;
    }
    public function render()
    {
        $match_fixture = Match_fixture::select('competition_id')->find($this->fixture_id);
        $fixture_players_ids = Fixture_squad::where('match_fixture_id',$this->fixture_id)->where('team_id',$this->team_id)->where('is_active',1)->pluck('player_id');
        $comp_attendee = Competition_attendee::select('attendee_id')->where('Competition_id',$match_fixture->competition_id)->where('team_id', $this->team_id)->wherenotIn('attendee_id',$fixture_players_ids)->with('player:first_name,last_name,id')->get();
        //echo $comp_attendee;
        $fixture_players = Fixture_squad::select('id','player_id')->where('match_fixture_id',$this->fixture_id)->where('team_id',$this->team_id)->where('is_active',1)->with('player:first_name,last_name,id')->get();
        return view('livewire.matchfixture.substitute-players',compact('comp_attendee','fixture_players'));
    }
    public function open_modal($player_id)
    {
       $this->substitute_player = $player_id;
       //dd($this->substitute_player);
        $this->dispatch('ChangePlayer');
    }
    public function closemodal()
    {
        $this->dispatch('CloseChangePlayer');
    }
    public function save_data()
    {
        if($this->lineup_player_fixture_id)
        {
            $change_player = Fixture_squad::find($this->lineup_player_fixture_id);
            $change_player->player_id =  $this->substitute_player;
            $change_player->save();
            $this->substitute_player = "";
            $this->lineup_player_fixture_id ="";
            $this->dispatch('CloseChangePlayer');
        }


    }
}
