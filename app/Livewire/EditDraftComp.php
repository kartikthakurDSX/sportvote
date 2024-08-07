<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\competition_type;
use App\Models\Competition;
use App\Models\CompSubType;
use App\Models\Member_position;
use App\Models\Comp_report_type;
use App\Models\Sport_level;
use App\Models\Team;
use App\Models\Sport_stat;
use App\Models\User;
use App\Models\Comp_member;
use App\Models\Notification;
use App\Models\StatDecisionMaker;
use App\Models\User_profile;
use App\Models\StatTrack;
use App\Models\Comp_rule_set;
use App\Models\Competition_team_request;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use App\Image;

class EditDraftComp extends Component
{
    use WithFileUploads;
    public $comp_type = false;
    public $next_step = false;
    public $current_step = true;
    public $comp_sub_type;
    public $start_linup_player;
    public $team_min;
    public $team_max;
    public $teams = [];
    public $comp_type_name;
    public $report_name;
    public $team_detail;
    public $team2_detail;
    public $competition_member = [];
	public $game_id;
    public $logo;
	public $comp_half_time;
	public $bannerpreview;

    // form variable

    public $comp_id;
	public $comp_info;
    public $comp_name;
    public $comp_logo;
    public $squad_player;
    public $comp_start_datetime;
    public $comp_end_datetime;
    public $comp_location;
    public $comp_type_id = 1;
    public $linup_player;
    public $comp_sub_type_id = 1;
    public $comp_report_type;
    public $team_num;
    public $vote_min;
    public $comp_admin_position_id;
    public $member_id = [];
    public $comp_desc;
    public $sport_level_id;
    public $teamOne;
    public $teamTwo;
    public $comp_stat = [];
    public $top_player_stat;
    public $level_method;
    public $team_ranking_stat1;
    public $team_ranking_stat2;
    public $team_ranking_stat3;
    public $referee_id = [];
	public $banner;
    public $team_stats = [] ;
    public $secondkeyranking;
    public $thirdkeyranking;
    public $comp_team_stat = [1,2,3,5,47];
    public $selectedstat = [];
    public $player_stats = [];
    public $player_ranking;
    public $is_add_rule;
    public $rule_desc;
    public $comp_rules;

    public $drftcomp_id;
    public $comp_typeid;

    protected function rules()
    {
        if($this->current_step)
        {
            return [
                // 'comp_start_datetime' => 'required',
                // 'comp_end_datetime' => 'required',
                'comp_name'=> 'required|max:20',
				'comp_location' => 'required',
				'comp_half_time' => 'required',
            ];
        }
        else
        {
            return [
                'teamOne' => 'required',
               'teamTwo' => 'required',
            ];

        }

    }
    protected $messages = [

        // 'comp_start_datetime.required' => 'The Start date cannot be empty.',
        // 'comp_end_datetime.required' => 'The End date cannot be empty.',
        'comp_name.required' => 'The Competition Name cannot be empty.',
		'comp_location.required' => 'The Location cannot be empty',
        'teamOne.required' => 'Select team for competition',
        'teamTwo.required' => 'Select team for competition',
		'comp_half_time' => 'Competition Half time is required',
    ];

