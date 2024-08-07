<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Team_member;
use App\Models\Member_position;
use App\Models\User;

class TeamPlayer extends Component
{
    public $player;
    public $player_position_id;
    public $player_jersey_number;
    public $tm_id;
    public $add_class= "";

    protected  $rules  = [
        'player_jersey_number' => 'numeric|min:0|max:99',
    ];

    protected $messages = [
        'player_jersey_number.numeric' => 'Please enter only number value.',
        'player_jersey_number.min' => 'Player jersey number should be between 0 to 99.',
        'player_jersey_number.max' => 'Player jersey number should be between 0 to 99.',
    ];
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
        $this->player = $team;
    }
    public function render()
    {
        $this->dispatch('owlscript');
        $this->dispatch('added_player');

        $team = $this->player;
        $player_member_position = Member_position::where('member_type',1)->orderBy('position_sequence')->get();
        $player_position_ids =  Member_position::where('member_type',1)->pluck('id');
        $team_member = Team_member::select('id','jersey_number','member_position_id','member_id','team_id','invitation_status')->whereIn('member_position_id',$player_position_ids)->where('team_id',$team->id)->where('invitation_status',1)->with('members:id,first_name,last_name,dob,height,location,profile_pic,email','member_position:id,name','team:id,team_color,user_id')->where('is_active',1)->get();
        $member_position = Member_position::select('id')->where('member_type',1)->get();
        $requested_player = Team_member::where('team_id',$team->id)->where('invitation_status',0)->where('is_active',1)->get();

        $total_player = 0;
        $goalkeeper = 0;
        $striker = 0;
        $midfielder =0;
        $defender =0;

        foreach($player_member_position as $mp)
        {
           foreach($team_member as $tm)
           {
               if($tm->member_position_id == $mp->id)
               {
                   $total_player++;
               }
           }
        }
		$team_admins = Team_member::where('team_id',$team->id)->where('member_position_id',4)->where('invitation_status',1)->pluck('member_id');
       $admins = $team_admins->toArray();

        return view('livewire.team-player',compact('team','player_member_position','member_position','team_member','total_player','admins','requested_player'));
    }
	public function remove_player($id)
	{

		$remove_player_team = Team_member::find($id);
		$remove_player_team->invitation_status = 3;
		$remove_player_team->save();
	}
    public function edit_player_info($team_member_id)
    {
        $this->dispatch('owlcrsl');
        $this->tm_id = $team_member_id;
        $player_team_member = Team_member::find($team_member_id);
        $this->player_position_id = $player_team_member->member_position_id;
        $this->player_jersey_number = $player_team_member->jersey_number;
        $this->dispatch('openeditModal');

    }
    public function closeeditModal()
    {
        $this->dispatch('closeeditModal');
        return redirect(route('team.show', $this->player->id));
    }
    public function save_info($id)
    {
        $check_jersey_number = Team_member::where('team_id',$this->player->id)->where('jersey_number',$this->player_jersey_number)->first();
        if($this->player_jersey_number != '')
        {
            $this->validate([
                'player_jersey_number' => 'numeric|min:0|max:99',
            ]);
            // dd($this->player_jersey_number);
            if(empty($check_jersey_number))
            {
                $update_team_member = Team_member::find($id);
                $update_team_member->jersey_number = $this->player_jersey_number;
                $update_team_member->member_position_id = $this->player_position_id;
                $update_team_member->save();
                $this->dispatch('closeeditModal');
               return redirect(route('team.show', $this->player->id));
            }
            else
            {
                $update_team_member = Team_member::find($id);
                $player_info = User::find($check_jersey_number->member_id);
                if($check_jersey_number->member_id == $update_team_member->member_id)
                {
                    $update_team_member->jersey_number = $this->player_jersey_number;
                    $update_team_member->member_position_id = $this->player_position_id;
                    $update_team_member->save();
                    $this->dispatch('closeeditModal');
                    return redirect(route('team.show', $this->player->id));
                }
                else
                {

                    $this->dispatch('swal:modal', [

                        'message' => 'Jersey number is already provide to'.$player_info->first_name.' '.$player_info->last_name.' in this team. Please choose another one.',

                    ]);
                }

            }
        }
        else
        {
            $this->validate([
                'player_jersey_number' => 'numeric|min:0|max:99',
            ]);
            $update_team_member = Team_member::find($id);
            $update_team_member->member_position_id = $this->player_position_id;
            $update_team_member->save();
            $this->dispatch('closeeditModal');
            return redirect(route('team.show', $this->player->id));
        }
    }
}
