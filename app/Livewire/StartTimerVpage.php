<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Match_fixture;
use Carbon\Carbon;
use App\Models\Competition;
use App\Models\Team;
use App\Models\Team_member;
use App\Models\Notification;
use App\Models\Fixture_notification;
use App\Models\Match_fixture_stat;
use App\Models\Fixture_squad;
use App\Models\User_fav_follow;
use App\Models\Match_fixture_lapse;
use App\Models\voting;
use App\Models\Comp_member;
use App\Models\Competition_attendee;
use App\Models\SportGroundPosition;
use Illuminate\Support\Facades\Auth;

class StartTimerVpage extends Component
{
    public $match_fixture_id;
    public $increament=0;
    public $time;
    public $fixture_id;
    public $lapse;
	public $match_fixture;
	public $timer_content_first_half;
	public $timer_content_second_half;
	public $resume_time;
	public $fixture_lapse_type;
	public $play_time;
	public $play_resume_time;
	public $modal_teamId;
	public $modal_teamlogo = "competitions-icon-128.png";
	public $modal_teamName;
	public $modal_defendercount;
	public $modal_defensivecount;
	public $modal_medfieldercount;
	public $modal_attackingcount;
	public $modal_forwardcount;
	public $subtitute_players = [];

	public $first_half_timer;
	public $disable_firstHalf;
	public $disable_secondHalf;
	public $second_half_timer;
	public $voting_timer;
	public $halftime;
	public $voting_min;
	public $fixture_squad_team = [];

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
    public function mount($match_fixture_id)
    {
        $this->fixture_id = $match_fixture_id;

		$match_fixture = Match_fixture::find($this->fixture_id);
		$competition = Competition::find($match_fixture->competition_id);
		$this->halftime = $competition->competition_half_time;
		$this->voting_min = $competition->vote_mins;
    }