    public function mount($drftcomp_id)
    {
        $this->drftcomp_id = $drftcomp_id;
        $comp = Competition::find($this->drftcomp_id);
        $this->comp_name = $comp->name;
        $this->comp_location = $comp->location;
        $this->comp_half_time = $comp->competition_half_time;
        $this->comp_typeid = $comp->comp_type_id;
        $this->comp_sub_type_id = $comp->comp_subtype_id;
        $this->team_num = $comp->team_number;
        $this->comp_start_datetime = $comp->start_datetime;
        $this->squad_player = $comp->squad_players_num;
        $this->linup_player = $comp->lineup_players_num;
        $this->comp_report_type = $comp->report_type;
        $this->vote_min = $comp->vote_mins;
        $this->comp_desc = $comp->description;
        if($comp->comp_type_id != null){
            if($comp->comp_type_id != 1){
                $this->comp_type = true;
                $this->comp_sub_type = CompSubType::where('competition_type_id',$comp->comp_type_id)->get();
            }
            $comp_type = competition_type::find($this->comp_typeid);
            $this->comp_type_name = $comp_type->name;
            $this->comp_sub_type = CompSubType::where('competition_type_id',$this->comp_typeid)->get();
            $comp_team_number = CompSubType::find($this->comp_sub_type_id);
            $team_number = explode("-",$comp_team_number->team_number);
            $this->team_min = $team_number[0];
            $this->team_max = $team_number[1];
        }
        $this->comp_rules = Comp_rule_set::where('comp_id',$this->drftcomp_id)->where('is_active',1)->get();
        $this->competition_member = Comp_member::where('comp_id',$this->drftcomp_id)->with('member','member_position')->get();
        $this->comp_id = $drftcomp_id;
    }

    public function render()
    {
		$this->dispatch('addadmin');
		$this->dispatch('addreferee');
        $this->start_date = Carbon::now();
        $com_type = competition_type::all();
        $com_report_type = Comp_report_type::where('sport_id',1)->get();
        $member_position = Member_position::where('sport_id',1)->where('member_type',3)->where('id', '!=', 6)->get();
        $sport_level = Sport_level::where('sport_id',1)->get();
        $player_stat = Sport_stat::where('sport_id',1)->where('stat_type_id',1)->get();
        $admin = User::where('first_name', '!=', NULL)->get();
        $referees = User_profile::where('profile_type_id',3)->with('user')->get();
        $this->teams = Team::all();
		if($this->comp_id)
		{
			$competition = Competition::find($this->comp_id);
			$competition_logo = $competition->comp_logo;
            $is_add_rule = 1;
		}
		else
		{
			$competition_logo = "competitions-icon-128.png";
            $is_add_rule = 0;
		}

        $league_table_markers = [6,7,8,9,11,41,50];
        $team_ranking_stats = Sport_stat::whereIn('id',$league_table_markers)->get();
        return view('livewire.edit-draft-comp',compact('competition_logo','referees','com_type','com_report_type','member_position','sport_level','player_stat','admin','team_ranking_stats'));
    }

    public function comp_type($id)
    {
        $comp_type = competition_type::find($id);
        $this->comp_type_name = $comp_type->name;
        $this->comp_sub_type = CompSubType::where('competition_type_id',$id)->get();
        // dd($this->comp_type_d);
        if($id == 1)
        {
            $this->comp_type = false;
        }
        else
        {
            $this->comp_type = true;
        }

        $this->comp_type_id = $id;

    }

