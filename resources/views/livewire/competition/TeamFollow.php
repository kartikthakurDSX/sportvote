<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User_fav_follow;
use App\Models\Notification;
use App\Models\Team;
use App\Models\Team_member;
use App\Models\Country;
use App\Models\User_profile;
use App\Models\Member_position;
use Illuminate\Support\Facades\Auth;

class TeamFollow extends Component
{
    public $msg = "";
    public $team_id;
	public $team_name;
	public $team_color;
	public $team_location;
	public $team_homeground_name;
	public $team_homeground_location;
    public $team_slogan;
    public $country_id;
    public $font_color;
    public $join_member_position;
    public $join_reason;

    public function mount($team)
    {
        $this->team_id = $team->id;
		$team = Team::find($team->id);
		$this->team_name = $team->name;
		$this->team_color = $team->team_color;
		$this->team_location = $team->location;
		$this->team_homeground_name = $team->homeGround;
		$this->team_homeground_location = $team->homeGround_location;
        $this->team_slogan = $team->team_slogan;
        $this->country_id = $team->country_id;
        $this->font_color = $team->font_color;
    }

    public function render()
    {
        $team_id = $this->team_id;
        $follower = User_fav_follow::Where('is_type',1)->where('type_id',$team_id)->where('Is_follow',1)->get();

       $team_admins = Team_member::where('team_id',$this->team_id)->where('member_position_id',4)->where('invitation_status',1)->pluck('member_id');
		$admins = $team_admins->toArray();
		$team_info = Team::find($team_id);
        $countries = Country::get();
        $player_position = Member_position::where('member_type',1)->where('is_active',1)->get();
        if(Auth::check())
        {
            $is_follower = User_fav_follow::Where('is_type',1)->where('user_id',Auth::user()->id)->where('type_id',$team_id)->where('Is_follow',1)->get();
            $is_follow = 0;
           if($is_follower->IsNotEmpty())
           {
            foreach($is_follower as $follow)
            {
                if($follow->user_id)
                {
                    $is_follow = 1;
                }
            }
           }
           $user_profile = User_profile::where('user_id',Auth::user()->id)->where('profile_type_id',2)->first();
			if($user_profile)
			{
				$team_memeber = Team_member::where(['team_id' => $this->team_id , 'member_id' => Auth::user()->id])->whereIn('invitation_status',[0,1])->first();
			}
			else
			{
				$team_memeber = "";
			}

            return view('livewire.team-follow',compact('follower','team_id','is_follow','admins','team_info','countries','player_position','user_profile','team_memeber'));
        }
       else
       {
        return view('livewire.team-follow',compact('follower','team_id','admins','team_info','countries','player_position'));
       }
    }
    public function team_follow($id)
    {
        $user_follow = User_fav_follow::where('is_type',1)->where('type_id',$id)->where('user_id',Auth::user()->id)->first();
        if($user_follow)
        {
            $user_follows = User_fav_follow::find($user_follow->id);
            $user_follows->Is_follow = 1;
            $user_follows->save();
        }
        else
        {
            $user_fav_follow = new User_fav_follow();
            $user_fav_follow->user_id = Auth::user()->id;
            $user_fav_follow->is_type = 1;
            $user_fav_follow->type_id = $id;
            $user_fav_follow->Is_fav = 1;
            $user_fav_follow->Is_follow = 1;
            $user_fav_follow->save();

            $notification = Notification::create([
                'notify_module_id' => 5,
                'type_id' => $user_fav_follow->id,
                'sender_id' => Auth::user()->id,
                'reciver_id' => $id,
        ]);
        }

    }
    public function team_unfollow($id)
    {
        $user_follow = User_fav_follow::where('is_type',1)->where('type_id',$id)->where('user_id',Auth::user()->id)->first();

            $user_follows = User_fav_follow::find($user_follow->id);
            $user_follows->Is_follow = 0;
            $user_follows->save();
    }

	public function edit_info()
	{
		$this->dispatch('OpenModal');
	}
	public function closemodal()
	{
		$this->dispatch('CloseModal');
	}

    protected  $rules  = [
        'team_name' => 'required',
        'team_location' => 'required',
        'team_homeground_name' => 'required',
        'team_homeground_location' => 'required',
    ];

    protected $messages = [
        'team_name.required' => 'Team Name is Required.',
        'team_location.required' => 'Location is Required.',
        'team_homeground_name.required' => 'Homeground Name is Required.',
        'team_homeground_location.required' => 'Homeground Location is Required.',
    ];
	public function save_info()
	{

        $this->validate();

		$update_team = Team::find($this->team_id);
		$update_team->name = $this->team_name;
		$update_team->team_color = $this->team_color;
		$update_team->font_color = $this->font_color;
		$update_team->location = $this->team_location;
		$update_team->homeGround = $this->team_homeground_name;
		$update_team->homeGround_location = $this->team_homeground_location;
        $update_team->team_slogan = $this->team_slogan;
        $update_team->country_id = $this->country_id;
		$update_team->save();
		$this->dispatch('CloseModal');
		return redirect(route('team.show', $this->team_id));
	}
    public function open_join_modal()
    {
        $this->dispatch('OpenJoinModal');
    }
    public function close_join_modal()
	{
		$this->dispatch('CloseJoinModal');
	}
    public function join_team()
    {
        $team = Team::Find($this->team_id);
        $team_user_id = $team->user_id;
        if($this->join_member_position && $this->join_reason)
        {
            $team_member = new Team_member();
            $team_member->action_user = $team_user_id;
            $team_member->team_id = $this->team_id;
            $team_member->member_id = Auth::user()->id;
            $team_member->member_position_id = $this->join_member_position;
            $team_member->reason = $this->join_reason;
            $team_member->invitation_status = 0;
            $team_member->save();

            $notification = new Notification();
            $notification->notify_module_id = 12;
            $notification->type_id = $team_member->id;
            $notification->sender_id = Auth::user()->id;
            $notification->reciver_id = $team_user_id;
            $notification->save();
            $this->dispatch('CloseJoinModal');
        }

    }
}