    public function render()
    {
		$this->match_fixture = Match_fixture::with('competition')->find($this->fixture_id);
		$competition = Competition::find($this->match_fixture->competition_id);

		// Competition admins
		$comp_admins = Comp_member::where('comp_id', $this->match_fixture->competition_id)
			->where('member_position_id', 7)
			->where('invitation_status', 1)
			->where('is_active', 1)
			->with('member')
			->pluck('member_id');
		$admins = $comp_admins->toArray();

		//Team One admins
		$teamOne_admins = Team_member::where('team_id', $this->match_fixture->teamOne_id)
			->where('member_position_id', 4)
			->where('invitation_status', 1)
			->where('is_active', 1)
			->pluck('member_id');
		$teamOne_admin_ids = $teamOne_admins->toArray();
		$team_owner = Team::where('id', $this->match_fixture->teamOne_id)->value('user_id');
		array_push($teamOne_admin_ids, $team_owner);

		// Team Two admins
		$teamTwo_admins = Team_member::where('team_id', $this->match_fixture->teamTwo_id)
			->where('member_position_id', 4)
			->where('invitation_status', 1)
			->where('is_active', 1)
			->pluck('member_id');
		$teamTwo_admin_ids = $teamTwo_admins->toArray();
		$team2_owner = Team::where('id', $this->match_fixture->teamTwo_id)->value('user_id');
		array_push($teamTwo_admin_ids, $team2_owner);

		//Teams Goals
		$fixture_stat_record = Match_fixture_stat::where('match_fixture_id', $this->fixture_id)
			->whereIn('sport_stats_id', [1, 54])
			->get();
		$teamOneGoal = 0;
		$teamTwoGoal = 0;


		foreach ($fixture_stat_record as $fix_sat) {
			if ($fix_sat->team_id == $this->match_fixture->teamOne_id && $fix_sat->match_fixture_id == $this->match_fixture->id) {
				$teamOneGoal++;
			}
			if ($fix_sat->team_id == $this->match_fixture->teamTwo_id && $fix_sat->match_fixture_id == $this->match_fixture->id) {
				$teamTwoGoal++;
			}
		}


		$this->fixture_lapse_type = Match_fixture_lapse::where('match_fixture_id',$this->fixture_id)->orderBy('id', 'desc')->latest()->first();
		if($this->match_fixture->startdate_time != NULL)
		{
			$check_pause_lapse_time = Match_fixture_lapse::where('match_fixture_id',$this->fixture_id)->orderBy('id', 'desc')->latest()->first();
			if($check_pause_lapse_time->lapse_type == 6)
			{
				$get_pause_lapse_time = Match_fixture_lapse::where(['match_fixture_id' => $this->fixture_id, 'lapse_type' => 6])->orderBy('id', 'desc')->get();
				$count_pause_lapse_time = $get_pause_lapse_time->count();
				//dd($count_pause_lapse_time);
				if($count_pause_lapse_time == 1){
					$start = $this->match_fixture->startdate_time;
					$dateTimeObject1 = date_create($start);
					$dateTimeObject2 = date_create($check_pause_lapse_time->lapse_time);
					$difference = date_diff($dateTimeObject1, $dateTimeObject2);
					$this->timer_content_first_half =  $difference->format('%I:%S');

					//first half timer
					$first_half_timer = $difference->format('%I:%S');
					$explode_firstHalf_time = explode(':', $first_half_timer);
					$total_firstHalf = ($explode_firstHalf_time[0] * 60) + $explode_firstHalf_time[1];
					$calculate_first_half_timer = ($this->halftime * 60) - $total_firstHalf;
					$this->first_half_timer =  date("i:s", $calculate_first_half_timer);
				}
				else{
					$collect_pause_time =  array();
					foreach($get_pause_lapse_time as $tttt){
						$collect_pause_time[] =  strtotime($tttt->lapse_diff);
					}

					$sum_pause = array_sum($collect_pause_time);
					//dd($sum_pause);
					$this->timer_content_first_half = date("i:s",$sum_pause);

					// First half pause time calculation
					$cal_pause_timer = ($this->halftime * 60) - $sum_pause;
					$this->first_half_timer = date("i:s", $cal_pause_timer);

				}

				//dd($this->timer_content_first_half);
			}
			else
			{
				$check_start_lapse_time = Match_fixture_lapse::where('match_fixture_id',$this->fixture_id)->latest()->first();

				if($check_start_lapse_time->lapse_type == 1)
				{

					$start = $this->match_fixture->startdate_time;
					$dateTimeObject1 = date_create($start);
					$dateTimeObject2 = now();
					$difference = date_diff($dateTimeObject1, $dateTimeObject2);
					$this->timer_content_first_half =  $difference->format('%I:%S');
					$first_half_mins = $difference->format('%I');

					//first half timer
					$first_half_timer = $difference->format('%I:%S');
					$explode_firstHalf_time = explode(':', $first_half_timer);
					$total_firstHalf = ($explode_firstHalf_time[0] * 60) + $explode_firstHalf_time[1];
					$firstHalf_endTime = $this->halftime * 60;
					if($firstHalf_endTime <= $total_firstHalf){
						$this->first_half_timer = "00:00";
					}else{
					$calculate_first_half_timer = $firstHalf_endTime - $total_firstHalf;
					$this->first_half_timer =  date("i:s", $calculate_first_half_timer);
					}

					//dd($first_half_mins.'=='. $competition->competition_half_time);
					if($total_firstHalf >= $firstHalf_endTime)
					{
						//dd('enter half timer condition');
						if($this->fixture_lapse_type->lapse_type == 1 || $this->fixture_lapse_type->lapse_type == 5)
						{
							$player_team_id = Match_fixture_stat::where('match_fixture_id',$this->match_fixture->id)->latest()->first();
							$check_firstHalf_finishStat = Match_fixture_stat::where('match_fixture_id',$this->match_fixture->id)->where('sport_stats_id', 13)->count();
							if($check_firstHalf_finishStat == 0)
							{
								$match_fixture_lapse = new Match_fixture_lapse();
								$match_fixture_lapse->match_fixture_id = $this->match_fixture->id;
								$match_fixture_lapse->lapse_type = 2;
								$match_fixture_lapse->lapse_time = now();
								$match_fixture_lapse->save();

								$match_fixture_stat = new Match_fixture_stat();
								$match_fixture_stat->competition_id = $this->match_fixture->competition_id;
								$match_fixture_stat->match_fixture_id = $this->match_fixture->id;
								$match_fixture_stat->team_id = $player_team_id->team_id;
								$match_fixture_stat->stat_type = 2;
								$match_fixture_stat->player_id = $player_team_id->player_id;
								$match_fixture_stat->sport_stats_id = 13;
								$match_fixture_stat->half_type = 1;
								$match_fixture_stat->stat_time = now();
								$match_fixture_stat->stat_time_record = "60:00";
								$match_fixture_stat->save();
							}
						}
						elseif($this->fixture_lapse_type->lapse_type == 6)
						{
							//dd('greater than condition');
							$start = $this->match_fixture->startdate_time;
							$second_dateTimeObject1 = date_create($start);
							$second_dateTimeObject2 =date_create($this->fixture_lapse_type->lapse_time);
							$second_difference = date_diff($second_dateTimeObject1, $second_dateTimeObject2);
							$this->resume_time =  $second_difference->format('%I:%S');
						}
					}
					else
					{

					}
				}
				else
				{
					if($check_start_lapse_time->lapse_type == 2)
					{
						$this->timer_content_second_half = "Start";
						$this->second_half_timer = "Start";
					}
					elseif($this->fixture_lapse_type->lapse_type == 3)
					{
						$second_start = $this->fixture_lapse_type->lapse_time;
						$second_dateTimeObject1 = date_create($second_start);
						$second_dateTimeObject2 = now();
						$second_difference = date_diff($second_dateTimeObject1, $second_dateTimeObject2);
						$this->timer_content_second_half =  $second_difference->format('%I:%S');
						$dumy_var_timer1 = $second_difference->format('%I');

						//Second half timer
						$second_half_timer = $second_difference->format('%I:%S');
						$explode_secondHalf_time = explode(':', $second_half_timer);
						$total_secondHalf = ($explode_secondHalf_time[0] * 60) + $explode_secondHalf_time[1];
						$seconndHalf_endTime = $this->halftime * 60;
						if($seconndHalf_endTime <= $total_secondHalf){
							$this->second_half_timer = "00:00";
						}else{
						$calculate_second_half_timer = $seconndHalf_endTime - $total_secondHalf;
						$this->second_half_timer =  date("i:s", $calculate_second_half_timer);
						}

						if($total_secondHalf >= $seconndHalf_endTime)
						{
							//dd('enter half timer condition');
							if($this->fixture_lapse_type->lapse_type == 3 || $this->fixture_lapse_type->lapse_type == 8)
							{
								$match_fixture_lapse = new Match_fixture_lapse();
								$match_fixture_lapse->match_fixture_id = $this->match_fixture->id;
								$match_fixture_lapse->lapse_type = 4;
								$match_fixture_lapse->lapse_time = now();
								$match_fixture_lapse->save();

								$player_team_id = Match_fixture_stat::where('match_fixture_id',$this->match_fixture->id)->latest()->first();
								$check_firstHalf_finishStat = Match_fixture_stat::where('match_fixture_id',$this->match_fixture->id)->where('sport_stats_id', 15)->count();
								if($check_firstHalf_finishStat == 0)
								{
									$match_fixture_stat = new Match_fixture_stat();
									$match_fixture_stat->competition_id = $this->match_fixture->competition_id;
									$match_fixture_stat->match_fixture_id = $this->match_fixture->id;
									$match_fixture_stat->team_id = $player_team_id->team_id;
									$match_fixture_stat->stat_type = 2;
									$match_fixture_stat->player_id = $player_team_id->player_id;
									$match_fixture_stat->sport_stats_id = 15;
									$match_fixture_stat->half_type = 2;
									$match_fixture_stat->stat_time = now();
									$match_fixture_stat->stat_time_record = "60:00";
									$match_fixture_stat->save();
								}

							}
							elseif($this->fixture_lapse_type->lapse_type == 9)
							{
								//dd('greater than condition');
								$start = $this->match_fixture->startdate_time;
								$second_dateTimeObject1 = date_create($start);
								$second_dateTimeObject2 =date_create($this->fixture_lapse_type->lapse_time);
								$second_difference = date_diff($second_dateTimeObject1, $second_dateTimeObject2);
								$this->resume_time =  $second_difference->format('%I:%S');
							}
						}
						else
						{

						}
						// if($this->timer_content_second_half >= $competition->competition_half_time)
						// {
							// $match_fixture_lapse = new Match_fixture_lapse();
							// $match_fixture_lapse->match_fixture_id = $this->match_fixture->id;
							// $match_fixture_lapse->lapse_type = 4;
							// $match_fixture_lapse->lapse_time = now();
							// $match_fixture_lapse->save();
						// }
					}
					elseif($this->fixture_lapse_type->lapse_type == 5)
					{
						$last_resume_time =  Match_fixture_lapse::where('match_fixture_id',$this->fixture_id)->where('lapse_type',6)->orderBy('id', 'desc')->get();


						$collect_pause_time =  array();
						foreach($last_resume_time as $tttt){
							$collect_pause_time[] =  strtotime($tttt->lapse_diff);
						}

						$sum_pause = array_sum($collect_pause_time);
						//dd($sum_pause);
						$resume_time = date("H:i:s",$sum_pause);
						//dd($resume_time);

						//$start = $this->match_fixture->startdate_time;
						//$last_dateTimeObject1 = date_create($start);
						//$last_dateTimeObject2 = date_create($last_resume_time->lapse_time);
						//$last_difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
						//$resume_time =  $last_difference->format('%H:%I:%S');

						$last_dateTimeObject1 = date_create($this->fixture_lapse_type->lapse_time);
						$last_dateTimeObject2 = now();
						$last_difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
						$lapse_play_time =  $last_difference->format('%H:%I:%S');
						$tmstamp = strtotime($resume_time) + strtotime($lapse_play_time);
						$this->timer_content_first_half = date("i:s",$tmstamp);
						$_play_first_half_mins = date("i",$tmstamp);

						//first half resume time calculation
						$endTime_FirstHalf = $this->halftime * 60;
						if($endTime_FirstHalf >= $tmstamp)
						{
							$this->first_half_timer = "00:00";
						}else{
						$cal_resume_timer = $endTime_FirstHalf - $tmstamp;
						$this->first_half_timer = date("i:s", $cal_resume_timer);
						}

						//$ffff = date("i:s",$tmstamp);
						//$this->timer_content_first_half = "last_resume_time" . $last_resume_time->lapse_time ."|| resume_time".$resume_time." + ".$lapse_play_time." = ".$ffff;
						if($_play_first_half_mins >= $competition->competition_half_time)
						{
							//dd('enter half timer condition');
							if($this->fixture_lapse_type->lapse_type == 1 || $this->fixture_lapse_type->lapse_type == 5)
							{
								$match_fixture_lapse = new Match_fixture_lapse();
								$match_fixture_lapse->match_fixture_id = $this->match_fixture->id;
								$match_fixture_lapse->lapse_type = 2;
								$match_fixture_lapse->lapse_time = now();
								$match_fixture_lapse->save();

								$player_team_id = Match_fixture_stat::where('match_fixture_id',$this->match_fixture->id)->latest()->first();
								if($player_team_id->sport_stats_id != 13)
								{
									$match_fixture_stat = new Match_fixture_stat();
									$match_fixture_stat->competition_id = $this->match_fixture->competition_id;
									$match_fixture_stat->match_fixture_id = $this->match_fixture->id;
									$match_fixture_stat->team_id = $player_team_id->team_id;
									$match_fixture_stat->stat_type = 2;
									$match_fixture_stat->player_id = $player_team_id->player_id;
									$match_fixture_stat->sport_stats_id = 13;
									$match_fixture_stat->half_type = 1;
									$match_fixture_stat->stat_time = now();
									$match_fixture_stat->stat_time_record = "60:00";
									$match_fixture_stat->save();

								}

							}
							elseif($this->fixture_lapse_type->lapse_type == 6)
							{
								//dd('greater than condition');
								$start = $this->match_fixture->startdate_time;
								$second_dateTimeObject1 = date_create($start);
								$second_dateTimeObject2 =date_create($this->fixture_lapse_type->lapse_time);
								$second_difference = date_diff($second_dateTimeObject1, $second_dateTimeObject2);
								$this->resume_time =  $second_difference->format('%I:%S');
							}
						}
						else
						{

						}

					}
					else
					{
						if($this->fixture_lapse_type->lapse_type == 4)
						{
							$this->timer_content_second_half = "COMPLETED"; // second half completed
							$this->second_half_timer = "COMPLETED"; // second half completed
						}
						else
						{
							if($this->fixture_lapse_type->lapse_type == 9)
							{
								$get_pause_lapse_time = Match_fixture_lapse::where(['match_fixture_id' => $this->fixture_id, 'lapse_type' => 9])->orderBy('id', 'desc')->get();

								$count_pause_lapse_time = $get_pause_lapse_time->count();
								//dd($count_pause_lapse_time);
								if($count_pause_lapse_time == 1){

									$get_second_half_start_time = Match_fixture_lapse::where(['match_fixture_id' => $this->fixture_id, 'lapse_type' => 3])->latest()->first();
									$start = $get_second_half_start_time->lapse_time;
									$dateTimeObject1 = date_create($start);
									$dateTimeObject2 = date_create($this->fixture_lapse_type->lapse_time);
									$difference = date_diff($dateTimeObject1, $dateTimeObject2);
									$this->timer_content_second_half =  $difference->format('%I:%S');

									//Second half timer calculation
									$second_half_timer = $difference->format('%I:%S');
									$explode_secondHalf_time = explode(':', $second_half_timer);
									$total_secondHalf = ($explode_secondHalf_time[0] * 60) + $explode_secondHalf_time[1];
									$calculate_second_half_timer = ($this->halftime * 60) - $total_secondHalf;
									$this->second_half_timer =  date("i:s", $calculate_second_half_timer);
								}
								else{
									$collect_pause_time =  array();
									foreach($get_pause_lapse_time as $tttt){
										$collect_pause_time[] =  strtotime($tttt->lapse_diff);
									}

									$sum_pause = array_sum($collect_pause_time);
									//dd($sum_pause);
									$this->timer_content_second_half = date("i:s",$sum_pause);

									//second half pause time calculation
									$cal_secandHalf_pause_time = ($this->halftime * 60) - $sum_pause;
									$this->second_half_timer = date("i:s", $cal_secandHalf_pause_time);

								}

								//dd($this->timer_content_first_half);
							}
							elseif($this->fixture_lapse_type->lapse_type == 8)
								{
									$last_resume_time =  Match_fixture_lapse::where('match_fixture_id',$this->fixture_id)->where('lapse_type',9)->orderBy('id', 'desc')->get();


									$collect_pause_time =  array();
									foreach($last_resume_time as $tttt){
										$collect_pause_time[] =  strtotime($tttt->lapse_diff);
									}

									$sum_pause = array_sum($collect_pause_time);
									//dd($sum_pause);
									$resume_time = date("H:i:s",$sum_pause);
									//dd($resume_time);

									//$start = $this->match_fixture->startdate_time;
									//$last_dateTimeObject1 = date_create($start);
									//$last_dateTimeObject2 = date_create($last_resume_time->lapse_time);
									//$last_difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
									//$resume_time =  $last_difference->format('%H:%I:%S');

									$last_dateTimeObject1 = date_create($this->fixture_lapse_type->lapse_time);
									$last_dateTimeObject2 = now();
									$last_difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
									$lapse_play_time =  $last_difference->format('%H:%I:%S');
									$tmstamp = strtotime($resume_time) + strtotime($lapse_play_time);
									$this->timer_content_second_half = date("i:s",$tmstamp);
									$dumy_var_timer = date("i",$tmstamp);

									// second half resume time calculation
									$endTime_secondHalf = $this->halftime * 60;
									if($endTime_secondHalf >= $tmstamp){
										$this->second_half_timer = "00:00";
									}else{
									$cal_secandHalf_resume_time = ($this->halftime * 60) - $tmstamp;
									$this->second_half_timer = date("i:s", $cal_secandHalf_resume_time);
									}

									//$ffff = date("i:s",$tmstamp);
									//$this->timer_content_first_half = "last_resume_time" . $last_resume_time->lapse_time ."|| resume_time".$resume_time." + ".$lapse_play_time." = ".$ffff;
									if($dumy_var_timer >= $competition->competition_half_time)
									{
										//dd('enter half timer condition');
										if($this->fixture_lapse_type->lapse_type == 3 || $this->fixture_lapse_type->lapse_type == 8)
										{
											$get_second_half_finishLap = Match_fixture_lapse::where(['match_fixture_id' => $this->fixture_id, 'lapse_type' => 4])->orderBy('id', 'DESC')->get();
											if(count($get_second_half_finishLap) == 0){
												$match_fixture_lapse = new Match_fixture_lapse();
												$match_fixture_lapse->match_fixture_id = $this->match_fixture->id;
												$match_fixture_lapse->lapse_type = 4;
												$match_fixture_lapse->lapse_time = now();
												$match_fixture_lapse->save();

												$player_team_id = Match_fixture_stat::where('match_fixture_id',$this->match_fixture->id)->latest()->first();
												if($player_team_id->sport_stats_id != 15)
												{
													$match_fixture_stat = new Match_fixture_stat();
													$match_fixture_stat->competition_id = $this->match_fixture->competition_id;
													$match_fixture_stat->match_fixture_id = $this->match_fixture->id;
													$match_fixture_stat->team_id = $player_team_id->team_id;
													$match_fixture_stat->stat_type = 2;
													$match_fixture_stat->player_id = $player_team_id->player_id;
													$match_fixture_stat->sport_stats_id = 15;
													$match_fixture_stat->half_type = 2;
													$match_fixture_stat->stat_time = now();
													$match_fixture_stat->stat_time_record = "60:00";
													$match_fixture_stat->save();
												}
											}

										}
										elseif($this->fixture_lapse_type->lapse_type == 9)
										{
											//dd('greater than condition');
											$start = $this->match_fixture->startdate_time;
											$second_dateTimeObject1 = date_create($start);
											$second_dateTimeObject2 =date_create($this->fixture_lapse_type->lapse_time);
											$second_difference = date_diff($second_dateTimeObject1, $second_dateTimeObject2);
											$this->resume_time =  $second_difference->format('%I:%S');
										}
									}
									else
									{

									}

								}
									elseif($this->fixture_lapse_type->lapse_type == 7)
								{
									$this->timer_content_second_half = "COMPLETED"; // second half completed
									$this->second_half_timer = "COMPLETED"; // second half completed
								}

						}

					}

				}

			}

		}
		else
		{

			$this->timer_content_first_half = "Start";
			$this->first_half_timer = "Start";

		}

			// Voting time
			$finish_time = $this->match_fixture->finishdate_time;
			$dateTimeObject1 = date_create($finish_time);
			$dateTimeObject2 = now();
			$difference = date_diff($dateTimeObject1, $dateTimeObject2);
			$voting_minutes = $difference->format('%I');

			//voting countdown calculation
			$voting_start_time = strtotime($this->match_fixture->finishdate_time);
			$cal_voting_end_time = $voting_start_time + ($this->voting_min * 60);

			$votingTime_Left = $cal_voting_end_time - strtotime(now());
			$votingdays = floor($votingTime_Left / (60*60*24));//day
			$votingTime_Left %= (60 * 60 * 24);
			$votinghours = floor($votingTime_Left / (60 * 60));//hour
			$votingTime_Left %= (60 * 60);
			$votingmin = floor($votingTime_Left / 60);//min
			$votingTime_Left %= 60;
			$votingsec = $votingTime_Left;//sec
			if($votingsec < 10){
				$v_zeros = '0';
			}else{
				$v_zeros = '';
			}
			if($votingmin < 10){
				$v_zerom = '0';
			}else{
				$v_zerom = '';
			}

			$this->voting_timer = $v_zerom.$votingmin.':'.$v_zeros.$votingsec;

			$defender_position_ids = SportGroundPosition::where('ground_coordinates',2)->pluck('id');
			$teamOne_defender = Fixture_squad::where('match_fixture_id',$this->match_fixture->id)->where('team_id',$this->match_fixture->teamOne_id)->whereIn('sport_ground_positions_id',$defender_position_ids)->where('is_active',1)->count();
			$defensive_ids = SportGroundPosition::where('ground_coordinates',3)->pluck('id');
			$teamOne_defensive = Fixture_squad::where('match_fixture_id',$this->match_fixture->id)->where('team_id',$this->match_fixture->teamOne_id)->whereIn('sport_ground_positions_id',$defensive_ids)->where('is_active',1)->count();
			$medfielder_ids = SportGroundPosition::where('ground_coordinates',4)->pluck('id');
			$teamOne_midfielder = Fixture_squad::where('match_fixture_id',$this->match_fixture->id)->where('team_id',$this->match_fixture->teamOne_id)->whereIn('sport_ground_positions_id',$medfielder_ids)->where('is_active',1)->count();
			$attacking_ids = SportGroundPosition::where('ground_coordinates',5)->pluck('id');
			$teamOne_attacking = Fixture_squad::where('match_fixture_id',$this->match_fixture->id)->where('team_id',$this->match_fixture->teamOne_id)->whereIn('sport_ground_positions_id',$attacking_ids)->where('is_active',1)->count();
			$forward_ids = SportGroundPosition::where('ground_coordinates',6)->pluck('id');
			$teamOne_forward = Fixture_squad::where('match_fixture_id',$this->match_fixture->id)->where('team_id',$this->match_fixture->teamOne_id)->whereIn('sport_ground_positions_id',$forward_ids)->where('is_active',1)->count();

			$teamTwo_defender = Fixture_squad::where('match_fixture_id',$this->match_fixture->id)->where('team_id',$this->match_fixture->teamTwo_id)->whereIn('sport_ground_positions_id',$defender_position_ids)->where('is_active',1)->count();
			$teamTwo_defensive = Fixture_squad::where('match_fixture_id',$this->match_fixture->id)->where('team_id',$this->match_fixture->teamTwo_id)->whereIn('sport_ground_positions_id',$defensive_ids)->where('is_active',1)->count();
			$teamTwo_midfielder = Fixture_squad::where('match_fixture_id',$this->match_fixture->id)->where('team_id',$this->match_fixture->teamTwo_id)->whereIn('sport_ground_positions_id',$medfielder_ids)->where('is_active',1)->count();
			$teamTwo_attacking = Fixture_squad::where('match_fixture_id',$this->match_fixture->id)->where('team_id',$this->match_fixture->teamTwo_id)->whereIn('sport_ground_positions_id',$attacking_ids)->where('is_active',1)->count();
			$teamTwo_forward = Fixture_squad::where('match_fixture_id',$this->match_fixture->id)->where('team_id',$this->match_fixture->teamTwo_id)->whereIn('sport_ground_positions_id',$forward_ids)->where('is_active',1)->count();
			$teamOne_color = Team::select('team_color','font_color')->find($this->match_fixture->teamOne_id);
			$teamTwo_color = Team::select('team_color','font_color')->find($this->match_fixture->teamTwo_id);
			$ground_map_position = SportGroundPosition::get();


			if($this->match_fixture->competition->vote_mins == $voting_minutes)
			{
				// dd('enter mvp player');
				$Playervoting = voting::groupBy('player_id')->where('match_fixture_id',$this->match_fixture->id)->selectRaw('count(*) as total, player_id')->get();
				$manoftheMatch_player_id = $Playervoting->toArray();
		        if($Playervoting->count() > 0)
		        {
		         	$max_vote =  max($manoftheMatch_player_id);

					$check = Fixture_squad::where('match_fixture_id',$this->match_fixture->id)->where('player_id',$max_vote['player_id'])->where('is_active',1)->first();
					if(!empty($check))
					{
						$update_mvp = Fixture_squad::find($check->id);
						$update_mvp->status_desc = 1;
						$update_mvp->save();
					}
				}

            //dd($max_vote['player_id']);


        }
        return view('livewire.start-timer-vpage',compact('admins','teamOneGoal','teamTwoGoal','competition','voting_minutes','teamOne_defender','teamOne_defensive','teamOne_midfielder','teamOne_attacking','teamOne_forward','teamTwo_defender','teamTwo_defensive','teamTwo_midfielder','teamTwo_attacking','teamTwo_forward','teamOne_admin_ids','teamTwo_admin_ids','teamOne_color','teamTwo_color','ground_map_position'));
    }