    public function next_step()
    {

        // dd($this->comp_start_datetime);
        //$this->validate();
        if($this->logo)
		{
			$this->logo->store('files','public');
		}
		if($this->banner)
		{
			$this->banner->store('files','public');
			$comp_banner = $this->banner->hashName();
		}
		else
		{
			$comp_banner = NULL;
		}

        //    Storage::put('file',$this->banner);
        //dd($this->banner);
        if($this->comp_id != NULL)
        {
			if($this->comp_type_id == 1)
			{
				$this->comp_start_datetime;
			}
			else
			{
				$this->comp_start_datetime = NULL;
			}
            $competition = Competition::find($this->comp_id);
            $competition->name = $this->comp_name;
            $competition->parent_id = $this->comp_id;
            $competition->comp_type_id = $this->comp_type_id;
            $competition->comp_subtype_id = $this->comp_sub_type_id;
            $competition->location = $this->comp_location;
			$competition->competition_half_time = $this->comp_half_time;
            $competition->description = $this->comp_desc;
            $competition->team_number = $this->team_num;
            $competition->squad_players_num = $this->squad_player;
            $competition->lineup_players_num =  $this->linup_player;
            $competition->report_type = $this->comp_report_type;
            $competition->vote_mins = $this->vote_min;
            $competition->start_datetime = $this->comp_start_datetime;
            // $competition->end_datetime = $this->comp_end_datetime;
            $competition->comp_banner = $comp_banner;
            $competition->is_active = 1;
            $competition->save();

        }
		if($this->comp_type_id == 2)
		{
            if($this->comp_report_type == 2)
            {
                $this->next_step= true;
                $this->current_step = false;
                $this->team_stats = Sport_stat::where('stat_type_id',0)->where('is_calculated',0)->whereIn('stat_type',[0,2])->where('is_active',1)->orderBy('stat_type','ASC')->get();
                $this->player_stats = Sport_stat::whereIn('stat_type_id',[0,1])->where('is_calculated',0)->whereIn('stat_type',[0,2])->where('is_active',1)->orderBy('must_track','DESC')->get();
            }
            else
            {
                return redirect(route('competition.show', $this->comp_id));
            }
		}
        else
        {
            if($this->comp_report_type == 2)
            {
                $this->team_stats = Sport_stat::where('stat_type_id',0)->where('is_calculated',0)->whereIn('stat_type',[0,2])->where('is_active',1)->orderBy('stat_type','ASC')->get();
                $this->player_stats = Sport_stat::whereIn('stat_type_id',[0,1])->where('is_calculated',0)->whereIn('stat_type',[0,2])->where('is_active',1)->orderBy('must_track','DESC')->get();
            }
            else
            {
                $this->team_stats = Sport_stat::where('stat_type_id',0)->where('is_calculated',0)->whereIn('stat_type',[0,1])->orderBy('stat_type','ASC')->get();
                $this->player_stats = Sport_stat::whereIn('stat_type_id',[0,1])->where('is_calculated',0)->whereIn('is_active',[0,1])->orderBy('must_track','DESC')->get();
            }
            $this->next_step= true;
            $this->current_step = false;
        }
        $update_user = User::find(Auth::user()->id);
        $update_user->p_box_comp = 1;
        $update_user->save();
    }
    public function first_step()
    {
        $this->current_step = true;
        $this->next_step= false;
    }
    public function linup_player()
    {

        $this->start_linup_player = $this->squad_player;
    }
    public function select_linup()
    {
        $this->linup_player;
    }

    public function team_number()
    {
        $this->comp_sub_type_id;
        $comp_team_number = CompSubType::find($this->comp_sub_type_id);
        $team_number = explode("-",$comp_team_number->team_number);
        $this->team_min = $team_number[0];
        $this->team_max = $team_number[1];
        // dd($team_number[1]);
    }
    public function select_team_number()
    {
        $this->team_num;
    }
    // public function sport_level()
    // {
    //     $this->sport_level_id;
    //     $this->teams = Team::where('sport_level_id',$this->sport_level_id)->get();
    // }
    public function team1()
    {
        $this->teamOne;
        $this->team_detail = Team::find($this->teamOne);

    }
    public function team2()
    {
        $this->teamTwo;
        $this->team2_detail = Team::find($this->teamTwo);
    }

    public function create_comp()
    {
        $this->comp_name;
        if($this->comp_name != NULL)
        {
            $competition = new Competition();
            $competition->user_id = Auth::user()->id;
            $competition->sport_id = 1;
            $competition->name = $this->comp_name;
            $competition->save();

            $this->comp_id = $competition->id;
			$this->comp_info = $competition;
            $this->is_add_rule = 1;
        }


    }
    public function report_name()
    {
        $this->comp_report_type;
        // dd( $this->comp_report_type);
        $report_names = Comp_report_type::find($this->comp_report_type);
        $this->report_name = $report_names->name;
    }

