<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User_fav_follow;
use App\Models\User_friend;
use App\Models\Notification;
use App\Models\Team_member;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Livewire\Trix;

class PlayerAddfriendFollow extends Component
{
    public $player_bio;
    public $player;
    public $msg;
    public $first_name;
    public $last_name;

    public $player_phoneno;
    public $player_dob;
    public $player_height;
    public $player_weight;
    public $about_me;
    public $player_location;
    public $is_save;
    public $max_char;
   // public $listeners = ['refreshData'];


	public function refresh()
    {
		$this->dispatch('$refresh');
    }
    public function refreshData()
    {
        $this->dispatch('refreshDataComplete'); // Optional: Emit an event to signal that data refresh is complete
    }

    protected function rules()
    {

        return [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'player_dob' => 'required|before_or_equal:'.\Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
            'player_bio' => 'required|max:250',
            'player_height' => 'required|min:0|max:999',
            'player_weight' => 'required|min:0|max:999',
            'player_location' => 'required',
        ];

    }
    protected $messages = [
            'first_name.required' => 'First name is Required',
            'last_name.required' => 'Last name is Required',
            'player_dob.required' => 'Date of Birth is Required',
            'player_dob.before_or_equal' => 'Your age must be 15 or more than 15 years',
            'player_bio.required' => 'Bio is Required',
            'player_bio.max' => 'You can not use more than 250 characters.',
            'player_height.required' => 'Height is Required',
            'player_height.min' => 'Please enter correct Height in cm',
            'player_height.max' => 'Please enter correct Height in cm',
            'player_weight.required' => 'Weight is Required',
            'player_weight.min' => 'Please enter correct Weight in kg.',
            'player_weight.max' => 'Please enter correct Weight in kg.',
            'player_location.required' => 'Location is Required',

    ];


    public function mount($user)
    {
        $this->player = $user;
        $playerprofile_info = User::find($this->player->id);
        $this->first_name = $playerprofile_info->first_name;
        $this->last_name = $playerprofile_info->last_name;
        $this->player_phoneno = $playerprofile_info->phonenumber;
        $this->player_dob = $playerprofile_info->dob;
        $this->player_bio = $playerprofile_info->bio;
        $this->player_height = $playerprofile_info->height;
        $this->player_weight = $playerprofile_info->weight;
        $this->player_location = $playerprofile_info->location;

    }
    public $listeners = [
        Trix::EVENT_VALUE_UPDATED // trix_value_updated()
    ];
	public function trix_value_updated($value){
        if(strlen($value) < 250)
		{
			$this->player_bio = $value;
			$this->is_save = 1;
			$this->max_char =   250 - strlen($value);
		}
		else
		{
			$this->is_save = 0;
			$this->max_char =   250 - strlen($value);
			$this->msg = "You can not use more than 250 characters.";
		}
    }

    // public function render()
    // {
    //     $users = $this->player;
    //     $user_id = $this->player->id;

    //     $follower = User_fav_follow::Where('is_type',3)->where('type_id',$users->id)->where('Is_follow',1)->get();
    //     $following = User_fav_follow::Where('is_type',3)->where('user_id',$users->id)->where('Is_follow',1)->get();

    //     if(Auth::check())
    //     {
    //         $is_follows = User_fav_follow::Where('is_type',3)->where('user_id',Auth::user()->id)->where('type_id',$users->id)->where('Is_follow',1)->first();
    //         if($is_follows)
    //         {
    //             $is_follow = 1;
    //         }
    //         else
    //         {
    //             $is_follow = 0;
    //         }

    //        // $is_friend = DB::select('select * from user_friends where (user_id = '.$users->id.' and friend_id = '.Auth::user()->id.') OR (friend_id =' .$users->id.' and user_id = '.Auth::user()->id.') LIMIT 1');

