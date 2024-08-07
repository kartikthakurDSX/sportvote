<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\User_profile;
use App\Models\user_sport_cerification;
use App\Models\user_sport_membership;
use App\Models\Sport;
use App\Models\Sport_level;
use App\Models\Sport_attitude;
use App\Models\Team;
use App\Models\Country;
use App\Models\Fixture_squad;
use App\Models\Sport_stat;
use App\Models\Competition_attendee;
use App\Models\User;
use App\Models\Match_fixture;
use App\Models\User_friend;
use App\Models\Match_fixture_stat;
use App\Models\Member_position;
use App\Models\Team_member;
use App\Models\User_fav_follow;
use App\Models\Trophy_cabinet;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PlayerprofileController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $countries = Country::all();
        $sports = Sport::all();
        $usportlevel = Sport_level::all();
        $usportattitude = Sport_attitude::all();
        $ufplayer = User::all();
        $ufplayers = User_profile::where('profile_type_id', 2)->with('user')->get();
        $ufavteam = Team::all();
        $competitions = Competition::all();
        $sport_level = Sport_level::all();
        $player_position = Member_position::where('member_type', 1)->get();

        $taglessBody = strip_tags($data->bio);

        $is_player = User_profile::where('profile_type_id', 2)
            ->groupBy('user_id')
            ->pluck('user_id');

        $player_array = $is_player->toArray();

        if (in_array(Auth::user()->id, $player_array)) {
            return redirect('/');
        } else {
            return view('frontend.playerprofiles.create', compact('sport_level', 'ufplayer', 'data', 'competitions', 'countries', 'sports', 'usportlevel', 'usportattitude', 'ufplayers', 'ufavteam', 'player_position', 'taglessBody'));
        }
    }



    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'sport_id' => ['required'],
            'first_name' => ['required', 'alpha'],
            'last_name' => ['required', 'alpha'],
            'preferred_position' => ['required'],
            'dob' => ['required'],
            'bio' => ['required'],
            'nationality' => ['required'],
            'location' => ['required'],
            'weight' => ['required'],
            'height' => ['required'],
            'profile_pic' => ['image'],
        ]);

        //if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)->withInput();
        }
        if ($request->get('accept_userLevel_type')) {
            $accept_userLevel_invite = implode(",", $request->get('accept_userlevel_type'));
        } else {
            $accept_userLevel_invite = " ";
        }
        if ($request->get('accept_teamlevel_invite')) {
            $accept_teamlevel_invite = implode(",", $request->get('accept_teamlevel_invite'));
        } else {
            $accept_teamlevel_invite = " ";
        }




        $userprofiles = new User_profile([
            'profile_desc' => $request->get('profile_desc'),
            'user_id' => auth::user()->id,
            'sport_id' => $request->get('sport_id'),
            'sport_level_id' => $request->get('sport_level'),
            'preferred_position' => $request->get('preferred_position'),
            'sport_attitude_id' => $request->get('sport_attitude'),
            'level_id' => $request->get('level_id'),
            'profile_type_id' => 2,
            'accept_teamlevel_invite' => $accept_teamlevel_invite,
            'accept_userLevel_invite' => $accept_userLevel_invite,
            'accept_team_invite' => $request->get('accept_team_invite'),
            'accept_user_invite' => $request->get('accept_user_invite'),
            'accept_userlevel_type' => $request->get('accept_userlevel_type'),

        ]);
        if ($request->hasFile('level_proof')) {
            $file = $request->file('level_proof');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $destinationPath = public_path('/frontend/certificate/');
            $file->move($destinationPath, $filename);
            $userprofiles->level_proof = $filename;
        }

        $userprofiles->save();
        $id = Auth::user()->id;
        $users = User::find($id);
        $users->first_name = $request->first_name;
        $users->last_name = $request->last_name;
        $users->bio = $request->bio;
        $users->height = $request->height;
        $users->weight = $request->weight;
        $users->dob = $request->dob;
        $users->nationality = $request->nationality;
        $users->location = $request->location;
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $destinationPath = public_path('/frontend/profile_pic/');
            $file->move($destinationPath, $filename);
            $users->profile_pic = $filename;
        }



        $users->save();

        //   user sport certificates

        if ($request->certname) {
            for ($x = 0; $x < count($request->certname); $x++) {
                if ($request->certname[$x]) {
                    $usersport_certification = new user_sport_cerification();
                    $usersport_certification->user_id = $id;
                    $usersport_certification->sport_id = $request->sport_id;
                    $usersport_certification->name = $request->certname[$x];
                    $usersport_certification->description = $request->certdescription[$x];

                    if ($request->certificate) {
                        $file = $request->certificate[$x];
                        if ($file->isValid()) {
                            $extension = $file->getClientOriginalExtension();
                            $filename = 'UIMG' . date('Ymd') . uniqid() . $extension;
                            $destinationPath = public_path('/frontend/certificate/');
                            $file->move($destinationPath, $filename);
                            $usersport_certification->certificate = $filename;
                        }
                    }
                    $usersport_certification->save();
                }
            }
        }

        if ($request->name) {
            // user sport membership
            for ($x = 0; $x < count($request->name); $x++) {
                if ($request->name[$x]) {
                    $usersport_membership = new user_sport_membership();
                    $usersport_membership->user_id = $id;
                    $usersport_membership->sport_id = $request->sport_id;
                    $usersport_membership->name = $request->name[$x];
                    $usersport_membership->description = $request->description[$x];
                    if ($request->logo) {
                        $file = $request->logo[$x];
                        if ($file->isValid()) {
                            $extension = $file->getClientOriginalExtension();
                            $filename = 'UIMG' . date('Ymd') . uniqid() . $extension;
                            $destinationPath = public_path('/frontend/logo/');
                            $file->move($destinationPath, $filename);
                            $usersport_membership->logo = $filename;
                        }
                    }
                    $usersport_membership->save();
                }
            }
        }
        // add more
        if ($request->search) {
            for ($x = 0; $x < count($request->search); $x++) {
                if ($request->search[$x] != 0) {
                    $action_user_id = Team::find($request->search[$x]);
                    $check_team = Team_member::where('member_id', $id)->where('team_id', $request->search[$x])->get();
                    if ($check_team->isEmpty()) {
                        $teamjoins = new Team_member();
                        $teamjoins->action_user = $action_user_id->user_id;
                        $teamjoins->team_id = $request->search[$x];
                        $teamjoins->reason = $request->reason[$x];
                        $teamjoins->member_id = $id;
                        $teamjoins->member_position_id = $request->plyrpreferred_position[$x];
                        $teamjoins->alt_member_position_id1 = $request->plyr_alt_preferred_position1[$x];
                        $teamjoins->alt_member_position_id2 = $request->plyr_alt_preferred_position2[$x];
                        $teamjoins->save();
                        $teamjoin_id = $teamjoins->id;

                        // store data in notification table
                        $notification = Notification::create([
                            'notify_module_id' => 2,
                            'type_id' => $teamjoin_id,
                            'sender_id' => Auth::user()->id,
                            'reciver_id' => $action_user_id->user_id,

                        ]);
                    }
                }
            }
        }
        if ($request->friend) {
            $friendcount = count($request->friend);
            for ($y = 0; $y < $friendcount; $y++) {
                $ufr = new User_friend();
                $ufr->user_id = $id;
                $ufr->friend_id = $request->friend[$y];
                $ufr->save();
                $ufr_id = $ufr->id;
                // Store data in notification table
                $notification = Notification::create([
                    'notify_module_id' => 1,
                    'type_id' => $ufr_id,
                    'sender_id' => Auth::user()->id,
                    'reciver_id' => $request->friend[$y],
                ]);
            }
        }
        //

        if ($request->fav_player) {
            for ($x = 0; $x < count($request->fav_player); $x++) {

                $check = User_fav_follow::where('user_id', $id)->where('is_type', 3)->where('type_id', $request->fav_player[$x])->value('id');
                if (!$check) {
                    $user_fav_follow = new User_fav_follow();
                    $user_fav_follow->user_id = $id;
                    $user_fav_follow->is_type = 3;
                    $user_fav_follow->is_fav = 1;
                    $user_fav_follow->type_id = $request->fav_player[$x];
                    $user_fav_follow->save();
                    $notification = Notification::create([
                        'notify_module_id' => 5,
                        'type_id' => $user_fav_follow->id,
                        'sender_id' => Auth::user()->id,
                        'reciver_id' => $request->fav_player[$x],
                    ]);
                } else {
                    $user_fav_follow = User_fav_follow::find($check);
                    $user_fav_follow->is_fav = 1;
                    $user_fav_follow->save();
                }
            }
        }

        if ($request->fav_team) {
            for ($x = 0; $x < count($request->fav_team); $x++) {
                $team = Team::find($request->fav_team[$x]);
                $check = User_fav_follow::where('user_id', $id)->where('is_type', 1)->where('type_id', $request->fav_team[$x])->value('id');
                if (!$check) {
                    $user_fav_follow = new User_fav_follow();
                    $user_fav_follow->user_id = $id;
                    $user_fav_follow->is_type = 1;
                    $user_fav_follow->is_fav = 1;
                    $user_fav_follow->type_id = $request->fav_team[$x];
                    $user_fav_follow->save();

                    $notification = Notification::create([
                        'notify_module_id' => 5,
                        'type_id' => $user_fav_follow->id,
                        'sender_id' => Auth::user()->id,
                        'reciver_id' => $team->user_id,
                    ]);
                } else {
                    $user_fav_follow = User_fav_follow::find($check);
                    $user_fav_follow->is_fav = 1;
                    $user_fav_follow->save();
                }
            }
        }

        if ($request->fav_comp) {
            for ($x = 0; $x < count($request->fav_comp); $x++) {
                $competition = Competition::find($request->fav_comp[$x]);
                $check = User_fav_follow::where('user_id', $id)->where('is_type', 2)->where('type_id', $request->fav_comp[$x])->value('id');
                if (!$check) {
                    $user_fav_follow = new User_fav_follow();
                    $user_fav_follow->user_id = $id;
                    $user_fav_follow->is_type = 2;
                    $user_fav_follow->is_fav = 1;
                    $user_fav_follow->type_id = $request->fav_comp[$x];
                    $user_fav_follow->save();

                    $notification = Notification::create([
                        'notify_module_id' => 5,
                        'type_id' => $user_fav_follow->id,
                        'sender_id' => Auth::user()->id,
                        'reciver_id' => $competition->user_id,
                    ]);
                } else {
                    $user_fav_follow = User_fav_follow::find($check);
                    $user_fav_follow->is_fav = 1;
                    $user_fav_follow->save();
                }
            }
        }


        if ($request->player) {
            for ($x = 0; $x < count($request->player); $x++) {

                $check = User_fav_follow::where('user_id', $id)->where('is_type', 3)->where('type_id', $request->player[$x])->value('id');
                if (!$check) {
                    $user_fav_follow = new User_fav_follow();
                    $user_fav_follow->user_id = $id;
                    $user_fav_follow->is_type = 3;
                    $user_fav_follow->is_follow = 1;
                    $user_fav_follow->type_id = $request->player[$x];
                    $user_fav_follow->save();

                    $notification = Notification::create([
                        'notify_module_id' => 5,
                        'type_id' => $user_fav_follow->id,
                        'sender_id' => Auth::user()->id,
                        'reciver_id' => $request->player[$x],
                    ]);
                } else {
                    $user_fav_follow = User_fav_follow::find($check);
                    $user_fav_follow->is_follow = 1;
                    $user_fav_follow->save();
                }
            }
        }
        if ($request->team) {
            for ($x = 0; $x < count($request->team); $x++) {
                $team = Team::find($request->team[$x]);
                $check = User_fav_follow::where('user_id', $id)->where('is_type', 1)->where('type_id', $request->team[$x])->value('id');
                if (!$check) {
                    $user_fav_follow = new User_fav_follow();
                    $user_fav_follow->user_id = $id;
                    $user_fav_follow->is_type = 1;
                    $user_fav_follow->is_follow = 1;
                    $user_fav_follow->type_id = $request->team[$x];
                    $user_fav_follow->save();
                    $notification = Notification::create([
                        'notify_module_id' => 5,
                        'type_id' => $user_fav_follow->id,
                        'sender_id' => Auth::user()->id,
                        'reciver_id' => $team->user_id,
                    ]);
                } else {
                    $user_fav_follow = User_fav_follow::find($check);
                    $user_fav_follow->is_follow = 1;
                    $user_fav_follow->save();
                }
            }
        }
        if ($request->comp) {
            for ($x = 0; $x < count($request->comp); $x++) {
                $competition = Competition::find($request->comp[$x]);
                $check = User_fav_follow::where('user_id', $id)->where('is_type', 2)->where('type_id', $request->comp[$x])->value('id');
                if (!$check) {

                    $user_fav_follow = new User_fav_follow();
                    $user_fav_follow->user_id = $id;
                    $user_fav_follow->is_type = 2;
                    $user_fav_follow->is_follow = 1;
                    $user_fav_follow->type_id = $request->comp[$x];
                    $user_fav_follow->save();
                    $notification = Notification::create([
                        'notify_module_id' => 5,
                        'type_id' => $user_fav_follow->id,
                        'sender_id' => Auth::user()->id,
                        'reciver_id' => $competition->user_id,
                    ]);
                } else {
                    $user_fav_follow = User_fav_follow::find($check);
                    $user_fav_follow->is_follow = 1;
                    $user_fav_follow->save();
                }
            }
        }
        $update_user = User::find(Auth::user()->id);
        $update_user->p_box_player = 1;
        $update_user->save();
        return redirect('dashboard');
    }

    public function show($id)
    {
        $user_info = User::find($id);

        $total_inches = $user_info->height / 2.54;
        $d_feet = (int)(round($total_inches) / 12);
        $d_in = (int)(round($total_inches) - 12 * $d_feet);

        $age = Carbon::parse($user_info->dob)->age;
        $is_player = User_profile::where('user_id', $id)->first();
        $team_member = Team_member::where('member_id', $id)
            ->where('invitation_status', 1)
            ->latest()
            ->first();
        $all_team_member = Team_member::where('team_id', '!=', @$team_member->team_id)
            ->where('member_id', $id)
            ->where('invitation_status', 1)
            ->latest()
            ->get();
        $followers = User_fav_follow::where('is_type', 3)
            ->where('type_id', $user_info->id)
            ->where('Is_follow', 1)
            ->get();
        $following = User_fav_follow::where('is_type', 3)
            ->where('user_id', $user_info->id)
            ->where('Is_follow', 1)
            ->get();
        $trophy_cabinets = Trophy_cabinet::where('type', 1)
            ->where('type_id', $user_info->id)
            ->where('is_active', 1)
            ->get();
        $weight_lbs = (int)($user_info->weight * 2.20462);

        $teams = Competition_attendee::where('attendee_id', $id)->pluck('team_id');
        $team_ids = array_values(array_unique($teams->toArray()));

        $fixtures = Match_fixture::whereIn('teamOne_id', $team_ids)
            ->orWhereIn('teamTwo_id', $team_ids)
            ->with('competition', 'teamOne', 'teamTwo')
            ->get();
        $fixtures_dates = Match_fixture::whereIn('teamOne_id', $team_ids)
            ->orWhereIn('teamTwo_id', $team_ids)
            ->with('competition', 'teamOne', 'teamTwo')
            ->pluck('fixture_date');
        $fix_date_array = $fixtures_dates->toArray();
        if (count($fix_date_array) > 0) {
            $mindate = min(array_map('strtotime', $fix_date_array));
            $min_year = date('Y', $mindate);
            $min_year_month = date('m', $mindate);
            $maxdate = max(array_map('strtotime', $fix_date_array));
            $max_year = date('Y', $maxdate);
            $max_year_month = date('m', $maxdate);
        } else {
            // dd($fix_date_array);
            $max_year_month = date('m');
            $min_year = date('Y');
            $min_year_month = date('m');
            $max_year = date('Y');
        }

        $f_fixtures_date = Match_fixture::whereIn('teamOne_id', $team_ids)
            ->orWhereIn('teamTwo_id', $team_ids)
            ->with('competition', 'teamOne', 'teamTwo')
            ->first();
        $l_fixtures_date = Match_fixture::whereIn('teamOne_id', $team_ids)
            ->orWhereIn('teamTwo_id', $team_ids)
            ->with('competition', 'teamOne', 'teamTwo')
            ->latest()
            ->first();

        $first_fixtures_year = !empty($f_fixtures_date) ? date('Y', strtotime($f_fixtures_date->fixture_date)) : '';
        $lastest_fixture_year = !empty($l_fixtures_date) ? date('Y', strtotime($l_fixtures_date->fixture_date)) : '';
        $first_fixtures_month = !empty($f_fixtures_date) ? date('M', strtotime($f_fixtures_date->fixture_date)) : '';
        $lastest_fixture_month = !empty($l_fixtures_date) ? date('M', strtotime($l_fixtures_date->fixture_date)) : '';

        $month_array = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];

        $player_stats = Match_fixture_stat::where('player_id', $id)->latest()->get();
        $first_player_stat = Match_fixture_stat::where('player_id', $id)->latest()->first();
        $basic_stat = [1, 5, 2, 3];

        if (!empty($first_player_stat)) {
            $team = Team::find($first_player_stat->team_id);
            $contract_jerseynum = Team_member::with('member_position')
                ->where('team_id', $team->id)
                ->where('member_id', $user_info->id)
                ->first();
            $contract_start_date = strtoupper(date('M', strtotime($contract_jerseynum->created_at))) . ' ' . date('d, Y', strtotime($contract_jerseynum->created_at));
            $team_id_var = $team->id;
            $first_comp_id = $first_player_stat->competition_id;
            $check_next_fixture = Match_fixture::where(function ($query) use ($team_id_var) {
                $query->where('teamOne_id', '=', $team_id_var)
                    ->orWhere('teamTwo_id', '=', $team_id_var);
            })
                ->where('competition_id', $first_player_stat->competition_id)
                ->whereNull('startdate_time')
                ->first();

            if (!empty($check_next_fixture)) {
                $next_match_opp_team = $check_next_fixture->teamOne_id == $first_player_stat->team_id ? Team::find($check_next_fixture->teamTwo_id) : Team::find($check_next_fixture->teamOne_id);
                $next_macth_content = strtoupper(date('d M Y', strtotime($check_next_fixture->fixture_date)));
                $next_match = "";
            } else {
                $next_match = 'N/A';
                $next_match_opp_team = "";
                $next_macth_content = "N/A";
            }

            $all_goal = Match_fixture_stat::where('competition_id', $first_player_stat->competition_id)
                ->where('sport_stats_id', 1)
                ->where('team_id', $team->id)
                ->count();
            $my_all_goal = Match_fixture_stat::where('competition_id', $first_player_stat->competition_id)
                ->where('sport_stats_id', 1)
                ->where('team_id', $team->id)
                ->where('player_id', $id)
                ->count();
            $goal_prec = $all_goal > 0 ? number_format(($my_all_goal / $all_goal) * 100, 2) : "00.00";

            $all_yellow_card = Match_fixture_stat::where('competition_id', $first_player_stat->competition_id)
                ->where('team_id', $team->id)
                ->where('sport_stats_id', 2)
                ->count();
            $my_yellow_card = Match_fixture_stat::where('competition_id', $first_player_stat->competition_id)
                ->where('team_id', $team->id)
                ->where('player_id', $id)
                ->where('sport_stats_id', 2)
                ->count();
            $yellow_card_prec = $all_yellow_card > 0 ? number_format(($my_yellow_card / $all_yellow_card) * 100, 2) : "00.00";

            $all_red_card = Match_fixture_stat::where('competition_id', $first_player_stat->competition_id)
                ->where('team_id', $team->id)
                ->where('sport_stats_id', 3)
                ->count();
            $my_red_card = Match_fixture_stat::where('competition_id', $first_player_stat->competition_id)
                ->where('team_id', $team->id)
                ->where('player_id', $id)
                ->where('sport_stats_id', 3)
                ->count();
            $red_card_prec = $all_red_card > 0 ? number_format(($my_red_card / $all_red_card) * 100, 2) : "00.00";

            $all_passes = Match_fixture_stat::where('competition_id', $first_player_stat->competition_id)
                ->where('team_id', $team->id)
                ->where('sport_stats_id', 3)
                ->count();
            $my_passes = Match_fixture_stat::where('competition_id', $first_player_stat->competition_id)
                ->where('team_id', $team->id)
                ->where('player_id', $id)
                ->where('sport_stats_id', 3)
                ->count();
            $passes_prec = $all_passes > 0 ? number_format(($my_passes / $all_passes) * 100, 2) : "00.00";

            return view('frontend.playerprofiles.view', compact(
                'user_info',
                'is_player',
                'd_feet',
                'd_in',
                'age',
                'team_member',
                'followers',
                'following',
                'weight_lbs',
                'fixtures',
                'first_fixtures_year',
                'lastest_fixture_year',
                'month_array',
                'first_fixtures_month',
                'lastest_fixture_month',
                'team_ids',
                'player_stats',
                'team',
                'contract_jerseynum',
                'all_goal',
                'my_all_goal',
                'goal_prec',
                'yellow_card_prec',
                'all_yellow_card',
                'my_yellow_card',
                'red_card_prec',
                'my_red_card',
                'all_red_card',
                'all_passes',
                'passes_prec',
                'my_passes',
                'contract_start_date',
                'next_match',
                'next_macth_content',
                'next_match_opp_team',
                'trophy_cabinets',
                'basic_stat',
                'first_comp_id',
                'all_team_member',
                'check_next_fixture',
                'max_year',
                'min_year_month',
                'max_year_month',
                'min_year'
            ));
        } else {
            return view('frontend.playerprofiles.view', compact(
                'user_info',
                'is_player',
                'd_feet',
                'd_in',
                'age',
                'team_member',
                'followers',
                'following',
                'weight_lbs',
                'fixtures',
                'first_fixtures_year',
                'lastest_fixture_year',
                'month_array',
                'first_fixtures_month',
                'lastest_fixture_month',
                'team_ids',
                'player_stats',
                'trophy_cabinets',
                'basic_stat',
                'all_team_member',
                'max_year',
                'min_year_month',
                'max_year_month',
                'min_year'
            ));
        }
    }

    public function player_p_my_stat(Request $request)
    {
        $comp_id = $request->comp_id;
        $player_id = $request->player_id;
        $team_id = Competition_attendee::select('team_id')->where('Competition_id', $comp_id)->where('attendee_id', $player_id)->first();
        $player_team_id = $team_id->team_id;
        $next_match = "N/A";
        $player_position = Team_member::where('member_id', $player_id)->where('team_id', $player_team_id)->with('member_position')->first();
        $team = Team::find($player_team_id);
        $basic_stat = [1, 5, 2, 3];

        $check_next_fixture = Match_fixture::where(function ($query) use ($player_team_id) {
            $query->where('teamOne_id', '=', $player_team_id)
                ->orWhere('teamTwo_id', '=', $player_team_id);
        })->where('competition_id', $comp_id)->where('startdate_time', NULL)->first();
?> <div class="col-md-12">
            <div class="row">
                <div class="col-md-8 ">
                    <div class="LeftBoxOuter W-auto-Scroll" id="ScrollBottom">
                        <div class="WidthMin768">
                            <div class="row StatPaddingTB" id="MyStat2of1">
                                <div class="col-md-3 col-6 LineHeight ">
                                    <div class="D-inlineFlx">
                                        <div class="RedCr"></div>
                                        <p class="mb-0T">Team Stats</p>
                                    </div>
                                    <div class="D-inlineFlx">
                                        <div class="BlueCr"></div>
                                        <p class="mb-0T">My Stats </p>

                                    </div>

                                </div>

                                <?php if (!empty($check_next_fixture)) {
                                    if ($check_next_fixture->teamOne_id == $player_team_id) {
                                        $next_match_opp_team = Team::find($check_next_fixture->teamTwo_id);
                                    } else {
                                        $next_match_opp_team = Team::find($check_next_fixture->teamOne_id);
                                    }
                                    $next_macth_content = strtoupper(date('d M Y', strtotime($check_next_fixture->fixture_date)));
                                ?>
                                    <div class="col-md-3 col-6 txtCenterMob WithDate LineHeight">Next Match
                                        <span class="stageReimsSize">
                                            <img src="<?php echo url('frontend/logo') ?>/<?php echo $next_match_opp_team->team_logo; ?>" class="img-fluid stageReims">
                                        </span>
                                        <a href="<?php echo url('match-fixture/' . $check_next_fixture->id) ?>" target="_blank">
                                            <p class="MatchDate"><?php echo $next_macth_content; ?></p>
                                        </a>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-md-3 col-6 txtCenterMob withoutDate LineHeight">Next<br>Match
                                        <span class="NAPlayerDas">N/A</span>
                                    </div>
                                <?php }
                                ?>

                                <div class="col-md-4 col-6 LineHeight">
                                    <div class="row">
                                        <div class="pr-4 col-md-4">
                                            <span class="SQUAD">SQUAD</span>
                                            <p class="PositionSquad">POSITION</p>
                                        </div>
                                        <div class="pl-0 col-md-8">
                                            <span class="StrickerTxt" id="squad_position"> <?php echo $player_position->member_position->name; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center col-md-2 col-6 LineHeight">
                                    <div class="row">
                                        <div class="pr-4 col-md-6">
                                            <span class="SQUAD">JERSEY</span>
                                            <p class="PositionSquad">NUMBER</p>
                                        </div>
                                        <div class="pl-0 col-md-6">
                                            <span class="JersyNo" id="jersy_num" style="background-color:<?php echo $team->team_color; ?> "><?php
                                                                                                                                            if (!empty($player_position['jersey_number'])) {
                                                                                                                                                echo $player_position = str_pad($player_position['jersey_number'], 2, '0', STR_PAD_LEFT);
                                                                                                                                            } else {
                                                                                                                                                echo "NA";
                                                                                                                                            }
                                                                                                                                            ?> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row " id="MyStat2of2">
                                <div class="col-md-1 width-7">
                                </div>
                                <?php
                                $total_played = Match_fixture::select('id')->where(function ($query) use ($player_team_id) {
                                    $query->where('teamOne_id', '=', $player_team_id)
                                        ->orWhere('teamTwo_id', '=', $player_team_id);
                                })->where('competition_id', $comp_id)->where('finishdate_time', '!=', Null)->get();
                                $fixture_ids = array();
                                foreach ($total_played as $fixture) {
                                    $fixture_ids[] = $fixture->id;
                                }
                                $player_played = Fixture_squad::whereIn('match_fixture_id', $fixture_ids)->where('team_id', $player_team_id)->where('player_id', $player_id)->count();
                                if ($total_played->count() > 0) {
                                    $played_precs = ($player_played / $total_played->count()) * 100;
                                    $played_prec = number_format($played_precs, 2);
                                } else {
                                    $played_prec = "00.00";
                                }
                                ?>
                                <div class="text-center col-md-2 col-6 mobMrgRL">
                                    <div class="SpacingLine ">
                                        <div class="FiftyTwoPer">
                                            <div class="PlayedStyle"><?php echo str_pad($total_played->count(), 2, "0", STR_PAD_LEFT); ?></div><strong class="Payed23"><?php echo str_pad($player_played, 2, "0", STR_PAD_LEFT); ?></strong><span class="PlayedUnderText"> <?php echo $played_prec; ?> %
                                            </span>
                                        </div>
                                        <p class="Playedcolor">Played</p>
                                    </div>
                                </div> <?php
                                        foreach ($basic_stat as $stat_id) {
                                            $stat = Sport_stat::find($stat_id);
                                            $total_stats = Match_fixture_stat::where('competition_id', $comp_id)->where('sport_stats_id', $stat->id)->where('team_id', $player_team_id)->count();
                                            $player_stats = Match_fixture_stat::where('competition_id', $comp_id)->where('sport_stats_id', $stat->id)->where('team_id', $player_team_id)->where('player_id', $player_id)->count();
                                            if ($total_stats > 0) {
                                                $stat_precs = ($player_stats / $total_stats) * 100;
                                                $stat_prec = number_format($stat_precs, 2);
                                            } else {
                                                $stat_prec = "00.00";
                                            }
                                        ?>
                                    <div class="text-center col-md-2 col-6 mobMrgRL">
                                        <div class="SpacingLine ">
                                            <div class="FiftyTwoPer">
                                                <div class="PlayedStyle"><?php echo str_pad($total_stats, 2, "0", STR_PAD_LEFT); ?></div><strong class="Payed23"><?php echo str_pad($player_stats, 2, "0", STR_PAD_LEFT); ?></strong><span class="PlayedUnderText"><?php echo $stat_prec; ?>%
                                                </span>
                                            </div>
                                            <p class="Playedcolor"><?php echo $stat->description; ?></p>
                                        </div>
                                    </div><?php
                                        } ?>



                                <div class="col-md-2 width-7">
                                </div>
                            </div>
                            <div class="text-right col-md-12 statviewComp ">
                                <a class="FullStat" href="<?php echo url('competition/' . $comp_id) ?>" target="_blank">
                                    View Competition </a>&nbsp;|&nbsp;<a class="FullStat" data-bs-toggle="modal" data-bs-target="#FullStatTable">~Full Stat Table</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="FootbalClubCircl heightAddRespon">

                        <a href="<?php echo url('team/' . $team->id) ?>" target="_blank"> <img class="rounded-circle" id="team_logo" src="<?php echo url('frontend/logo') ?>/<?php echo $team->team_logo; ?>" width="80%" alt="..."> </a>
                        <a href="<?php echo url('team/' . $team->id) ?>" target="_blank">
                            <p class="LogoBottomText" id="team_name"><?php echo $team->name; ?></p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
<?php


    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }


    public function autosearch_player(Request $request)
    {

        $data = User::select("id", "first_name as name")
            ->where("first_name", "LIKE", "%{$request->input('query')}%")
            ->get();
        return response()->json($data);
    }
    public function edit_playerlogo(Request $request, $id)
    {
        $path = 'frontend/profile_pic';
        $file = $request->file('playerlogo');
        $new_image_name = 'UIMG' . date('Ymd') . uniqid() . '.jpg';
        $upload = $file->move(public_path($path), $new_image_name);
        $playerprofile = User::find($id);
        $playerprofile->profile_pic = $new_image_name;
        $playerprofile->save();
        if ($upload) {
            return response()->json(['status' => 1, 'msg' => $playerprofile, 'element' => $playerprofile]);
        } else {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong, try again later']);
        }
    }
    public function edit_playerimg(Request $request, $id)
    {
        $path = 'frontend/profile_pic';
        $file = $request->file('profile_pic');
        $new_image_name = 'UIMG' . date('Ymd') . uniqid() . '.jpg';
        $upload = $file->move(public_path($path), $new_image_name);
        $playerprofile = User::find($id);
        $playerprofile->profile_pic = $new_image_name;
        $playerprofile->save();
        if ($upload) {
            return response()->json(['status' => 1, 'msg' => $playerprofile, 'element' => $playerprofile]);
        } else {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong, try again later']);
        }
    }

    public function edit_playerbanner(Request $request, $id)
    {
        $path = 'frontend/banner';
        $file = $request->file('playerbanner');
        $new_image_name = 'UIMG' . date('Ymd') . uniqid() . '.jpg';
        $upload = $file->move(public_path($path), $new_image_name);
        $playerprofilebanner = User::find($id);
        $playerprofilebanner->banner = $new_image_name;
        $playerprofilebanner->save();
        if ($upload) {
            return response()->json(['status' => 1, 'msg' => $playerprofilebanner, 'element' => $playerprofilebanner]);
        } else {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong, try again later']);
        }
    }

    public function addplayertrophycabinet(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'years' => 'required',
            'team' => 'required',
            'competition' => 'required',
            'trophy_image' => 'required',
        ]);
        $year = implode(',', $request->years);
        $request->trophy_image->store('image', 'public');
        $trophy_image = $request->trophy_image->hashName();

        $addtrophy_cabinet = new Trophy_cabinet();
        $addtrophy_cabinet->type = 1;
        $addtrophy_cabinet->type_id = $request->player_id;
        $addtrophy_cabinet->title = $request->title;
        $addtrophy_cabinet->year = $year;
        $addtrophy_cabinet->team = $request->team;
        $addtrophy_cabinet->comp = $request->competition;
        $addtrophy_cabinet->trophy_image = $trophy_image;
        $addtrophy_cabinet->save();
        if ($addtrophy_cabinet) {
            return back();
        }
    }
    public function editplayertrophycabinet($id)
    {
        $editcabinet = Trophy_cabinet::find($id);
        $select = explode(',', $editcabinet->year);
        return response()->json(['editcabinet' => $editcabinet, 'select' => $select]);
    }

    public function deleteplayertrophycabinet($id)
    {
        $deletecabinet = Trophy_cabinet::find($id)->delete();
        return redirect()->back();
    }

    public function create_player_profile()
    {
        return view('frontend.playerprofiles.create_player');
    }
}
