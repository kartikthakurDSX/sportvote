<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Match_fixture;
use App\Models\Fixture_squad;
use App\Models\Match_fixture_stat;
use App\Models\Sport_stat;
use App\Models\User_fav_follow;
use App\Models\Notification;
use App\Models\Competition;
use App\Models\Comp_member;
use App\Models\Team_member;
use App\Models\Team;
use App\Models\Competition_attendee;
use App\Models\StatTrack;
use App\Models\User;
use App\Models\Match_fixture_lapse;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class MatchfixtureSubmitDetailStat extends Component
{
    public $match_fixture;
    public $match_fixture_id;
    public $player = [];
    public $team_id = "";
    public $player_id = "";
    public $first_half_fixture_player_stat = [];
    public $first_red_card_player;
    public $first_yellow_card_player;
    public $second_half_fixture_player_stat = [];
    public $second_red_card_player;
    public $second_yellow_card_player;
    public $match_fixture_stats;
    public $player_stat_input = [];
    public $player_stat_input2 = [];
    public $save_player_stat_input;
    public $save_player_stat_input2;
    public $notification_users = [];
    public $team_image;
    public $player_profile_pic;
    public $tie_winner_teamId;
    public $onclick = false;
    public $player_pic;
    public $player_stat_min;
    public $player_stat_sec;
    public $add_stat = [];
    public $second_half_add_stat = [];
    public $comp_id;
    public $span_class = [];
    public $match_half_time;
    public $f_lineup_player_id;
    public $listeners = ['refreshData'];


    public function refresh()
    {
        $this->dispatch('$refresh');
    }
    public function refreshData()
    {
        // Your logic to refresh data goes here
        // For example, you can fetch updated data and update public properties used in the component
        $this->dispatch('refreshDataComplete'); // Optional: Emit an event to signal that data refresh is complete
    }

    public function mount($match_fixture)
    {
        $this->match_fixture_id = $match_fixture;
        $m_f = Match_fixture::find($this->match_fixture_id->id);
        $this->team_image = Team::find($m_f->teamOne_id);
        $this->comp_id = $m_f->competition_id;
        $comp_data = Competition::find($this->comp_id);
        $this->match_half_time = $comp_data->competition_half_time;
    }
    public function render()
    {
        $match_fixture = Match_fixture::with('teamOne:id,name,team_logo', 'teamTwo:id,name,team_logo', 'competition')->find($this->match_fixture->id);
        $fixture_lapse_type = Match_fixture_lapse::where('match_fixture_id', $this->match_fixture_id->id)->orderBy('id', 'desc')->latest()->first();

        if ($match_fixture->competition->report_type == 1) {
            $stat = Sport_stat::whereIN('stat_type_id', [0, 1])->whereIn('stat_type', [0, 1])->where('is_active', 1)->get();
        } else {
            $detailed_stats = StatTrack::select('Stat_ids')->where('tracking_type', 1)->where('tracking_for', $match_fixture->competition->id)->where('is_active', 1)->latest()->first();
            $stats_array = array();
            if (!empty($detailed_stats)) {
                $stats_array = explode(',', $detailed_stats->Stat_ids);
            }

            $stat = Sport_stat::whereIn('id', $stats_array)->where('is_active', 1)->get();
        }

        if (!($this->team_id)) {
            // $this->player = Fixture_squad::where('match_fixture_id',$match_fixture->id)->where('team_id',$match_fixture->teamOne_id)->with('player')->get();

            $this->player = Competition_attendee::where('Competition_id', $match_fixture->competition_id)->where('team_id', $match_fixture->teamOne_id)->with('player')->get();

            // $first_player = Fixture_squad::where('match_fixture_id',$match_fixture->id)->where('team_id',$match_fixture->teamOne_id)->pluck('player_id')->first();

            $first_player =
            Competition_attendee::where('Competition_id', $match_fixture->competition_id)->where('team_id', $match_fixture->teamOne_id)->pluck('attendee_id')->first();
            if (!empty($first_player)) {
                $first_player_id = $first_player;
            } else {
                $first_attendee = Competition_attendee::where('Competition_id', $match_fixture->competition_id)->where('team_id', $match_fixture->teamOne_id)->pluck('attendee_id')->first();
                $first_player_id = $first_attendee;
            }
        }
        if (!($this->player_id)) {
            // $player_id = Fixture_squad::where('match_fixture_id',$match_fixture->id)->where('team_id',$match_fixture->teamOne_id)->value('player_id');


            $player_id = Competition_attendee::where('Competition_id', $match_fixture->competition_id)->where('team_id', $match_fixture->teamOne_id)
            ->value('attendee_id');

            $this->first_half_fixture_player_stat = Match_fixture_stat::where('match_fixture_id', $this->match_fixture_id->id)->where('team_id', $match_fixture->teamOne_id)->where('player_id', $player_id)->where('half_type', 1)->whereIn('stat_type', [0, 1])->get();

            $this->second_half_fixture_player_stat = Match_fixture_stat::where('match_fixture_id', $this->match_fixture_id->id)->where('team_id', $match_fixture->teamOne_id)->where('player_id', $player_id)->where('half_type', 2)->whereIn('stat_type', [0, 1])->get();

            $this->first_red_card_player = Match_fixture_stat::where('match_fixture_id', $this->match_fixture_id->id)->where('player_id', $player_id)->where('sport_stats_id', 3)->count();

            $this->first_yellow_card_player = Match_fixture_stat::where('match_fixture_id', $this->match_fixture_id->id)->where('player_id', $player_id)->where('sport_stats_id', 2)->count();

            $this->player_profile_pic = User::select('profile_pic')->find($first_player_id);
        } else {
            $this->player_profile_pic = User::select('profile_pic')->find($this->player_id);
        }
        if ($this->team_id) {
            $this->match_fixture_stats = Match_fixture_stat::where('match_fixture_id', $this->match_fixture_id->id)->where('team_id', $this->team_id)->get();
            $second_half_stats = Match_fixture_stat::where('match_fixture_id', $this->match_fixture_id->id)->where('sport_stats_id', 14)->count();
            $lineup_team_id = $this->team_id;
        } else {
            $this->match_fixture_stats = Match_fixture_stat::where('match_fixture_id', $this->match_fixture_id->id)->where('team_id', $match_fixture->teamOne_id)->get();

            $second_half_stats = Match_fixture_stat::where('match_fixture_id', $this->match_fixture_id->id)->where('team_id', $match_fixture->teamOne_id)->where('sport_stats_id', 14)->count();

            $lineup_team_id = $match_fixture->teamOne_id;
        }
        $comp_admins = Comp_member::where('comp_id', $match_fixture->competition_id)->where('member_position_id', 7)->where('invitation_status', 1)->where('is_active', 1)->pluck('member_id');
        $admins = $comp_admins->toArray();

        if (!($this->player_id)) {
            // $lineup_player_id = Fixture_squad::where('match_fixture_id',$match_fixture->id)->where('team_id',$lineup_team_id)->pluck('player_id')->first();

            $lineup_player_id = Competition_attendee::where('Competition_id', $match_fixture->competition_id)->where('team_id', $lineup_team_id)->pluck('attendee_id')->first();
        } else {
            $lineup_player_id = $this->player_id;
        }
        //dd($lineup_player_id);
        $this->f_lineup_player_id = $lineup_player_id;
        $match_fix_stats = Match_fixture_stat::where('match_fixture_id', $this->match_fixture_id->id)->get();

        $comps = Competition::select('competition_half_time')->where('id', $match_fixture->competition_id)->latest()->first();
        dd($match_fixture);
        return view('livewire.matchfixture-submit-detail-stat', compact('fixture_lapse_type', 'match_fixture', 'stat', 'admins', 'match_fix_stats', 'second_half_stats', 'lineup_player_id', 'comps'));
    }


    public function finish_match($id)
    {
        $match_fixture = Match_fixture::find($id);
        //next fixture according to winner team and update finish datetime in match_fixture
        $teamOne_stats = Match_fixture_stat::where('match_fixture_id', $id)->where('team_id', $match_fixture->teamOne_id)->get();
        $teamTwo_stats = Match_fixture_stat::where('match_fixture_id', $id)->where('team_id', $match_fixture->teamTwo_id)->get();

        // get all followers of both teams and competition.
        $competition = Competition::select('user_id', 'team_number', 'comp_type_id')->find($match_fixture->competition_id);
        $teamOne = Team::find($match_fixture->teamOne_id);
        $teamTwo = Team::find($match_fixture->teamTwo_id);
        $teamOnemember = Team_member::where('team_id', $teamOne->id)->where('invitation_status', 1)->pluck('member_id');
        $teamTwomember = Team_member::where('team_id', $teamTwo->id)->where('invitation_status', 1)->pluck('member_id');
        $teamOne_Follower = User_fav_follow::where('is_type', 1)->where('type_id', $match_fixture->teamOne_id)->where('Is_follow', 1)->Orwhere('Is_fav', 1)->pluck('user_id');
        $teamTwo_Follower = User_fav_follow::where('is_type', 1)->where('type_id', $match_fixture->teamTwo_id)->where('Is_follow', 1)->Orwhere('Is_fav', 1)->pluck('user_id');
        $comp_follower = User_fav_follow::where('is_type', 2)->where('type_id', $match_fixture->competition_id)->where('Is_follow', 1)->Orwhere('Is_fav', 1)->pluck('user_id');
        $user = array_merge($teamOnemember->toArray(), $teamTwomember->toArray(), $teamOne_Follower->toArray(), $teamTwo_Follower->toArray(), $comp_follower->toArray());
        $allusersunique = array_values(array_unique($user));

        // get both team goals
        $teamOne_goals = 0;
        $teamTwo_goals = 0;
        foreach ($teamOne_stats as $team1_stat) {
            if ($team1_stat->sport_stats_id == 1 || $team1_stat->sport_stats_id == 54) {
                $teamOne_goals++;
            }
        }
        foreach ($teamTwo_stats as $team2_stat) {
            if ($team2_stat->sport_stats_id == 1 || $team2_stat->sport_stats_id == 54) {
                $teamTwo_goals++;
            }
        }

        // team drwa
        if ($teamTwo_goals ==  $teamOne_goals) {
            if ($competition->comp_type_id == 2) {
                $this->dispatch('openselectwinner');
            } else {
                // fixture_type 1 draw
                $match_fixture->finishdate_time = now();
                $match_fixture->finished_by = Auth::user()->id;
                $match_fixture->fixture_type = 1;
                $match_fixture->save();

                $match_fixture_lapse = new Match_fixture_lapse();
                $match_fixture_lapse->match_fixture_id = $match_fixture->id;
                $match_fixture_lapse->lapse_type = 7;
                $match_fixture_lapse->lapse_time = now();
                $match_fixture_lapse->save();
                // Send notification to follower/fans

                for ($i = 0; $i < Count($allusersunique); $i++) {
                    if ($allusersunique[$i] != Auth::user()->id) {
                        $notification = new Notification();
                        $notification->notify_module_id = 8;
                        $notification->type_id = $id;
                        $notification->sender_id = $competition->user_id;
                        $notification->reciver_id = $allusersunique[$i];
                        $notification->save();
                    }
                }
                return redirect(route('match-fixture.show', $this->match_fixture_id->id));
            }
        } else {
            if ($teamOne_goals > $teamTwo_goals) {
                $winner_team = $match_fixture->teamOne_id;
            } else {
                $winner_team = $match_fixture->teamTwo_id;
            }


            $match_fixture->finishdate_time = now();
            $match_fixture->fixture_type = 2;
            $match_fixture->finished_by = Auth::user()->id;
            $match_fixture->save();

            $match_fixture_lapse = new Match_fixture_lapse();
            $match_fixture_lapse->match_fixture_id = $match_fixture->id;
            $match_fixture_lapse->lapse_type = 7;
            $match_fixture_lapse->lapse_time = now();
            $match_fixture_lapse->save();
            // Send notification to follower/fans



            for ($i = 0; $i < Count($allusersunique); $i++) {
                if ($allusersunique[$i] != Auth::user()->id) {
                    $notification = new Notification();
                    $notification->notify_module_id = 8;
                    $notification->type_id = $id;
                    $notification->sender_id = $competition->user_id;
                    $notification->reciver_id = $allusersunique[$i];
                    $notification->save();
                }
            }
            // fixture_type 2 for winner or lost
            $match_fixture_winner = Match_fixture::find($id);
            $match_fixture_winner->winner_team_id = $winner_team;
            $match_fixture->fixture_type = 2;
            $match_fixture_winner->save();
            return redirect(route('match-fixture.show', $this->match_fixture_id->id));
        }
    }
    public function match_tie_winner()
    {
        // dd($this->tie_winner_teamId);
        if ($this->tie_winner_teamId) {
            $match_id = $this->match_fixture_id->id;
            $match_fixture = Match_fixture::find($match_id);
            $match_fixture->finishdate_time = now();
            $match_fixture->fixture_type = 3;
            $match_fixture->finished_by = Auth::user()->id;
            $match_fixture->save();

            $match_fixture_lapse = new Match_fixture_lapse();
            $match_fixture_lapse->match_fixture_id = $match_fixture->id;
            $match_fixture_lapse->lapse_type = 7;
            $match_fixture_lapse->lapse_time = now();
            $match_fixture_lapse->save();
            // Send notification to follower/fans

            $competition = Competition::select('user_id', 'team_number')->find($match_fixture->competition_id);
            $teamOne = Team::find($match_fixture->teamOne_id);
            $teamTwo = Team::find($match_fixture->teamTwo_id);
            $teamOnemember = Team_member::where('team_id', $teamOne->id)->where('invitation_status', 1)->pluck('member_id');
            $teamTwomember = Team_member::where('team_id', $teamTwo->id)->where('invitation_status', 1)->pluck('member_id');
            $teamOne_Follower = User_fav_follow::where('is_type', 1)->where('type_id', $match_fixture->teamOne_id)->where('Is_follow', 1)->Orwhere('Is_fav', 1)->pluck('user_id');
            $teamTwo_Follower = User_fav_follow::where('is_type', 1)->where('type_id', $match_fixture->teamTwo_id)->where('Is_follow', 1)->Orwhere('Is_fav', 1)->pluck('user_id');
            $comp_follower = User_fav_follow::where('is_type', 2)->where('type_id', $match_fixture->competition_id)->where('Is_follow', 1)->Orwhere('Is_fav', 1)->pluck('user_id');

            $user = array_merge($teamOnemember->toArray(), $teamTwomember->toArray(), $teamOne_Follower->toArray(), $teamTwo_Follower->toArray(), $comp_follower->toArray());
            $allusersunique = array_values(array_unique($user));

            for ($i = 0; $i < Count($allusersunique); $i++) {
                if ($allusersunique[$i] != Auth::user()->id) {
                    $notification = new Notification();
                    $notification->notify_module_id = 8;
                    $notification->type_id = $this->match_fixture_id->id;
                    $notification->sender_id = $competition->user_id;
                    $notification->reciver_id = $allusersunique[$i];
                    $notification->save();
                }
            }
            $match_fixture_winner = Match_fixture::find($this->match_fixture_id->id);
            $match_fixture_winner->winner_team_id = $this->tie_winner_teamId;
            $match_fixture_winner->save();
            $this->dispatch('closeselectwinner');
            return redirect(route('match-fixture.show', $this->match_fixture_id->id));
        } else {
            $this->dispatch('swal:modal', [
                'message' => 'Select Winner Team',
            ]);
        }
    }
    public function closeSelect_winner()
    {
        $this->dispatch('closeselectwinner');
    }
    public function select_team()
    {
        if ($this->team_id) {
            // $this->player = Fixture_squad::where('match_fixture_id',$this->match_fixture_id->id)->where('team_id',$this->team_id)->with('player')->get();
            $this->player = Competition_attendee::where('Competition_id', $this->match_fixture_id->competition_id)->where('team_id', $this->team_id)->with('player')->get();
            $this->team_image = Team::find($this->team_id);
            // first palyer stat
            // $first_player_id = Fixture_squad::where('match_fixture_id',$this->match_fixture_id->id)->where('team_id',$this->team_id)->with('player')->pluck('player_id')->first();
            $first_player_id = Competition_attendee::where('Competition_id', $this->match_fixture_id->competition_id)->where('team_id', $this->team_id)->with('player')->pluck('attendee_id')->first();
            $this->player_id = $first_player_id;
            $this->first_half_fixture_player_stat = Match_fixture_stat::where('match_fixture_id', $this->match_fixture_id->id)->where('team_id', $this->team_id)->where('player_id', $first_player_id)->where('half_type', 1)->get();
            $this->first_red_card_player = Match_fixture_stat::where('match_fixture_id', $this->match_fixture_id->id)->where('player_id', $first_player_id)->where('sport_stats_id', 3)->count();
            $this->first_yellow_card_player = Match_fixture_stat::where('match_fixture_id', $this->match_fixture_id->id)->where('player_id', $first_player_id)->where('sport_stats_id', 2)->count();

            $this->second_half_fixture_player_stat = Match_fixture_stat::where('match_fixture_id', $this->match_fixture_id->id)->where('team_id', $this->team_id)->where('player_id', $first_player_id)->where('half_type', 2)->get();
        }

        // dd($this->player_id);
    }
    public function select_player()
    {
        $this->onclick = true;
        $this->player_pic = User::select('profile_pic')->find($this->player_id);
        if ($this->team_id) {
            $this->first_half_fixture_player_stat = Match_fixture_stat::where('match_fixture_id', $this->match_fixture_id->id)->where('team_id', $this->team_id)->where('player_id', $this->player_id)->where('half_type', 1)->get();

            $this->second_half_fixture_player_stat = Match_fixture_stat::where('match_fixture_id', $this->match_fixture_id->id)->where('team_id', $this->team_id)->where('player_id', $this->player_id)->where('half_type', 2)->get();
        } else {
            $this->first_half_fixture_player_stat = Match_fixture_stat::where('match_fixture_id', $this->match_fixture_id->id)->where('team_id', $this->match_fixture_id->teamOne_id)->where('player_id', $this->player_id)->where('half_type', 1)->get();

            $this->second_half_fixture_player_stat = Match_fixture_stat::where('match_fixture_id', $this->match_fixture_id->id)->where('team_id', $this->match_fixture_id->teamOne_id)->where('player_id', $this->player_id)->where('half_type', 2)->get();
        }
        $this->player_profile_pic = User::select('profile_pic')->find($this->player_id);
        $this->first_red_card_player = Match_fixture_stat::where('match_fixture_id', $this->match_fixture_id->id)->where('player_id', $this->player_id)->where('sport_stats_id', 3)->count();
        $this->first_yellow_card_player = Match_fixture_stat::where('match_fixture_id', $this->match_fixture_id->id)->where('player_id', $this->player_id)->where('sport_stats_id', 2)->count();


        // dd($this->fixture_player_stat);
    }

    public function add_first_half_stat($i)
    {dd($this->match_fixture_id->id);
        $m_f = Match_fixture::find($this->match_fixture_id->id);
        if (!($this->team_id)) {
            $team_id = $m_f->teamOne_id;
        } else {
            $team_id = $this->team_id;
        }
        if (!($this->player_id)) {
            $first_player = Fixture_squad::where('match_fixture_id', $m_f->id)->where('team_id', $team_id)->pluck('player_id')->first();
            $player_id = $first_player;
        } else {
            $player_id = $this->player_id;
        }

        $this->add_stat[] = '00:00:' . $player_id . ':' . $team_id . ':' . $i;
    }
    public function add_second_half_stat($i)
    {
        $m_f = Match_fixture::find($this->match_fixture_id->id);
        if (!($this->team_id)) {
            $team_id = $m_f->teamOne_id;
        } else {
            $team_id = $this->team_id;
        }
        if (!($this->player_id)) {
            $first_player = Fixture_squad::where('match_fixture_id', $m_f->id)->where('team_id', $team_id)->pluck('player_id')->first();
            $player_id = $first_player;
        } else {
            $player_id = $this->player_id;
        }

        $this->second_half_add_stat[] = '00:00:' . $player_id . ':' . $team_id . ':' . $i;
        //dd($this->second_half_add_stat);
    }

    public function update_player_stat()
    {
        $stat_error = 0;

        if ($this->save_player_stat_input != null && $this->save_player_stat_input2 == null) {
            foreach ($this->save_player_stat_input as $fix_id => $inputs) {
                $get_fixture_stat_val = Match_fixture_stat::select('stat_time_record', 'competition_id')->find($fix_id);
                $comp = Competition::select('competition_half_time')->where('id', $get_fixture_stat_val->competition_id)->latest()->first();

                $explode_get_fixture_stat_val = explode(':', $get_fixture_stat_val->stat_time_record);
                $get_sec = $explode_get_fixture_stat_val[2];
                $min = str_pad($inputs, 2, 0, STR_PAD_LEFT);
                $record_stat = '00:' . $min . ':' . $get_sec;
                $update_fixture = Match_fixture_stat::find($fix_id);
                $update_fixture->stat_time_record = $record_stat;
                $update_fixture->stat_diff = '00:00';
                $t_sec = $min * 60 + $get_sec;

                $find_stat_timeing = Match_fixture_stat::where('match_fixture_id', $fix_id)->where('competition_id', $get_fixture_stat_val->competition_id)->where('stat_time_record', $record_stat)->count();

                if ($comp->competition_half_time * 60 >= $t_sec) {
                    if ($t_sec > 0) {
                        if ($find_stat_timeing > 0) {
                            $stat_error++;
                            $message = "You can not add stat at same time";
                            $this->dispatch('swal:modal', [
                                'message' => $message,
                            ]);
                        } else {
                            $update_fixture->save();
                        }
                    } else {
                        $stat_error++;
                        $this->dispatch('swal:modal', [
                            'message' => 'Value cannot be Negative ',
                        ]);
                    }
                } else {
                    $stat_error++;
                    $this->dispatch('swal:modal', [
                        'message' => 'You can not add more than Match time per half ',
                    ]);
                }
            }
        } elseif ($this->save_player_stat_input2 != null && $this->save_player_stat_input == null) {
            foreach ($this->save_player_stat_input2 as $fix_id => $inputs) {
                $get_fixture_stat_val = Match_fixture_stat::select('stat_time_record', 'competition_id')->find($fix_id);
                $comp = Competition::select('competition_half_time')->where('id', $get_fixture_stat_val->competition_id)->latest()->first();
                $explode_get_fixture_stat_val = explode(':', $get_fixture_stat_val->stat_time_record);
                $get_min = $explode_get_fixture_stat_val[1];
                $sec = str_pad($inputs, 2, 0, STR_PAD_LEFT);
                $record_stat = '00:' . $get_min . ':' . $sec;
                $update_fixture = Match_fixture_stat::find($fix_id);
                $update_fixture->stat_time_record = $record_stat;
                $update_fixture->stat_diff = '00:00';

                $find_stat_timeings = Match_fixture_stat::where('match_fixture_id', $fix_id)->where('competition_id', $get_fixture_stat_val->competition_id)->where('stat_time_record', '=', $record_stat)->count();

                $t_sec = $get_min * 60 + $sec;

                if ($comp->competition_half_time * 60 >= $t_sec) {
                    if ($t_sec > 0) {
                        if ($find_stat_timeings > 0) {
                            $stat_error++;
                            $message = "You can not add stat at same time";
                            $this->dispatch('swal:modal', [
                                'message' => $message,
                            ]);
                        } else {
                            $update_fixture->save();
                        }
                    } else {
                        $stat_error++;
                        $this->dispatch('swal:modal', [

                            'message' => 'Value cannot be Negative ',

                        ]);
                    }
                } else {
                    $stat_error++;
                    $this->dispatch('swal:modal', [

                        'message' => 'You can not add more than Match time per half ',

                    ]);
                }
            }
        } else {
            if ($this->save_player_stat_input != null && $this->save_player_stat_input2 != null) {
                foreach ($this->save_player_stat_input as $fix_id => $inputs) {
                    $get_fixture_stat_val = Match_fixture_stat::select('stat_time_record', 'competition_id')->find($fix_id);
                    $comp = Competition::select('competition_half_time')->where('id', $get_fixture_stat_val->competition_id)->latest()->first();
                    $min = str_pad($inputs, 2, 0, STR_PAD_LEFT);
                    $get_sec = str_pad($this->save_player_stat_input2[$fix_id], 2, 0, STR_PAD_LEFT);
                    $record_stat = '00:' . $min . ':' . $get_sec;
                    $update_fixture = Match_fixture_stat::find($fix_id);
                    $update_fixture->stat_time_record = $record_stat;
                    $update_fixture->stat_diff = '00:00';
                    $t_sec = $min * 60 + $get_sec;

                    $stattime = '00:' . $min . ':' . str_pad($this->save_player_stat_input2[$fix_id], 2, 0, STR_PAD_LEFT);
                    $find_stat_timeing = Match_fixture_stat::where('match_fixture_id', $fix_id)->where('competition_id', $get_fixture_stat_val->competition_id)->where('stat_time_record', $stattime)->count();
                    if ($comp->competition_half_time * 60 >= $t_sec) {
                        if ($t_sec > 0) {
                            if ($find_stat_timeing > 0) {
                                $stat_error++;
                                $message = "You can not add stat at same time";
                                $this->dispatch('swal:modal', [
                                    'message' => $message,
                                ]);
                            } else {
                                $update_fixture->save();
                            }
                        } else {
                            $stat_error++;
                            $this->dispatch('swal:modal', [
                                'message' => 'Value cannot be Negative ',
                            ]);
                        }
                    } else {
                        $stat_error++;
                        $this->dispatch('swal:modal', [
                            'message' => 'You can not add more than Match time per half ',
                        ]);
                    }
                }
            }
        }

        $player_stats = array($this->player_stat_input, $this->player_stat_input2);
        $mins = array();
        $sec = array();
        $data = array();
        foreach ($player_stats as $input_type => $input_data) {
            foreach ($input_data as $team_id => $team_data) {
                foreach ($team_data as $playerdata) {
                    foreach ($playerdata as $half_type => $halfData) {
                        foreach ($halfData as $player_id => $playerData1) {
                            foreach ($playerData1 as $stat_id => $statData) {
                                foreach ($statData as $input_id => $inputdata) {
                                    if ($input_type == 0) {
                                        $mins[] = $player_id . ',' . $stat_id . ',' . $inputdata . ',' . $input_id . ',' . $team_id . ',' . $half_type;
                                    } else {
                                        $sec[] = $player_id . ',' . $stat_id . ',' . $inputdata . ',' . $input_id . ',' . $team_id . ',' . $half_type;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if (count($mins) > count($sec)) {
            $loop = count($mins);
        } else {
            $loop = count($sec);
        }

        $statMS = array();
        $statM = array();
        $statS = array();

        for ($i = 0; $i < $loop; $i++) {
            if (array_key_exists($i, $mins)) {
                $explode_min = explode(",", $mins[$i]);
                $min_player_id = $explode_min[0];
                $min_stat_id = $explode_min[1];
                $minutes = $explode_min[2];
                $min_input_id = $explode_min[3];
                $min_team_id = $explode_min[4];
                $min_half_type = $explode_min[5];
            } else {
                $min_player_id = "";
                $min_stat_id = "";
                $minutes = "";
                $min_input_id = "";
                $min_team_id = "";
                $min_half_type = "";
            }
            if (array_key_exists($i, $sec)) {
                $explode_sec = explode(",", $sec[$i]);
                $sec_player_id = $explode_sec[0];
                $sec_stat_id = $explode_sec[1];
                $seconds = $explode_sec[2];
                $sec_input_id = $explode_sec[3];
                $sec_team_id = $explode_sec[4];
                $sec_half_type = $explode_sec[5];
            } else {
                $sec_player_id = "";
                $sec_stat_id = "";
                $seconds = "";
                $sec_input_id = "";
                $sec_team_id = "";
                $sec_half_type = "";
            }

            if ($min_input_id == $sec_input_id) {
                $m = str_pad($minutes, 2, 0, STR_PAD_LEFT);
                $s = str_pad($seconds, 2, 0, STR_PAD_LEFT);
                $record_time = $m . ':' . $s;
                $statMS[] = $min_player_id . ',' . $min_stat_id . ',' . $record_time . ',' . $min_half_type . ',' . $min_team_id;
            } else {
                if (empty($min_team_id)) {
                    $s = str_pad($seconds, 2, 0, STR_PAD_LEFT);
                    $record_time = '00:00:' . $s;
                    $statS[] = $sec_player_id . ',' . $sec_stat_id . ',' . $record_time . ',' . $sec_half_type . ',' . $sec_team_id;
                } elseif (empty($sec_team_id)) {
                    $m = str_pad($minutes, 2, 0, STR_PAD_LEFT);
                    $record_time = '00:' . $m . ':00';
                    $statM[] = $min_player_id . ',' . $min_stat_id . ',' . $record_time . ',' . $min_half_type . ',' . $min_team_id;
                }
            }
        }

        $final_data = array_merge($statMS, $statM, $statS);

        for ($a = 0; $a < count($final_data); $a++) {
            $explode_data = explode(",", $final_data[$a]);
            $playerId = $explode_data[0];
            $statId = $explode_data[1];
            $record_time = $explode_data[2];
            $half_type = $explode_data[3];
            $team_id = $explode_data[4];
            $match_fixture_id = $this->match_fixture_id->id;
            $competition_id = $this->comp_id;

            $match_fixture_stat = new Match_fixture_stat();
            $match_fixture_stat->match_fixture_id = $match_fixture_id;
            $match_fixture_stat->competition_id = $competition_id;
            $match_fixture_stat->team_id = $team_id;
            $match_fixture_stat->stat_type = 1;
            $match_fixture_stat->player_id = $playerId;
            $match_fixture_stat->sport_stats_id = $statId;
            $match_fixture_stat->stat_time = now();
            $match_fixture_stat->half_type = $half_type;
            $match_fixture_stat->stat_diff = '00:00';
            $time = explode(":", $record_time);
            $time_array_count = count($time);
            if ($time_array_count == 2) {
                $min = $time[0];
                $sec = $time[1];
                $match_fixture_stat->stat_time_record = '00:' . $record_time;
            }
            if ($time_array_count == 3) {
                $min = $time[1];
                $sec = $time[2];
                $match_fixture_stat->stat_time_record = $record_time;
            }
            $match_fixture_stat->is_active = 1;

            $stattimeing = $min * 60 + $sec;

            $find_stat_timeing = Match_fixture_stat::where('match_fixture_id', $match_fixture_id)->where('competition_id', $competition_id)->where('stat_time_record', $record_time)->count();

            $stat_withMaxTime = Match_fixture_stat::where('match_fixture_id', $match_fixture_id)->where('stat_type', 1)->where('player_id', $playerId)->orderby('stat_time_record', 'DESC')->latest()->first();
            if ($stat_withMaxTime) {
                $explode_stat_withMaxTime = explode(':', $stat_withMaxTime->stat_time_record);
                $convert_stat_withMaxTime = $explode_stat_withMaxTime[1] * 60 + $explode_stat_withMaxTime[2];
            } else {
                $convert_stat_withMaxTime = "0";
            }

            $red_card_player = Match_fixture_stat::where('match_fixture_id', $match_fixture_id)->where('player_id', $playerId)->where('sport_stats_id', 3)->count();
            $yellow_card_player = Match_fixture_stat::where('match_fixture_id', $match_fixture_id)->where('player_id', $playerId)->where('sport_stats_id', 2)->count();

            if ($red_card_player >= 1) {
                $stat_error++;
                $message = "This Player have one Red card";
                $this->dispatch('swal:modal', [
                    'message' => $message,
                ]);
            } elseif ($yellow_card_player >= 2) {
                $stat_error++;
                $message = "This Player have two yellow cards";
                $this->dispatch('swal:modal', ['message' => $message]);
            } elseif ($find_stat_timeing > 0) {
                $stat_error++;
                $message = "You can not add stat at same time.";
                $this->dispatch('swal:modal', [
                    'message' => $message,
                ]);
            } elseif ($statId == 3 && $stattimeing < $convert_stat_withMaxTime) {
                $stat_error++;
                $message = "You can not add red card.";
                $this->dispatch('swal:modal', [
                    'message' => $message,
                ]);
            } elseif ($statId == "2" && $stattimeing < $convert_stat_withMaxTime && $yellow_card_player == 1) {
                $stat_error++;
                $message = "You can not add yellow card.";
                $this->dispatch('swal:modal', [
                    'message' => $message,
                ]);
            } else {
                $t_sec = $min * 60 + $sec;

                if ($this->match_half_time * 60 >= $t_sec) {
                    if ($t_sec > 0) {
                        $match_fixture_stat->save();
                    } else {
                        $stat_error++;
                        $this->dispatch('swal:modal', [
                            'message' => 'Value cannot be Negative ',
                        ]);
                    }
                } else {
                    $stat_error++;
                    $this->dispatch('swal:modal', [
                        'message' => 'You can not add more than Match time per half',
                    ]);
                }
            }
        }

        if ($stat_error == 0) {
            $this->dispatch('closeModal');
            return redirect(route('match-fixture.show', $this->match_fixture_id->id));
        }
    }

    public function open_recordstatsModal()
    {
        $this->dispatch('OpenModal');
    }

    public function delete_stat($id)
    {
        // dd('test');
        // Match_fixture_stat::find($id)->delete();
        $stat = Match_fixture_stat::find($id);

        if ($stat) {
            $stat->delete();
            return "Stat deleted successfully";
        } else {
            return "Stat not found";
        }
    }
    public function reset_match()
    {
        $match_fixture = Match_fixture::find($this->match_fixture_id->id);
        // Send notification to follower/fans

        $competition = Competition::find($match_fixture->competition->id);
        $teamOne = Team::find($match_fixture->teamOne_id);
        $teamTwo = Team::find($match_fixture->teamTwo_id);
        $teamOnemember = Team_member::where('team_id', $teamOne->id)->where('invitation_status', 1)->pluck('member_id');
        $teamTwomember = Team_member::where('team_id', $teamTwo->id)->where('invitation_status', 1)->pluck('member_id');
        $teamOne_Follower = User_fav_follow::where('is_type', 1)->where('type_id', $match_fixture->teamOne_id)->where('Is_follow', 1)->Orwhere('Is_fav', 1)->pluck('user_id');
        $teamTwo_Follower = User_fav_follow::where('is_type', 1)->where('type_id', $match_fixture->teamTwo_id)->where('Is_follow', 1)->Orwhere('Is_fav', 1)->pluck('user_id');
        $comp_follower = User_fav_follow::where('is_type', 2)->where('type_id', $match_fixture->competition_id)->where('Is_follow', 1)->Orwhere('Is_fav', 1)->pluck('user_id');
        $teamOne_admin[] = $teamOne->user_id;
        $teamTwo_admin[] = $teamTwo->user_id;
        $user = array_merge($teamOnemember->toArray(), $teamTwomember->toArray(), $teamOne_Follower->toArray(), $teamTwo_Follower->toArray(), $comp_follower->toArray(), $teamOne_admin, $teamTwo_admin);
        $allusersunique = array_values(array_unique($user));

        $reset_match = Match_fixture::find($this->match_fixture_id->id);
        $reset_match->startdate_time = NULL;
        $reset_match->save();
        $match_fixture_stat = Match_fixture_lapse::where('match_fixture_id', $this->match_fixture_id->id)->delete();
        for ($i = 0; $i < Count($allusersunique); $i++) {
            if ($allusersunique[$i] != Auth::user()->id) {
                $notification = new Notification();
                $notification->notify_module_id = 7;
                $notification->type_id = $match_fixture->id;
                $notification->sender_id = Auth::user()->id;
                $notification->reciver_id = $allusersunique[$i];
                $notification->save();
            }
        }
        return redirect(route('match-fixture.show', $this->match_fixture_id->id));
    }

    public function red_yellow_card_player()
    {
        //dd($this->match_fixture_id->id);
        if ($this->player_id != null) {
            $p_id = $this->player_id;
        } else {
            $p_id = $this->f_lineup_player_id;
        }
        $red_card_player = Match_fixture_stat::where('match_fixture_id', $this->match_fixture_id->id)->where('player_id', $p_id)->where('sport_stats_id', 3)->count();
        // dd($red_card_player);
        if ($red_card_player == 1) {
            $message = "This Player have one Red card";
        } else {
            $message = "This Player have two yellow cards";
        }
        $this->dispatch('swal:modal', [

            'message' => $message,

        ]);
    }
    public function remove_stat($index)
    {
        $data = array();

        $this->span_class[]  = $index;
        // if (($key = array_search('strawberry', $array)) !== false)
        // {
        // unset($array[$key]);
        //  }
    }
}
