<?php

namespace App\Livewire\Competition;
use App\Models\Competition_team_request;
use App\Models\Comp_member;
use App\Models\Competition;
use App\Models\Team;
use App\Models\Team_member;
use App\Models\Competition_attendee;
use App\Models\Notification;
use App\Models\Member_position;
use App\Models\User_fav_follow;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
class InviteTeam extends Component
{
    public $comp_id;
    public $selected_team_id;
    public $team_attendees;
    public $team_user_id;
    public $team_id;
    public $selectAll = false;
    public $attendee_ids =[];
    public $comp_attendee_ids =[];
    public $team_members;
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
        $this->dispatch('refreshDataComplete'); // Optional: dispatch an event to signal that data refresh is complete
    }

    public function mount($comp_id)
    {
        $this->comp_id = $comp_id;
    }
    public function render()
    {
        $comp_team_request = Competition_team_request::with('team','user')->where('competition_id',$this->comp_id)->whereIn('request_status',[0,1])->get();
        $comp_admins = Comp_member::where('comp_id',$this->comp_id)->where('member_position_id',7)->where('invitation_status',1)->where('is_active', 1)->pluck('member_id');
		$admins = $comp_admins->toArray();
		$competition = Competition::select('id','user_id','squad_players_num','lineup_players_num','comp_start')->find($this->comp_id);
        $comp_admin_teams = Team::where('user_id',$competition->user_id)->where('is_active',1)->pluck('id');
		$comp_admin_team_ids = $comp_admin_teams->toArray();
        // dd($comp_admin_team_ids);
        return view('livewire.competition.invite-team',compact('comp_team_request','admins','competition','comp_admin_team_ids'));
    }

    public function updatedSelectAll($value)
    {
        if($value){
            $allPlayers_ids = Team_member::where('team_id', $this->team_id)->whereIn('member_position_id', [1,2,3,8])->where('invitation_status',1)->where('is_active',1)->pluck('member_id');
            $this->attendee_ids = $allPlayers_ids->toArray();
        }else{
            $this->attendee_ids = [];
        }
    }

    public function remove_team_comp($comp_tr)
   {
	   $comp_team_request = Competition_team_request::find($comp_tr);
	   $comp_team_request->request_status = 3;
	   $comp_team_request->save();
	   // remove player from comp attendees
	   $remove_comp_attendee = Competition_attendee::where('Competition_id',$comp_team_request->competition_id)->where('team_id',$comp_team_request->team_id)->delete();
	   $old_notification = Notification::where('notify_module_id',3)->where('type_id',$comp_tr)->update(['is_active' => 0]);
   }
   public function openModalteamattendees($team_id)
   {
       $this->selected_team_id = $team_id;
       $team = Team::find($team_id);
       $this->team_user_id = $team->user_id;
       $this->team_attendees = Competition_attendee::where('competition_id',$this->comp_id)->where('team_id',$team_id)->with('player','team')->get();
       $this->dispatch('openModalteamattendees');
   }
   public function closeteamattendees()
   {
       $this->dispatch('closeModalteamattendees');
   }
   public function resend_notification($comp_request_id)
   {
	   $comp_request = Competition_team_request::select('team_id')->find($comp_request_id);
	   $team_id = $comp_request->team_id;

	   $team = Team::select('user_id','name')->find($team_id);
	   $team_owner = $team->user_id;
	   $team_admins = Team_member::where('team_id',$team_id)->where('member_position_id',4)->where('invitation_status',1)->where('is_active',1)->pluck('member_id');
	   $team_admin_ids = $team_admins->ToArray();
	   array_push($team_admin_ids, $team_owner);
	   // send notification to team members for reminder to accept request
	   for($i = 0; $i < count($team_admin_ids); $i++)
	   {
		   if($team_admin_ids[$i] != Auth::user()->id)
		   {
			   $notification = new Notification();
			   $notification->notify_module_id = 10;
			   $notification->type_id = $comp_request_id;
			   $notification->sender_id = Auth::user()->id;
			   $notification->reciver_id = $team_admin_ids[$i];
			   $notification->save();
		   }
	   }
	   $this->dispatch('swal:modal', [

				'message' => 'Reminder to '.$team->name.' Admin. Sucessfully sent!',

			]);
   }
   public function select_player($team_id)
	{
		$this->selected_team_id = $team_id;
        $this->team_attendees = Competition_attendee::where('competition_id',$this->comp_id)->where('team_id',$team_id)->with('player','team')->get();
        $comp_attendees = Competition_attendee::where('Competition_id',$this->comp_id)->where('team_id',$team_id)->pluck('attendee_id');
        $this->comp_attendee_ids = $comp_attendees->toArray();
        $players_type_ids = Member_position::where('member_type',1)->pluck('id');
        $players_type_ids_array = $players_type_ids->toArray();
        $comp_attendees_ids = Competition_attendee::where('competition_id',$this->comp_id)->pluck('attendee_id');
        $comp_attendees_array = $comp_attendees_ids->toArray();
        $comp_referee = Comp_member::where('comp_id',$this->comp_id)->where('member_position_id',7)->where('invitation_status',1)->pluck('member_id');
        $comp_referee_array = $comp_referee->toArray();
        $comp_attendees_ids_a = array_merge($comp_attendees_array,$comp_referee_array);

		$this->team_members = Team_member::whereNotIn('member_id',$comp_attendees_ids_a)->whereIn('member_position_id',$players_type_ids_array)->where('team_id',$team_id)->where('invitation_status',1)->where('is_active',1)->with('members','member_position')->get();
        $this->team_id = $team_id;
        $teamAllmembers = Team_member::where('team_id',$team_id)->where('invitation_status',1)->where('is_active',1)->pluck('member_id');
        $teamAllmembers_ids = $teamAllmembers->toArray();
        $teamFollowers = User_fav_follow::where('is_type',1)->where('type_id',$team_id)->where('Is_follow', 1)->pluck('user_id');
        $teamFollowers_ids = $teamFollowers->toArray();
        $teamAllmembers_ids_a = array_merge($teamAllmembers_ids, $teamFollowers_ids);
        $teamData = Team::find($team_id);
		$teamCreaterId[] = $teamData->user_id;
        $allcompFollower_ids = array_merge($teamAllmembers_ids_a, $teamCreaterId);
        foreach ($allcompFollower_ids as $compFollower_id) {
            $check_user_fav_follow = User_fav_follow::where('is_type',2)->where('type_id',$this->comp_id)->where('user_id', $compFollower_id)->first();
            if(empty($check_user_fav_follow))
            {
                $user_fav_follow = new User_fav_follow();
                $user_fav_follow->user_id = $compFollower_id;
                $user_fav_follow->is_type = 2;
                $user_fav_follow->type_id = $this->comp_id;
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
		$this->dispatch('openModalteamplayerlist');
	}
    public function submit_player($team_id)
    {
        $competition = Competition::select('id','squad_players_num','lineup_players_num')->find($this->comp_id);
        $comp_ateendes = Competition_attendee::where('Competition_id',$this->comp_id)->where('team_id',$team_id)->count();
        $total_attende = $comp_ateendes + count(array_filter($this->attendee_ids));
        if(count(array_filter($this->attendee_ids)) > 0)
        {
            if($total_attende <= $competition->squad_players_num && $total_attende >= $competition->lineup_players_num)
            {
                foreach(array_filter($this->attendee_ids) as $attendee)
                {
                    $comp_attendee = new Competition_attendee();
                    $comp_attendee->Competition_id = $competition->id;
                    $comp_attendee->team_id = $team_id;
                    $comp_attendee->attendee_id = $attendee;
                    $comp_attendee->save();
                }
                $comp_team_request = Competition_team_request::where('competition_id',$this->comp_id)->where('team_id',$team_id)->first();
                $update_comp_team_request = Competition_team_request::find($comp_team_request->id);
                $update_comp_team_request->request_status = 1;
                $update_comp_team_request->accepted_by = Auth::user()->id;
                $update_comp_team_request->save();
                // $this->dispatch('closeModalteamplayerlist');
             return redirect(route('competition.show', $this->comp_id));

            }else
            {
                $this->dispatch('swal:modal', [

                 'message' => 'Please select number of Players between '.$competition->lineup_players_num.' to '.$competition->squad_players_num,

             ]);
            }
            $this->dispatch('closeModalteamplayerlist');
        }
        else
        {
            $this->dispatch('swal:modal', [

                'message' => 'Please select number of Players between '.$competition->lineup_players_num.' to '.$competition->squad_players_num,

            ]);
            $this->dispatch('closeModalteamplayerlist');
        }

    }
    public function remove_player($attendee_id)
	{
        //dd($attendee_id);
		$delete_comp_attendee = Competition_attendee::where('Competition_id',$this->comp_id)->where('attendee_id',$attendee_id)->delete();
        // $this->dispatch('closeModalteamplayerlist');
        $comp_attendees = Competition_attendee::where('Competition_id',$this->comp_id)->where('team_id',$this->selected_team_id)->pluck('attendee_id');
        $this->comp_attendee_ids = $comp_attendees->toArray();

	}
    public function removeselected__player($index)
    {
        //dd($this->attendee_ids);
        unset($this->attendee_ids[$index]);
    }
}