	public function start_fixture()
	{
		$this->disable_firstHalf = true;

		$checkMatchReferee = $this->match_fixture->refree_id;

		if ($checkMatchReferee !== "") {
			$fixture_squad_teamOne = Fixture_squad::where('match_fixture_id', $this->match_fixture->id)
				->where('team_id', $this->match_fixture->teamOne_id)
				->get();
			$fixture_squad_teamTwo = Fixture_squad::where('match_fixture_id', $this->match_fixture->id)
				->where('team_id', $this->match_fixture->teamTwo_id)
				->get();

			if ($fixture_squad_teamOne->isEmpty() || $fixture_squad_teamTwo->isEmpty()) {
				$this->dispatch('swal:modal', [
					'message' => 'Please select squad players',
				]);
			} else {
				$is_start = Match_fixture_lapse::where('match_fixture_id', $this->match_fixture->id)->get();

				if (count($is_start) == 0) {
					// Record match start lapse
					$match_fixture_lapse = new Match_fixture_lapse();
					$match_fixture_lapse->match_fixture_id = $this->match_fixture->id;
					$match_fixture_lapse->lapse_type = 1;
					$match_fixture_lapse->lapse_time = now();
					$match_fixture_lapse->save();

					// Notify users
					$competition = Competition::find($this->match_fixture->competition_id);
					$teamOne = Team::find($this->match_fixture->teamOne_id);
					$teamTwo = Team::find($this->match_fixture->teamTwo_id);

					$teamOne_Follower = User_fav_follow::where('is_type', 1)
						->where('type_id', $teamOne->id)
						->where('Is_follow', 1)
						->orWhere('Is_fav', 1)
						->pluck('user_id');

					$teamTwo_Follower = User_fav_follow::where('is_type', 1)
						->where('type_id', $teamTwo->id)
						->where('Is_follow', 1)
						->orWhere('Is_fav', 1)
						->pluck('user_id');

					$comp_follower = User_fav_follow::where('is_type', 2)
						->where('type_id', $this->match_fixture->competition_id)
						->where('Is_follow', 1)
						->orWhere('Is_fav', 1)
						->pluck('user_id');

					$user = array_merge($teamOne_Follower->toArray(), $teamTwo_Follower->toArray(), $comp_follower->toArray());
					array_push($user, $teamOne->user_id, $teamTwo->user_id);
					$allusersunique = array_values(array_unique($user));

					foreach ($allusersunique as $userId) {
						if ($userId != Auth::user()->id) {
							$notification = new Notification();
							$notification->notify_module_id = 6;
							$notification->type_id = $this->match_fixture->id;
							$notification->sender_id = $competition->user_id;
							$notification->reciver_id = $userId;
							$notification->save();
						}
					}

					// Update start date and time
					$time = now();
					$match_fixture = Match_fixture::find($this->match_fixture->id);
					$match_fixture->startdate_time = $time;
					$match_fixture->save();

					// Record match fixture stat for the first half
					$team_player = Competition_attendee::where('Competition_id', $this->match_fixture->competition_id)
						->where('team_id', $this->match_fixture->teamOne_id)
						->first();

					$match_fixture_stat = new Match_fixture_stat();
					$match_fixture_stat->match_fixture_id = $this->match_fixture->id;
					$match_fixture_stat->competition_id = $this->match_fixture->competition_id;
					$match_fixture_stat->team_id = $this->match_fixture->teamOne_id;
					$match_fixture_stat->stat_type = 2;
					$match_fixture_stat->player_id = $team_player->attendee_id;
					$match_fixture_stat->sport_stats_id = 12;
					$match_fixture_stat->stat_time = now();
					$match_fixture_stat->half_type = 1;
					$match_fixture_stat->save();
				}
			}

			$this->disable_firstHalf = false;
		} else {
			$this->dispatch('swal:modal', [
				'message' => 'Please select Referee for the match.',
			]);
		}
	}

