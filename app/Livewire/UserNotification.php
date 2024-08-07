<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\User_friend;
use App\Models\Team_member;
use App\Models\Competition_team_request;
use App\Models\Comp_member;
use App\Models\Match_fixture;
use App\Models\Competition;
use App\Models\Competition_attendee;
use App\Models\Member_position;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Fixture_notification;
use App\Models\Team;
use App\Models\User_fav_follow;

class UserNotification extends Component
{
    use WithPagination;

    public $msg = '';
	public $popup = false;
	public $team_members;
	public $comp_request_id;
	public $select_competition;
    public $selectAll = false;
	public $comp_attendees;
	public $requestedTeam_id;
    public $attendee_ids = [];
    public $selected_team_id;

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
        $this->dispatch('tooltipmsg');
        if(Auth::check())
        {
            $user_id = Auth::user()->id;
        }
        else
        {
            $user_id = "";
        }

		$notify_module_ids = array(1,2,3,4,11,12);
		$notifications = Notification::where(function ($query) use ($user_id) {
            $query->where('sender_id', '=', $user_id)
			->orWhere('reciver_id', '=', $user_id);
        })->whereIn('notify_module_id', $notify_module_ids)->where('is_active',1)->latest()->offset(0)->paginate(5,['*'], 'user_notification')->onEachSide(1);
        return view('livewire.user-notification',['notification' => $notifications]);
    }

    public function updatedSelectAll($value)
    {
        if($value){
            $allPlayer_ids = Team_member::where('team_id', $this->requestedTeam_id)->whereIn('member_position_id', [1,2,3,8])->where('invitation_status',1)->where('is_active',1)->pluck('member_id');
            $this->attendee_ids = $allPlayer_ids->toArray();
        }else{
            $this->attendee_ids = [];
        }
    }

    // friend request User_friend
    public function friend_accept($id, $noti_id)
    {
        $is_seen = Notification::where('id',$noti_id)->update(['is_seen' => 1]);
        $user_friend = User_friend::find($id);
        $user_friend->request_status = 1;
        $user_friend->save();
        $this->msg = "You Accepted this friend request";
		// return redirect()->to('dashboard');
    }

    public function friend_reject($id, $noti_id)
    {
        $notification = Notification::find($noti_id);
        $notification->is_seen = 1;
        $notification->is_active = 0;
        $notification->save();
        $user_friend = User_friend::find($id);
        $user_friend->request_status = 2;
        $user_friend->save();
        $this->msg = "You rejected this friend request";
		// return redirect()->to('dashboard');
    }

    public function friend_remove($id, $notification_id)
    {
        $delete_notification = Notification::find($notification_id)->delete();
        $user_friend = User_friend::find($id)->delete();
        // $user_friend->request_status = 3;
        // $user_friend->save();
        $this->msg = "You removed this friend request";
		// return redirect()->to('dashboard');
    }

    public function friend_send_request($id)
    {
        $user_friend = User_friend::find($id);
        $user_friend->request_status = 0;
        $user_friend->save();
        $this->msg = "You sent friend request";
		// return redirect()->to('dashboard');
    }
    // team_member Join request and add member request
    public function team_member_accept($id , $noti_id)
    {
        $is_seen = Notification::where('id',$noti_id)->update(['is_seen' => 1]);
        $team_member = Team_member::find($id);
        $team_member->invitation_status = 1;
        $team_member->save();
        $this->msg = "You Accepted this request";
		// return redirect()->to('dashboard');

    }
    public function team_member_reject($id , $noti_id)
    {
        $notification = Notification::find($noti_id);
        $notification->is_seen = 1;
        $notification->is_active = 0;
        $notification->save();
        $team_member = Team_member::find($id);
        $team_member->invitation_status = 2;
        $team_member->save();
        $this->msg = "You rejected this friend request";
		// return redirect()->to('dashboard');

    }
    public function team_member_remove($id)
    {
        $team_member = Team_member::find($id);
        $team_member->invitation_status = 3;
        $team_member->save();
        $this->msg = "You removed this friend request";
		// return redirect()->to('dashboard');
    }
    public function team_member_send($id)
    {
        $team_member = Team_member::find($id);
        $team_member->invitation_status = 0;
        $team_member->save();
        $this->msg = "You sent friend request";
		// return redirect()->to('dashboard');
    }

   public function remove_compmember_request($id)
   {
       $comp_member = Comp_member::find($id);
       $comp_member->invitation_status = 3;
       $comp_member->save();
   }

   public function send_compmember_request($id)
   {
       $comp_member = Comp_member::find($id);
       $comp_member->invitation_status = 0;
       $comp_member->save();
   }
   public function accept_competitionmember_request($id , $noti_id)
   {
        $notification = Notification::where('id',$noti_id)->update(['is_seen'=>1]);
       $comp_member = Comp_member::find($id);
       $comp_member->invitation_status = 1;
       $comp_member->save();

       $check_user_fav_follow = User_fav_follow::where('is_type',2)->where('type_id',$comp_member->comp_id)->where('user_id', $comp_member->member_id)->first();
		if(empty($check_user_fav_follow))
		{
			$user_fav_follow = new User_fav_follow();
			$user_fav_follow->user_id = $comp_member->member_id;
			$user_fav_follow->is_type = 2;
			$user_fav_follow->type_id = $comp_member->comp_id;
			$user_fav_follow->Is_follow = 1;
			$user_fav_follow->save();
		}
		else
		{
			$user_fav_follow = User_fav_follow::find($check_user_fav_follow->id);
			$user_fav_follow->Is_follow = 1;
			$user_fav_follow->save();
		}
   }
   public function reject_competitionmember_request($id , $noti_id)
   {
        $notification = Notification::find($noti_id);
        $notification->is_seen = 1;
        $notification->is_active = 0;
        $notification->save();
       $comp_member = Comp_member::find($id);
       $comp_member->invitation_status = 2;
       $comp_member->save();
   }

   public function accept_start_comp($id)
   {
        $fixture_notification = Fixture_notification::find($id);
        $fixture_notification->request_status = 1;
        $fixture_notification->save();

        $match_fixture = Match_fixture::find($fixture_notification->match_fixture_id);
        $match_fixture->startdate_time = now();
        $match_fixture->save();
		return redirect()->to('match-fixture/'.$fixture_notification->match_fixture_id);

   }

    public function reject_compjoin($id , $noti_id)
   {
        $is_seen = Notification::find($noti_id);
        $is_seen->is_seen = 1;
        $is_seen->is_active = 0;
        $is_seen->save();

        $comp_team_request = Competition_team_request::find($id);
        $comp_team_request->request_status = 2;
        $comp_team_request->save();
   }
   public function retreat_compjoin($id)
   {
        $comp_team_request = Competition_team_request::find($id);
        $comp_team_request->request_status = 3;
        $comp_team_request->save();
   }
   public function send_comp_request_again($id)
   {
	   $comp_team_request = Competition_team_request::find($id);
	   $check_team_num = Competition_team_request::where('competition_id',$comp_team_request->competition_id)->where('request_status','!=',3)->count();
	   $competition = Competition::find($comp_team_request->competition_id);
	   if($competition->team_number > $check_team_num)
	   {
		   $comp_team_request->request_status = 0;
		   $comp_team_request->save();
	   }
	   else
	   {
		   $this->dispatch('swal:modal', [

					'message' => 'Required team number for this competition are compelete! Can not add more team! ',

				]);
	   }
   }
   public function select_player($id , $noti_id)
    {
        $is_seen = Notification::where('id',$noti_id)->update(['is_seen' => 1]);
		$this->popup = true;
        $players_type_ids = Member_position::where('member_type',1)->pluck('id');
        $players_type_ids_array = $players_type_ids->toArray();

        $competition_team_request = Competition_team_request::find($id);
        $competition_team_request->request_status = 1;
        $competition_team_request->accepted_by = Auth::user()->id;
        $competition_team_request->save();

		$comp = Competition::find($competition_team_request->competition_id);
        $comp_attendees_ids = Competition_attendee::where('competition_id',$competition_team_request->competition_id)->pluck('attendee_id');
        $comp_attendees_array = $comp_attendees_ids->toArray();
        $comp_referee = Comp_member::where('comp_id',$competition_team_request->competition_id)->where('member_position_id',7)->where('invitation_status',1)->pluck('member_id');
        $comp_referee_array = $comp_referee->toArray();
        $comp_attendees_ids_a = array_merge($comp_attendees_array,$comp_referee_array);
        // dd($comp_attendees);
        $team_member = Team_member::whereNotIn('member_id',$comp_attendees_ids_a)->whereIn('member_position_id',$players_type_ids_array)->where('team_id',$competition_team_request->team_id)->where('invitation_status',1)->where('is_active',1)->with('members')->get();
        $comp_attendees = Competition_attendee::where('competition_id',$competition_team_request->competition_id)->get();
        $this->team_members = $team_member;
        $this->comp_request_id = $id;
		$this->comp_attendees = $comp_attendees;
		$this->select_competition = $comp;
        $this->selected_team_id = $competition_team_request->team_id;

        $teamAllmembers = Team_member::where('team_id', $competition_team_request->team_id)->where('invitation_status',1)->where('is_active',1)->pluck('member_id');
        $teamAllmembers_ids = $teamAllmembers->toArray();
        $this->requestedTeam_id = $competition_team_request->team_id;
        $teamFollowers = User_fav_follow::where('is_type',1)->where('type_id',$competition_team_request->team_id)->where('Is_follow', 1)->pluck('user_id');
        $teamFollowers_ids = $teamFollowers->toArray();
        $teamAllmembers_ids_a = array_merge($teamAllmembers_ids, $teamFollowers_ids);
        $teamData = Team::find($competition_team_request->team_id);
		$teamCreaterId[] = $teamData->user_id;
        $allcompFollower_ids = array_merge($teamAllmembers_ids_a, $teamCreaterId);
        foreach ($allcompFollower_ids as $compFollower_id) {
            if($compFollower_id == $comp->user_id)
            {
            }else{
                $check_user_fav_follow = User_fav_follow::where('is_type',2)->where('type_id',$comp->id)->where('user_id', $compFollower_id)->whereIn('Is_follow', [0,1])->first();
                if(empty($check_user_fav_follow))
                {
                    $user_fav_follow = new User_fav_follow();
                    $user_fav_follow->user_id = $compFollower_id;
                    $user_fav_follow->is_type = 2;
                    $user_fav_follow->type_id = $comp->id;
                    $user_fav_follow->Is_follow = 1;
                    $user_fav_follow->save();
                }
                else
                {
                    $user_fav_follow = User_fav_follow::find($check_user_fav_follow->id);
                    $user_fav_follow->Is_follow = 1;
                    $user_fav_follow->save();
                }
            }
        }
        $this->dispatch('openModal');

    }
    public function submit_player($comp_id)
    {
        $competition = Competition::find($comp_id);
        $comp_ateendes = Competition_attendee::where('Competition_id',$comp_id)->where('team_id',$this->selected_team_id)->count();
        $total_attende = $comp_ateendes + count(array_filter($this->attendee_ids));

        if(count(array_filter($this->attendee_ids)) > 0)
        {
            if($total_attende <= $competition->squad_players_num && $total_attende >= $competition->lineup_players_num)
            {
                // dd($competition->squad_players_num, 'if');

                foreach(array_filter($this->attendee_ids) as $attendes)
                {
                    $comp_attendee = new Competition_attendee();
                    $comp_attendee->Competition_id = $competition->id;
                    $comp_attendee->team_id = $this->selected_team_id;
                    $comp_attendee->attendee_id = $attendes;
                    $comp_attendee->save();
                }


             return redirect(route('competition.show', $comp_id));
            }else{
                // dd($competition->squad_players_num, 'else');
                $this->dispatch('swal:modal', [

                    'message' => 'Please select number of Players between ' . $competition->lineup_players_num . ' to '.$competition->squad_players_num,

                ]);

            }

            $this->dispatch('closeModalteamplayerlist');
        }else{
            $this->dispatch('swal:modal', [

                'message' => 'Please select number of Players between ' . $competition->lineup_players_num . ' to '.$competition->squad_players_num,

            ]);

            $this->dispatch('closeModalteamplayerlist');
        }

    }
    public function remove_player($index)
    {
        //dd($this->attendee_ids);
        unset($this->attendee_ids[$index]);
    }

}