    public function send_request_admin()
    {
        if($this->comp_id)
        {
			if($this->member_id)
			{
				 for ($x = 0; $x < count($this->member_id); $x++)
				 {
					if($this->member_id[$x] == Auth::user()->id)
					{
						$invitation_status = '1';
					}
					else
					{
						$invitation_status = '0';
					}

					$checkmember = Comp_member::where('comp_id',$this->comp_id)->where('member_id',  $this->member_id[$x])->first();
					if(!($checkmember))
					{
						$comp_request = new Comp_member();
						$comp_request->user_id = Auth::user()->id;
						$comp_request->comp_id = $this->comp_id;
						$comp_request->member_id = $this->member_id[$x];
						$comp_request->member_position_id = 7;
						$comp_request->invitation_status = $invitation_status;
						$comp_request->save();
						$comp_member_id = $comp_request->id;

						$notification = Notification::create([
							'notify_module_id' => 4,
							'type_id' => $comp_member_id,
							'sender_id' => Auth::user()->id,
							'reciver_id' =>  $this->member_id[$x],
							]);
					}
				 }
				$this->competition_member = Comp_member::where('comp_id',$this->comp_id)->with('member','member_position')->get();
				$this->member_id = [];
			}
		}

    }
    public function send_request_referee()
    {
        if($this->comp_id)
        {
			if($this->referee_id)
			{
				for ($x = 0; $x < count($this->referee_id); $x++)
				 {
					if($this->referee_id[$x] == Auth::user()->id)
					{
						$invitation_status = '1';
					}
					else
					{
						$invitation_status = '0';
					}

					$checkmember = Comp_member::where('comp_id',$this->comp_id)->where('member_id',  $this->referee_id[$x])->first();
					if(!($checkmember))
					{
						$comp_request = new Comp_member();
						$comp_request->user_id = Auth::user()->id;
						$comp_request->comp_id = $this->comp_id;
						$comp_request->member_id = $this->referee_id[$x];
						$comp_request->member_position_id = 6;
						$comp_request->invitation_status = $invitation_status;
						$comp_request->save();
						$comp_member_id = $comp_request->id;

						if($this->referee_id[$x] != Auth::user()->id)
						{
						$notification = Notification::create([
							'notify_module_id' => 4,
							'type_id' => $comp_member_id,
							'sender_id' => Auth::user()->id,
							'reciver_id' =>  $this->referee_id[$x],
						 ]);
						}
					}
				}
					$this->competition_member = Comp_member::where('comp_id',$this->comp_id)->with('member','member_position')->get();
                    $this->referee_id = [];
			}
        }
    }
    public function save_competition()
    {
        //dd($this->comp_team_stat);
        if($this->comp_id)
        {
            if(count($this->comp_team_stat) > 0)
            {
                if(count($this->comp_team_stat) > 0)
                {
                    $stat_ids = implode(',',$this->comp_team_stat);
                }
                $stat_tracking = new StatTrack();
                $stat_tracking->tracking_type = 1;
                $stat_tracking->tracking_for = $this->comp_id;
                $stat_tracking->stat_type = 1;
                $stat_tracking->stat_ids = $stat_ids;
                $stat_tracking->is_active = 1;
                $stat_tracking->save();
            }
            $competition = Competition::find($this->comp_id);
            // $competition->sport_levels_id = $this->sport_level_id;
            // $competition->comp_stat_id = implode(",", $this->comp_stat);
            // $competition->top_player_stat_id = 1;
            // $competition->level_method = $this->level_method;
			// $competition->is_active = 1;
            // $competition->save();

            if($this->comp_type_id == 1)
            {
				$this->validate();
                $team = Team::find($this->teamOne);
                $comp_team_request = new Competition_team_request();
                $comp_team_request->competition_id = $this->comp_id;
                $comp_team_request->team_id = $this->teamOne;
                $comp_team_request->user_id = $team->user_id;
                $comp_team_request->save();

                if($team->user_id != Auth::user()->id)
                {
                    $notification = Notification::create([
                        'notify_module_id' => 3,
                        'type_id' => $comp_team_request->id,
                        'sender_id' => Auth::user()->id,
                        'reciver_id' =>  $team->user_id,
                     ]);
                }


                $team2 = Team::find($this->teamTwo);
                $comp_team_request = new Competition_team_request();
                $comp_team_request->competition_id = $this->comp_id;
                $comp_team_request->team_id = $this->teamTwo;
                $comp_team_request->user_id = $team2->user_id;
                $comp_team_request->save();

                if($team2->user_id != Auth::user()->id)
                {
                    $notification = Notification::create([
                        'notify_module_id' => 3,
                        'type_id' => $comp_team_request->id,
                        'sender_id' => Auth::user()->id,
                        'reciver_id' =>  $team2->user_id,
                     ]);
                }
                return redirect(route('competition.show', $this->comp_id));
            }
            else
            {

                $stat_decision_makers = new StatDecisionMaker();
				$stat_decision_makers->decision_stat_for = 1;
				$stat_decision_makers->type_id = $this->comp_id;
                $stat_decision_makers->stat_type = 1;
				$stat_decision_makers->stat_id = 10;
				$stat_decision_makers->stat_order = 1;
				$stat_decision_makers->save();
				if($this->secondkeyranking)
				{
				$stat_decision_makers = new StatDecisionMaker();
				$stat_decision_makers->decision_stat_for = 1;
				$stat_decision_makers->type_id = $this->comp_id;
                $stat_decision_makers->stat_type = 1;
				$stat_decision_makers->stat_id = $this->secondkeyranking;
				$stat_decision_makers->stat_order = 2;
				$stat_decision_makers->save();
                }
                if($this->thirdkeyranking)
				{
				$stat_decision_makers = new StatDecisionMaker();
				$stat_decision_makers->decision_stat_for = 1;
				$stat_decision_makers->type_id = $this->comp_id;
                $stat_decision_makers->stat_type = 1;
				$stat_decision_makers->stat_id = $this->thirdkeyranking;
				$stat_decision_makers->stat_order = 3;
				$stat_decision_makers->save();
                }
                if($this->player_ranking)
				{
				$stat_decision_makers = new StatDecisionMaker();
				$stat_decision_makers->decision_stat_for = 1;
				$stat_decision_makers->type_id = $this->comp_id;
                $stat_decision_makers->stat_type = 2;
				$stat_decision_makers->stat_id = $this->player_ranking;
				$stat_decision_makers->stat_order = 1;
				$stat_decision_makers->save();
                }


				return redirect(route('competition.show', $this->comp_id));
                //return redirect()->to('KO-competition/'.$competition->id);
            }

        }

    }
    public function remove_member($id)
    {
        $comp_member = Comp_member::find($id);
        $comp_member->invitation_status = 3;
        $comp_member->save();
    }
    public function t_rank_1()
    {
        $this->team_ranking_stat1;
    }
    public function t_rank_2()
    {
        $this->team_ranking_stat2;
    }

