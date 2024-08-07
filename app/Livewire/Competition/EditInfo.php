<?php

namespace App\Livewire\Competition;
use App\Models\Competition;
use App\Models\Comp_member;
use App\Models\Comp_report_type;
use App\Models\User_fav_follow;
use App\Models\User_profile;
use App\Models\Competition_attendee;
use App\Models\Notification;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class EditInfo extends Component
{
	public $comp_id;
    public $comp_follower;
	public $comp_name;
	public $location;
	public $report_type;
	public $comp_type_id;
	public $vote_mins;
	public $Comp_follower = [];
	public $is_follow;
	public $squad_players_num;
	public $lineup_players_num;
	public $comp_start;
	public $join_reason;
	public $join_member_position;
	public $join_member_position1;
	public $join_member_position2;
	public $seasonStart;
	public $seasonEnd;

	public function mount($competition)
    {
        $this->comp_id = $competition;
		$competition = Competition::find($this->comp_id);
		$this->comp_name = $competition->name;
		$this->location = $competition->location;
		$this->report_type = $competition->report_type;
		$this->comp_type_id = $competition->comp_type_id;
		$this->vote_mins = $competition->vote_mins;
		$this->squad_players_num = $competition->squad_players_num;
		$this->lineup_players_num = $competition->lineup_players_num;
		$this->comp_start = $competition->comp_start;
		if($competition->comp_season_start != "" && $competition->comp_season_end != ""){
			$this->seasonStart = date('Y-m', strtotime($competition->comp_season_start));
			$this->seasonEnd = date('Y-m', strtotime($competition->comp_season_end));
		}else{
			$this->seasonStart = date('Y-m');
			$this->seasonEnd = date('Y-m');
		}
    }



    public function render()
    {
		$this->dispatch('location');

		$competition = Competition::find($this->comp_id);

		if (!$competition) {
			abort(404); // Handle the case where the competition is not found
		}

		$comp_admins = Comp_member::where('comp_id', $this->comp_id)
			->where('member_position_id', 7)
			->where('invitation_status', 1)
			->where('is_active', 1)
			->pluck('member_id');

		$admins = $comp_admins->toArray();

		$com_report_type = Comp_report_type::where('sport_id', 1)->get();

		$this->comp_follower = User_fav_follow::where('is_type', 2)
			->where('type_id', $this->comp_id)
			->where('Is_follow', 1)
			->where('is_active', 1)
			->get();

		$comp_attendee = Competition_attendee::where('Competition_id', $this->comp_id)->count();

		if (Auth::check()) {
			$is_follow = User_fav_follow::where('is_type', 2)
				->where('type_id', $this->comp_id)
				->where('user_id', Auth::user()->id)
				->first();

			$this->is_follow = $is_follow ? $is_follow->Is_follow : 0;

			$user_profile = User_profile::where('user_id', Auth::user()->id)
				->where('profile_type_id', 3)
				->first();
			if($user_profile)
			{
				$comp_memeber = Comp_member::where(['comp_id' => $this->comp_id , 'member_id' => Auth::user()->id, 'member_position_id' => 6])->whereIn('invitation_status',[0,1])->first();
			}
			else
			{
				$comp_memeber = "";
			}
			$comp_member_conditions = [
				'comp_id' => $this->comp_id,
				'member_id' => Auth::user()->id,
				'member_position_id' => 6
			];

			$comp_member = $user_profile
				? Comp_member::where($comp_member_conditions)->whereIn('invitation_status', [0, 1])->first()
				: null;

			return view('livewire.competition.edit-info', compact(
				'admins',
				'competition',
				'com_report_type',
				'comp_attendee',
				'comp_memeber',
				'comp_member',
				'user_profile'
			));
		} else {
			return view('livewire.competition.edit-info', compact('competition'));
		}

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
        'comp_name' => 'required|max:30',
        'location' => 'required',
        'report_type' => 'required',
        'vote_mins' => 'required',
        'squad_players_num' => 'required',
        'lineup_players_num' => 'required',
    ];

    protected $messages = [
        'comp_name.required' => 'Competition Name is Required.',
        'comp_name.max' => 'Competition Name must not be greater than 30 characters.',
        'location.required' => 'Location is Required.',
        'report_type.required' => 'Report type is Required.',
        'vote_mins.required' => 'Vote minutes is Required.',
        'squad_players_num.required' => 'Squad Players number is Required.',
        'lineup_players_num.required' => 'Lineup Plyers number is Required.',
        'join_member_position.required' => 'Preferred Position is Required.',
        'join_reason.required' => 'Cover letter is Required.',
    ];
	public function save_info()
	{
          $this->validate();
		$edit_comp = Competition::find($this->comp_id);
		if($this->lineup_players_num > 0 && $this->lineup_players_num > 0)
		{
			if($this->lineup_players_num <= $this->squad_players_num)
			{
				$edit_comp->name = $this->comp_name;
				$edit_comp->location = $this->location;
				$edit_comp->report_type = $this->report_type;
				$edit_comp->vote_mins = $this->vote_mins;
				$edit_comp->squad_players_num = $this->squad_players_num;
				$edit_comp->lineup_players_num = $this->lineup_players_num;
				if($this->comp_type_id != 1)
				{
					if($this->seasonStart != "" && $this->seasonEnd != ""){
						$edit_comp->comp_season_start = date('Y-m-01', strtotime($this->seasonStart));
						$edit_comp->comp_season_end = date('Y-m-01', strtotime($this->seasonEnd));
					}
				}
				$edit_comp->save();
				return redirect(route('competition.show', $this->comp_id));
			}
			else
			{
				$this->dispatch('swal:modal', [

					'message' => 'Starting Players should be equal or less than Squad players',

				]);
			}
		}
		else
		{
			$this->dispatch('swal:modal', [

				'message' => 'Please enter squad Or lineup players number',

			]);
		}


		//return redirect(route('competition.show', $this->comp_id));
	}
	public function follow_comp()
	{
		$check_user_fav_follow = User_fav_follow::where('is_type',2)->where('type_id',$this->comp_id)->where('user_id',Auth::user()->id)->first();
		if(empty($check_user_fav_follow))
		{
			$user_fav_follow = new User_fav_follow();
			$user_fav_follow->user_id = Auth::user()->id;
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
	public function unfollow_comp()
	{
		$check_user_fav_follow = User_fav_follow::where('is_type',2)->where('type_id',$this->comp_id)->where('user_id',Auth::user()->id)->first();
		$user_fav_follow = User_fav_follow::find($check_user_fav_follow->id);
		$user_fav_follow->Is_follow = 0;
		$user_fav_follow->save();
	}
	public function join_competition()
	{
		$this->validate([
			'join_member_position' => 'required',
			'join_reason' => 'required',
		]);
		$competiton = Competition::Find($this->comp_id);
        $comp_user_id = $competiton->user_id;

        $comp_member = new Comp_member();
        $comp_member->user_id = $comp_user_id;
        $comp_member->comp_id = $this->comp_id;
        $comp_member->member_id = Auth::user()->id;
        $comp_member->member_position_id = 6;
		if($this->join_member_position1 != ''){
			$comp_member->alt_member_position_id1 = $this->join_member_position1;
		}
		if($this->join_member_position2 != ''){
			$comp_member->alt_member_position_id2 = $this->join_member_position2;
		}
		$comp_member->reason = $this->join_reason;
        $comp_member->invitation_status = 0;
        $comp_member->save();
		if($comp_member){
			$notification = new Notification();
			$notification->notify_module_id = 11;
			$notification->type_id = $comp_member->id;
			$notification->sender_id = Auth::user()->id;
			$notification->reciver_id = $comp_user_id;
			$notification->save();
			if($notification){
				$this->dispatch('CloseJoinModal');
				$this->join_reason = '';
				$this->join_member_position = '';
				$this->join_member_position1 = '';
				$this->join_member_position2 = '';
			}
		}
	}
	public function open_join_modal()
    {
        $this->dispatch('OpenJoinModal');
    }
    public function close_join_modal()
	{
		$this->dispatch('CloseJoinModal');
	}
}

