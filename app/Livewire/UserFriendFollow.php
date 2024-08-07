<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User_friend;
use App\Models\User_fav_follow;

class UserFriendFollow extends Component
{
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

        $friend = User_friend::where(function ($query) use ($user_id) {
            $query->where('user_id', '=', $user_id)
            ->orWhere('friend_id', '=', $user_id);
            })->where('request_status',1)->get();

        $friend_ids = array();
       foreach($friend as $friend_id)
       {
            if($friend_id->user_id == $user_id)
            {
                $friend_ids[] = $friend_id->friend_id;
            }
            else
            {
                $friend_ids[] = $friend_id->user_id;
            }
       }
        $follower = User_fav_follow::Where('is_type',3)->where('type_id',$user_id)->where('Is_follow',1)->get();
        return view('livewire.user-friend-follow',['friend' => $friend, 'follower' => $follower,'friend_ids' => $friend_ids]);
    }
}