	public function start_second_half()
	{
		$this->disable_secondHalf = true;

		$is_start = Match_fixture_lapse::where('match_fixture_id', $this->match_fixture->id)
			->where('lapse_type', 3)
			->get();

		// $stat_time = Match_fixture_stat::select('stat_time')
		//     ->where('match_fixture_id', $this->fixture_id)
		//     ->where('stat_type', 2)
		//     ->where('sport_stats_id', 12)
		//     ->get();

		if (count($is_start) == 0) {
			// Record second half start lapse
			$match_fixture_lapse = new Match_fixture_lapse();
			$match_fixture_lapse->match_fixture_id = $this->match_fixture->id;
			$match_fixture_lapse->lapse_type = 3;
			$match_fixture_lapse->lapse_time = now();
			$match_fixture_lapse->save();

			// Record match fixture stat for the second half
			$team_player = Competition_attendee::select('attendee_id')
				->where('Competition_id', $this->match_fixture->competition_id)
				->where('team_id', $this->match_fixture->teamOne_id)
				->first();

			$match_fixture_stat = new Match_fixture_stat();
			$match_fixture_stat->match_fixture_id = $this->match_fixture->id;
			$match_fixture_stat->competition_id = $this->match_fixture->competition_id;
			$match_fixture_stat->team_id = $this->match_fixture->teamOne_id;
			$match_fixture_stat->stat_type = 2;
			$match_fixture_stat->player_id = $team_player->attendee_id;
			$match_fixture_stat->sport_stats_id = 14;
			$match_fixture_stat->stat_time = now();
			// $match_fixture_stat->stat_time_record = $stat_time_record;
			$match_fixture_stat->half_type = 2;
			$match_fixture_stat->save();
		}

		$this->disable_secondHalf = false;
	}