	public function notready_game()
	{
		$this->dispatch('swal:modal', [

                    'message' => 'COMING SOON',

                ]);
		$this->game_id = 1;
	}
	public function reset_step_one()
	{
		return redirect('competition\create');
	}
	public function openmodalbanner()
		{
			$this->bannerpreview = $this->banner->temporaryURL();
			$this->dispatch('openModalbannerpreview');
		}
	public function closebannerperivew()
	{
		$this->dispatch('closeModalbannerpreview');
	}
    public function test()
    {
        $this->dispatch('swal:modal', [

            'message' => 'test',

        ]);
    }
	public function add_rule()
    {
        //dd('add_rule');
        if($this->rule_desc)
        {
            $add_rule = new Comp_rule_set();
            $add_rule->comp_id = $this->comp_id;
            $add_rule->user_id = Auth::user()->id;
            $add_rule->description = $this->rule_desc;
            $add_rule->save();
            $this->comp_rules = Comp_rule_set::where('comp_id',$this->comp_id)->where('is_active',1)->get();
            $this->rule_desc = "";
        }

    }
    public function delete_comp_rule($id)
    {
        $delet = Comp_rule_set::find($id)->delete();
        $this->comp_rules = Comp_rule_set::where('comp_id',$this->comp_id)->where('is_active',1)->get();
    }
}