    //         $is_friend = User_friend::where(function ($query) use ($user_id) {
    //             $query->where('user_id', '=', $user_id)
    //             ->Where('friend_id', '=', Auth::user()->id);
    //             })->Orwhere(function ($query) use ($user_id) {
    //                 $query->where('user_id', '=', Auth::user()->id)
    //                 ->Where('friend_id', '=', $user_id);
    //                 })->latest()->first();
    //         return view('livewire.player-addfriend-follow',compact('follower','following','is_friend','is_follow','user_id'));
    //     }
    //     else
    //     {
    //         return view('livewire.player-addfriend-follow',compact('follower','following','user_id'));
    //     }

    // }

    public function render()
    {
        $users = $this->player;
        $user_id = $this->player->id;

        $follower = User_fav_follow::Where('is_type',3)->where('type_id',$users->id)->where('Is_follow',1)->get();
        $following = User_fav_follow::Where('is_type',3)->where('user_id',$users->id)->where('Is_follow',1)->get();

        if(Auth::check())
        {
            $is_follows = User_fav_follow::Where('is_type',3)->where('user_id',Auth::user()->id)->where('type_id',$users->id)->where('Is_follow',1)->first();
            if($is_follows)
            {
                $is_follow = 1;
            }
            else
            {
                $is_follow = 0;
            }

        // $is_friend = DB::select('select * from user_friends where (user_id = '.$users->id.' and friend_id = '.Auth::user()->id.') OR (friend_id =' .$users->id.' and user_id = '.Auth::user()->id.') LIMIT 1');

            $is_friend = User_friend::where(function ($query) use ($user_id) {
                $query->where('user_id', '=', $user_id)
                ->Where('friend_id', '=', Auth::user()->id);
                })->Orwhere(function ($query) use ($user_id) {
                    $query->where('user_id', '=', Auth::user()->id)
                    ->Where('friend_id', '=', $user_id);
                    })->latest()->first();
            return view('livewire.player-addfriend-follow',compact('follower','following','is_friend','is_follow','user_id'));
        }
        else
        {
            return view('livewire.player-addfriend-follow',compact('follower','following','user_id'));
        }

    }


    public function user_follow($id)
    {

        $user_follow = User_fav_follow::where('is_type',3)->where('type_id',$id)->where('user_id',Auth::user()->id)->first();
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
            $user_fav_follow->is_type = 3;
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
    public function user_unfollow($id)
    {
        $user_follow = User_fav_follow::where('is_type',3)->where('type_id',$id)->where('user_id',Auth::user()->id)->first();
        $user_follows = User_fav_follow::find($user_follow->id);
        $user_follows->Is_follow = 0;
        $user_follows->save();

    }
    public function player_addfriend($id)
    {
        $add_friend = new User_friend();
        $add_friend->user_id = Auth::user()->id;
        $add_friend->friend_id = $id;
        $add_friend->request_status = 0;
        $add_friend->save();
        $ufr_id = $add_friend->id;

        $notification = Notification::create([
            'notify_module_id' => 1,
            'type_id' => $ufr_id,
            'sender_id' => Auth::user()->id,
            'reciver_id' => $id,
         ]);
    }
    public function player_removefriend($id)
    {
        $add_friend = User_friend::find($id)->delete();
        $delete_notification = Notification::where('notify_module_id',1)->where('type_id',$id)->delete();
    }

    public function edit_player_info()
    {
        //dd($this->player_bio);
        $this->validate();
        $player_info = User::find($this->player->id);
        $player_info->first_name = $this->first_name;
        $player_info->last_name = $this->last_name;
        $player_info->phonenumber = $this->player_phoneno;
        $player_info->dob = $this->player_dob;
        $player_info->bio = $this->player_bio;
        $player_info->height = $this->player_height;
        $player_info->weight = $this->player_weight;
        $player_info->location = $this->player_location;
        $player_info->save();

        $this->dispatch('CloseplayerinfoModal');
        return redirect(route('player_profile.show', $this->player->id));
    }

    public function open_editplayer_info()
	{
		$this->dispatch('OpenplayerinfoModal');
	}
	public function close_editplayer_info()
	{
		$this->dispatch('CloseplayerinfoModal');
	}
}