	public function pause_first_half()
	{
		$this->disable_firstHalf = true;

		// Fetch the latest match fixture lapse
		$matchFixture_latestStat = Match_fixture_lapse::where('match_fixture_id', $this->fixture_id)->orderBy('id', 'desc')->first();

		if ($matchFixture_latestStat->lapse_type == 5 || $matchFixture_latestStat->lapse_type == 1) {
			// Record lapse time for pause
			$match_fixture_lapse = new Match_fixture_lapse();
			$match_fixture_lapse->match_fixture_id = $this->match_fixture->id;
			$match_fixture_lapse->lapse_type = 6;
			$match_fixture_lapse->lapse_time = now();
			$match_fixture_lapse->save();

			// Calculate lapse time difference
			$get_pause_lapse_time = Match_fixture_lapse::where(['match_fixture_id' => $this->fixture_id, 'lapse_type' => 6])->orderBy('id', 'desc')->get();
			$count_pause_lapse_time = $get_pause_lapse_time->count();

			if ($count_pause_lapse_time <= 1) {
				$start = $this->match_fixture->startdate_time;
				$dateTimeObject1 = date_create($start);
				$dateTimeObject2 = now();
				$difference = date_diff($dateTimeObject1, $dateTimeObject2);
				$lapse_diff = $difference->format('%H:%I:%S');
			} else {
				$get_play_lapse_time = Match_fixture_lapse::where(['match_fixture_id' => $this->fixture_id, 'lapse_type' => 5])->orderBy('id', 'desc')->first();
				$last_dateTimeObject1 = date_create($match_fixture_lapse->lapse_time);
				$last_dateTimeObject2 = date_create($get_play_lapse_time->created_at);
				$difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
				$lapse_diff = $difference->format('%H:%I:%S');
			}

			// Update lapse time difference
			$update_match_fixture = Match_fixture_lapse::find($match_fixture_lapse->id);
			$update_match_fixture->lapse_diff = $lapse_diff;
			$update_match_fixture->save();

			// Fetch team player information
			$team_player = Competition_attendee::select('attendee_id')->where('Competition_id', $this->match_fixture->competition_id)
				->where('team_id', $this->match_fixture->teamOne_id)->first();

			// Fetch the latest fixture stat
			$latest_fixture_stat = Match_fixture_stat::select('stat_time')
				->where('match_fixture_id', $this->match_fixture->id)
				->where('sport_stats_id', 12)
				->latest()
				->first();

			// Record match fixture stat for pause
			$match_fixture_stat = new Match_fixture_stat();
			$match_fixture_stat->match_fixture_id = $this->match_fixture->id;
			$match_fixture_stat->competition_id = $this->match_fixture->competition_id;
			$match_fixture_stat->team_id = $this->match_fixture->teamOne_id;
			$match_fixture_stat->stat_type = 2;
			$match_fixture_stat->player_id = $team_player->attendee_id;
			$match_fixture_stat->sport_stats_id = 16;
			$match_fixture_stat->stat_time = now();
			$match_fixture_stat->half_type = 1;
			$match_fixture_stat->save();

			// Update sport detail for pause
			$last_dateTimeObject1 = date_create($latest_fixture_stat->stat_time);
			$last_dateTimeObject2 = date_create($match_fixture_stat->stat_time);
			$difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
			$stat_diff = $difference->format('%H:%I:%S');
			$stat_time_record = $difference->format('%H:%I:%S');

			$update_stat = Match_fixture_stat::find($match_fixture_stat->id);
			$update_stat->stat_diff = $stat_diff;
			$update_stat->stat_time_record = $stat_time_record;
			$update_stat->save();
		}

		$this->disable_firstHalf = false;
	}

	public function play_first_half()
	{
		$this->disable_firstHalf = true;

		// Calculate time for the first half
		$firstHalf_timer_explodetime = explode(':', $this->timer_content_first_half);
		$firstHalf_timer_calTime = $firstHalf_timer_explodetime[0] * 60 + $firstHalf_timer_explodetime[1];
		$comp_halfTime_strTotime = $this->halftime * 60;

		// Fetch the latest match fixture lapse
		$matchFixture_latestStat = Match_fixture_lapse::where('match_fixture_id', $this->fixture_id)->orderBy('id', 'desc')->first();

		if ($matchFixture_latestStat->lapse_type == 6) {
			// Record lapse time for pause
			$match_fixture_lapse = new Match_fixture_lapse();
			$match_fixture_lapse->match_fixture_id = $this->match_fixture->id;
			$match_fixture_lapse->lapse_type = 5;
			$match_fixture_lapse->lapse_time = now();
			$match_fixture_lapse->save();

			// Fetch team player information
			$team_player = Competition_attendee::where('Competition_id', $this->match_fixture->competition_id)
				->where('team_id', $this->match_fixture->teamOne_id)
				->first();

			// Record lapse time difference
			$frist_half_pause = Match_fixture_lapse::where('match_fixture_id', $this->match_fixture->id)
				->where('lapse_type', 6)
				->orderBy('id', 'desc')
				->latest()
				->first();

			$last_dateTimeObject1 = date_create($frist_half_pause->lapse_time);
			$last_dateTimeObject2 = date_create($match_fixture_lapse->lapse_time);
			$difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
			$lapse_diff = $difference->format('%H:%I:%S');

			$update_lapse = Match_fixture_lapse::find($match_fixture_lapse->id);
			$update_lapse->lapse_diff = $lapse_diff;
			$update_lapse->save();

			// Record match fixture stat for the first half
			$match_fixture_stat = new Match_fixture_stat();
			$match_fixture_stat->match_fixture_id = $this->match_fixture->id;
			$match_fixture_stat->competition_id = $this->match_fixture->competition_id;
			$match_fixture_stat->team_id = $this->match_fixture->teamOne_id;
			$match_fixture_stat->stat_type = 2;
			$match_fixture_stat->player_id = $team_player->attendee_id;
			$match_fixture_stat->sport_stats_id = 17;
			$match_fixture_stat->stat_diff = "00:00:00";
			$match_fixture_stat->stat_time = now();
			$match_fixture_stat->half_type = 1;
			$match_fixture_stat->save();

			// Update sport detail for the first half
			$latest_fixture_stat = Match_fixture_stat::select('stat_time')
				->where('match_fixture_id', $this->match_fixture->id)
				->where('sport_stats_id', 12)
				->latest()
				->first();

			$last_dateTimeObject1 = date_create($latest_fixture_stat->stat_time);
			$last_dateTimeObject2 = date_create($match_fixture_stat->stat_time);
			$difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
			$stat_diff = $difference->format('%H:%I:%S');
			$stat_time_record = $difference->format('%H:%I:%S');

			$update_stat = Match_fixture_stat::find($match_fixture_stat->id);
			$update_stat->stat_diff = $stat_diff;
			$update_stat->stat_time_record = $stat_time_record;
			$update_stat->save();

			// Check if the first half timer has exceeded the specified time
			if ($firstHalf_timer_calTime > $comp_halfTime_strTotime) {
				$this->timer_content_second_half = "Start";
			}
		}

		$this->disable_firstHalf = false;
	}

	public function pause_second_half()
	{
		$this->disable_secondHalf = true;

		if ($this->timer_content_second_half != "COMPLETED") {
			// Fetch the latest match fixture lapse
			$matchFixture_latestStat = Match_fixture_lapse::where('match_fixture_id', $this->fixture_id)->orderBy('id', 'desc')->first();

			if ($matchFixture_latestStat->lapse_type == 8 || $matchFixture_latestStat->lapse_type == 3) {
				// Record lapse time for second half pause
				$match_fixture_lapse = new Match_fixture_lapse();
				$match_fixture_lapse->match_fixture_id = $this->match_fixture->id;
				$match_fixture_lapse->lapse_type = 9;
				$match_fixture_lapse->lapse_time = now();
				$match_fixture_lapse->save();

				// Fetch pause lapse times
				$get_pause_lapse_time = Match_fixture_lapse::where(['match_fixture_id' => $this->fixture_id, 'lapse_type' => 9])->orderBy('id', 'desc')->get();
				$count_pause_lapse_time = $get_pause_lapse_time->count();

				if ($count_pause_lapse_time <= 1) {
					// Calculate lapse time difference for the first pause
					$get_second_half_start_time = Match_fixture_lapse::where(['match_fixture_id' => $this->fixture_id, 'lapse_type' => 3])->orderBy('id', 'desc')->latest()->first();
					$start = $get_second_half_start_time->lapse_time;
					$dateTimeObject1 = date_create($start);
					$dateTimeObject2 = date_create($match_fixture_lapse->lapse_time);
					$difference = date_diff($dateTimeObject1, $dateTimeObject2);
					$lapse_diff = $difference->format('%H:%I:%S');
				} else {
					// Calculate lapse time difference for subsequent pauses
					$get_play_lapse_time = Match_fixture_lapse::where(['match_fixture_id' => $this->fixture_id, 'lapse_type' => 8])->orderBy('id', 'desc')->latest()->first();
					$last_dateTimeObject1 = date_create($match_fixture_lapse->lapse_time);
					$last_dateTimeObject2 = date_create($get_play_lapse_time->lapse_time);
					$difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
					$lapse_diff = $difference->format('%H:%I:%S');
				}

				// Update lapse time difference
				$update_match_fixture = Match_fixture_lapse::find($match_fixture_lapse->id);
				$update_match_fixture->lapse_diff = $lapse_diff;
				$update_match_fixture->save();

				// Fetch team player information
				$team_player = Competition_attendee::where('Competition_id', $this->match_fixture->competition_id)
					->where('team_id', $this->match_fixture->teamOne_id)
					->first();

				// Fetch the latest fixture stat
				$latest_fixture_stat = Match_fixture_stat::select('stat_time')
					->where('match_fixture_id', $this->match_fixture->id)
					->where('sport_stats_id', 14)
					->latest()
					->first();

				// Record match fixture stat for the second half
				$match_fixture_stat = new Match_fixture_stat();
				$match_fixture_stat->match_fixture_id = $this->match_fixture->id;
				$match_fixture_stat->competition_id = $this->match_fixture->competition_id;
				$match_fixture_stat->team_id = $this->match_fixture->teamOne_id;
				$match_fixture_stat->stat_type = 2;
				$match_fixture_stat->player_id = $team_player->attendee_id;
				$match_fixture_stat->sport_stats_id = 18;
				$match_fixture_stat->stat_time = now();
				$match_fixture_stat->half_type = 2;
				$match_fixture_stat->save();

				// Update sport detail for the second half
				$last_dateTimeObject1 = date_create($latest_fixture_stat->stat_time);
				$last_dateTimeObject2 = date_create($match_fixture_stat->stat_time);
				$difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
				$stat_diff = $difference->format('%H:%I:%S');
				$stat_time_record = $difference->format('%H:%I:%S');

				// Update stat information
				$update_stat = Match_fixture_stat::find($match_fixture_stat->id);
				$update_stat->stat_diff = $stat_diff;
				$update_stat->stat_time_record = $stat_time_record;
				$update_stat->save();
			}
		}

		$this->disable_secondHalf = false;
	}

	public function play_second_half()
	{
		$this->disable_secondHalf = true;

		if ($this->timer_content_second_half != "COMPLETED") {
			// Calculate time for the second half
			$secondHalf_timer_explodeTime = explode(":", $this->timer_content_second_half);
			$secondHalf_timer_calTime = $secondHalf_timer_explodeTime[0] * 60 + $secondHalf_timer_explodeTime[1];
			$comp_halfTime_strTotime = $this->halftime * 60;

			// Fetch the latest match fixture lapse
			$matchFixture_latestStat = Match_fixture_lapse::where('match_fixture_id', $this->fixture_id)->orderBy('id', 'desc')->first();

			if ($matchFixture_latestStat->lapse_type == 9) {
				// Record lapse time for second half pause
				$match_fixture_lapse = new Match_fixture_lapse();
				$match_fixture_lapse->match_fixture_id = $this->match_fixture->id;
				$match_fixture_lapse->lapse_type = 8;
				$match_fixture_lapse->lapse_time = now();
				$match_fixture_lapse->save();

				// Fetch team player information
				$team_player = Competition_attendee::where('Competition_id', $this->match_fixture->competition_id)
					->where('team_id', $this->match_fixture->teamOne_id)
					->first();

				// Fetch the latest pause time for second half
				$pause_second_half = Match_fixture_lapse::where('match_fixture_id', $this->match_fixture->id)
					->where('lapse_type', 9)
					->orderBy('id', 'desc')
					->latest()
					->first();

				// Calculate lapse time difference
				$last_dateTimeObject1 = date_create($pause_second_half->lapse_time);
				$last_dateTimeObject2 = date_create($match_fixture_lapse->lapse_time);
				$difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
				$lapse_diff = $difference->format('%H:%I:%S');
				$stat_time_record = $difference->format('%H:%I:%S');

				// Update lapse time difference
				$update_lapse = Match_fixture_lapse::find($match_fixture_lapse->id);
				$update_lapse->lapse_diff = $lapse_diff;
				$update_lapse->save();

				// Record match fixture stat for the second half
				$match_fixture_stat = new Match_fixture_stat();
				$match_fixture_stat->match_fixture_id = $this->match_fixture->id;
				$match_fixture_stat->competition_id = $this->match_fixture->competition_id;
				$match_fixture_stat->team_id = $this->match_fixture->teamOne_id;
				$match_fixture_stat->stat_type = 2;
				$match_fixture_stat->player_id = $team_player->attendee_id;
				$match_fixture_stat->sport_stats_id = 19;
				$match_fixture_stat->stat_time = now();
				$match_fixture_stat->half_type = 2;
				$match_fixture_stat->save();

				// Update sport detail for the second half
				$latest_fixture_stat = Match_fixture_stat::select('stat_time')
					->where('match_fixture_id', $this->match_fixture->id)
					->where('sport_stats_id', 14)
					->latest()
					->first();

				$last_dateTimeObject1 = date_create($latest_fixture_stat->stat_time);
				$last_dateTimeObject2 = date_create($match_fixture_stat->stat_time);
				$difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
				$stat_diff = $difference->format('%H:%I:%S');
				$stat_time_record = $difference->format('%H:%I:%S');

				// Update stat information
				$update_stat = Match_fixture_stat::find($match_fixture_stat->id);
				$update_stat->stat_diff = $stat_diff;
				$update_stat->stat_time_record = $stat_time_record;
				$update_stat->save();

				// Check if the second half timer has exceeded the specified time
				if ($secondHalf_timer_calTime > $comp_halfTime_strTotime) {
					$this->timer_content_second_half = "COMPLETED";
				}
			}
		}

		$this->disable_secondHalf = false;
	}

	public function openmodal($team_id)
	{
		$this->modal_teamId = $team_id;

		// Fetch team information
		$team_info = Team::select('id', 'name', 'team_logo')->find($team_id);
		$this->modal_teamlogo = $team_info->team_logo;
		$this->modal_teamName = $team_info->name;

		// Define position IDs
		$defender_position_ids = SportGroundPosition::where('ground_coordinates', 2)->pluck('id');
		$defensive_ids = SportGroundPosition::where('ground_coordinates', 3)->pluck('id');
		$medfielder_ids = SportGroundPosition::where('ground_coordinates', 4)->pluck('id');
		$attacking_ids = SportGroundPosition::where('ground_coordinates', 5)->pluck('id');
		$forward_ids = SportGroundPosition::where('ground_coordinates', 6)->pluck('id');

		// Count players in each position
		$this->modal_defendercount = Fixture_squad::where('match_fixture_id', $this->match_fixture->id)
			->where('team_id', $team_id)
			->whereIn('sport_ground_positions_id', $defender_position_ids)
			->where('is_active', 1)
			->count();

		$this->modal_defensivecount = Fixture_squad::where('match_fixture_id', $this->match_fixture->id)
			->where('team_id', $team_id)
			->whereIn('sport_ground_positions_id', $defensive_ids)
			->where('is_active', 1)
			->count();

		$this->modal_medfieldercount = Fixture_squad::where('match_fixture_id', $this->match_fixture->id)
			->where('team_id', $team_id)
			->whereIn('sport_ground_positions_id', $medfielder_ids)
			->where('is_active', 1)
			->count();

		$this->modal_attackingcount = Fixture_squad::where('match_fixture_id', $this->match_fixture->id)
			->where('team_id', $team_id)
			->whereIn('sport_ground_positions_id', $attacking_ids)
			->where('is_active', 1)
			->count();

		$this->modal_forwardcount = Fixture_squad::where('match_fixture_id', $this->match_fixture->id)
			->where('team_id', $team_id)
			->whereIn('sport_ground_positions_id', $forward_ids)
			->where('is_active', 1)
			->count();

		// Fetch substitute players
		$lineup_players = Fixture_squad::where('match_fixture_id', $this->match_fixture->id)
			->where('team_id', $team_id)
			->where('is_active', 1)
			->pluck('player_id');

		$this->subtitute_players = Competition_attendee::where('Competition_id', $this->match_fixture->competition_id)
			->where('team_id', $team_id)
			->whereNotIn('attendee_id', $lineup_players)
			->with('player:id,first_name,last_name')
			->get();

		$this->dispatch('Openpublic_squadModal');
	}

	public function close_modal()
	{
		$this->dispatch('Closepublic_squadModal');
	}
	public function stat_fixture_alert()
	{
		$this->dispatch('swal:modal', [

			'message' => 'Only Comp admin can start match.',

		]);
	}
}
