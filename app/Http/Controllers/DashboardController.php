<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_profile;
use App\Models\user_sport_cerification;
use App\Models\user_sport_membership;
use App\Models\User_fav_follow;
use App\Models\Notification;
use App\Models\User_friend;
use App\Models\Team_member;
use App\Models\Member_position;
use App\Models\Member_permission;
use App\Models\Competition_attendee;
use App\Models\Match_fixture;
use App\Models\Fixture_squad;
use App\Models\Sport_stat;
use App\Models\Match_fixture_stat;
use App\Models\Team;
use App\Models\Competition;


class DashboardController extends Controller
{
    public function index()
    {
        $is_player = User_profile::where('user_id', Auth::user()->id)->where('profile_type_id', 2)->count();
        $is_team_admin = Team::where('user_id', Auth::user()->id)->count();
        $is_comp_admin = Competition::where('user_id', Auth::user()->id)->count();
        $comp_follow = User_fav_follow::where('user_id', Auth::user()->id)
            ->where('is_type', 2)
            ->where('Is_follow', 1)
            ->where('is_active', 1)
            ->limit(30)
            ->orderBy('id', 'DESC')
            ->get();
        $team_follow = User_fav_follow::where('user_id', Auth::user()->id)
            ->where('is_type', 1)
            ->where('Is_follow', 1)
            ->where('is_active', 1)
            ->limit(30)
            ->orderBy('created_at', 'DESC')
            ->get();
        $comp_follow_ids_array = [];
        foreach ($comp_follow as $follow) {
            $comp_follow_ids_array[] = $follow->type_id;
        }

        $player_follow = User_fav_follow::where('user_id', Auth::user()->id)
            ->where('is_type', 3)
            ->where('Is_follow', 1)
            ->where('is_active', 1)
            ->with('user', 'player')
            ->limit(30)
            ->orderBy('created_at', 'DESC')
            ->get();

        $get_competitions = Competition::whereIn('id', $comp_follow_ids_array)
            ->orderBy('id', "DESC")
            ->get();

        if ($get_competitions->count() > 0) {
            // return "fasd";
            $first_comp = $comp_follow_ids_array[0];
            $first_comp_match_fixture = Match_fixture::where('competition_id', $first_comp)
                ->where('fixture_type', '!=', 9)
                ->where('finishdate_time', '!=', NULL)
                ->get();
            if ($is_player > 0) {
                $player_stats = Match_fixture_stat::where('player_id', Auth::user()->id)
                    ->latest()
                    ->get();
                $first_player_stat = Match_fixture_stat::where('player_id', Auth::user()->id)
                    ->latest()
                    ->first();
                if (!empty($first_player_stat)) {
                    $team_id = $first_player_stat->team_id;
                    $next_fixture = Match_fixture::where(function ($query) use ($team_id) {
                        $query->where('teamOne_id', '=', $team_id)
                            ->orWhere('teamTwo_id', '=', $team_id);
                    })->where('startdate_time', NULL)
                        ->latest()
                        ->first();

                    if (!empty($next_fixture)) {
                        if ($next_fixture->teamOne_id == $first_player_stat->team_id) {
                            $next_match_opp_team = Team::find($next_fixture->teamTwo_id);
                        } else {
                            $next_match_opp_team = Team::find($next_fixture->teamOne_id);
                        }
                        $next_fixture_date = strtoupper(date('d M Y', strtotime($next_fixture->fixture_date)));

                        $next_match = "";
                    } else {
                        $next_match_opp_team = "";
                        $next_fixture_date = "N/A";
                    }
                    $team = Team::find($first_player_stat->team_id);
                    $teamcolor = $team->team_color;
                    $contract_jerseynum = Team_member::with('member_position')
                        ->where('team_id', $team->id)
                        ->where('member_id', Auth::user()->id)
                        ->first();
                    $total_played = Match_fixture::select('id')
                        ->where(function ($query) use ($team_id) {
                            $query->where('teamOne_id', '=', $team_id)
                                ->orWhere('teamTwo_id', '=', $team_id);
                        })->where('competition_id', $first_player_stat->competition_id)
                        ->where('finishdate_time', '!=', NULL)
                        ->get();

                    $fixture_ids = [];
                    foreach ($total_played as $fixture) {
                        $fixture_ids[] = $fixture->id;
                    }
                    $player_played = Fixture_squad::whereIn('match_fixture_id', $fixture_ids)
                        ->where('team_id', $first_player_stat->team_id)
                        ->where('player_id', Auth::user()->id)
                        ->count();
                    if ($total_played->count() > 0) {
                        $played_precs = ($player_played / $total_played->count()) * 100;
                        $played_prec = number_format($played_precs, 2);
                    } else {
                        $played_prec = "00.00";
                    }
                    $id = Auth::user()->id;
                    $basic_stats = Sport_stat::whereIn('id', [1, 2, 3, 5])
                        ->where('is_active', 1)
                        ->get();

                    return view('frontend.dashboard', compact(
                        'is_player',
                        'is_team_admin',
                        'is_comp_admin',
                        'comp_follow',
                        'get_competitions',
                        'player_stats',
                        'next_fixture_date',
                        'next_match_opp_team',
                        'contract_jerseynum',
                        'team',
                        'teamcolor',
                        'total_played',
                        'player_played',
                        'played_prec',
                        'basic_stats',
                        'first_player_stat',
                        'first_comp_match_fixture',
                        'first_comp',
                        'team_follow',
                        'player_follow'
                    ));
                } else {
                    return view('frontend.dashboard', compact(
                        'is_player',
                        'is_team_admin',
                        'is_comp_admin',
                        'comp_follow',
                        'get_competitions',
                        'player_stats',
                        'first_comp_match_fixture',
                        'first_comp',
                        'team_follow',
                        'player_follow'
                    ));
                }
            } else {
                return view('frontend.dashboard', compact(
                    'is_player',
                    'is_team_admin',
                    'is_comp_admin',
                    'comp_follow',
                    'get_competitions',
                    'first_comp',
                    'first_comp_match_fixture',
                    'team_follow',
                    'player_follow'
                ));
            }
        } else {
            if ($is_player > 0) {
                $player_stats = Match_fixture_stat::where('player_id', Auth::user()->id)
                    ->latest()
                    ->get();
                $first_player_stat = Match_fixture_stat::where('player_id', Auth::user()->id)
                    ->latest()
                    ->first();
                if (!empty($first_player_stat)) {
                    $team_id = $first_player_stat->team_id;
                    $next_fixture = Match_fixture::where(function ($query) use ($team_id) {
                        $query->where('teamOne_id', '=', $team_id)
                            ->orWhere('teamTwo_id', '=', $team_id);
                    })->where('startdate_time', NULL)
                        ->latest()
                        ->first();

                    if (!empty($next_fixture)) {
                        if ($next_fixture->teamOne_id == $first_player_stat->team_id) {
                            $next_match_opp_team = Team::find($next_fixture->teamTwo_id);
                        } else {
                            $next_match_opp_team = Team::find($next_fixture->teamOne_id);
                        }
                        $next_fixture_date = strtoupper(date('d M Y', strtotime($next_fixture->fixture_date)));

                        $next_match = "";
                    } else {
                        $next_match_opp_team = "";
                        $next_fixture_date = "N/A";
                    }
                    $team = Team::find($first_player_stat->team_id);
                    $teamcolor = $team->team_color;
                    $contract_jerseynum = Team_member::with('member_position')
                        ->where('team_id', $team->id)
                        ->where('member_id', Auth::user()->id)
                        ->first();
                    $total_played = Match_fixture::select('id')
                        ->where(function ($query) use ($team_id) {
                            $query->where('teamOne_id', '=', $team_id)
                                ->orWhere('teamTwo_id', '=', $team_id);
                        })->where('competition_id', $first_player_stat->competition_id)
                        ->where('finishdate_time', '!=', NULL)
                        ->get();

                    $fixture_ids = [];
                    foreach ($total_played as $fixture) {
                        $fixture_ids[] = $fixture->id;
                    }
                    $player_played = Fixture_squad::whereIn('match_fixture_id', $fixture_ids)
                        ->where('team_id', $first_player_stat->team_id)
                        ->where('player_id', Auth::user()->id)
                        ->count();
                    if ($total_played->count() > 0) {
                        $played_precs = ($player_played / $total_played->count()) * 100;
                        $played_prec = number_format($played_precs, 2);
                    } else {
                        $played_prec = "00.00";
                    }
                    $id = Auth::user()->id;
                    $basic_stats = Sport_stat::whereIn('id', [1, 2, 3, 5])
                        ->where('is_active', 1)
                        ->get();

                    return view('frontend.dashboard', compact(
                        'is_player',
                        'is_team_admin',
                        'is_comp_admin',
                        'comp_follow',
                        'get_competitions',
                        'player_stats',
                        'next_fixture_date',
                        'next_match_opp_team',
                        'contract_jerseynum',
                        'team',
                        'teamcolor',
                        'total_played',
                        'player_played',
                        'played_prec',
                        'basic_stats',
                        'first_player_stat',
                        'team_follow'
                    ));
                } else {
                    return view('frontend.dashboard', compact(
                        'is_player',
                        'is_team_admin',
                        'is_comp_admin',
                        'comp_follow',
                        'get_competitions',
                        'player_stats',
                        'team_follow'
                    ));
                }
            } else {
                return view('frontend.dashboard', compact(
                    'is_player',
                    'is_team_admin',
                    'is_comp_admin',
                    'comp_follow',
                    'get_competitions',
                    'team_follow'
                ));
            }
        }
    }


    // public function index()
    // {
    //     $is_player = User_profile::where('user_id', Auth::user()->id)->where('profile_type_id', 2)->count();
    //     $is_team_admin = Team::where('user_id', Auth::user()->id)->count();
    //     $is_comp_admin = Competition::where('user_id', Auth::user()->id)->count();
    //     $comp_follow = User_fav_follow::where('user_id', Auth::user()->id)->where('is_type', 2)->where('Is_follow', 1)->where('is_active', 1)->limit(30)->orderBy('id', 'DESC')->get();
    //     $team_follow = User_fav_follow::where('user_id', Auth::user()->id)->where('is_type', 1)->where('Is_follow', 1)->where('is_active', 1)->limit(30)->orderBy('created_at', 'DESC')->get();
    //     $comp_follow_ids_array = array();
    //     foreach ($comp_follow as $follow) {
    //         $comp_follow_ids_array[] = $follow->type_id;
    //     }

    //     $player_follow = User_fav_follow::where('user_id', Auth::user()->id)->where('is_type', 3)->where('Is_follow', 1)->where('is_active', 1)->with('user', 'player')->limit(30)->orderBy('created_at', 'DESC')->get();

    //     $get_competitions = Competition::whereIn('id', $comp_follow_ids_array)->orderBy('id', "DESC")->get();
    //     if ($get_competitions->count() > 0) {
    //         $first_comp = $comp_follow_ids_array[0];
    //         $first_comp_match_fixture = Match_fixture::where('competition_id', $first_comp)->where('fixture_type', '!=', 9)->where('finishdate_time', '!=', NULL)->get();
    //         if ($is_player > 0) {
    //             $player_stats = Match_fixture_stat::where('player_id', Auth::user()->id)->latest()->get();
    //             $first_player_stat = Match_fixture_stat::where('player_id', Auth::user()->id)->latest()->first();
    //             if (!empty($first_player_stat)) {
    //                 $team_id = $first_player_stat->team_id;
    //                 $next_fixture = Match_fixture::where(function ($query) use ($team_id) {
    //                     $query->where('teamOne_id', '=', $team_id)
    //                         ->orWhere('teamTwo_id', '=', $team_id);
    //                 })->where('startdate_time', Null)->latest()->first();

    //                 if (!empty($next_fixture)) {
    //                     if ($next_fixture->teamOne_id == $first_player_stat->team_id) {
    //                         $next_match_opp_team = Team::find($next_fixture->teamTwo_id);
    //                     } else {
    //                         $next_match_opp_team = Team::find($next_fixture->teamOne_id);
    //                     }
    //                     $next_fixture_date = strtoupper(date('d M Y', strtotime($next_fixture->fixture_date)));

    //                     $next_match = "";
    //                 } else {
    //                     $next_match_opp_team = "";
    //                     $next_fixture_date = "N/A";
    //                 }
    //                 $team = Team::find($first_player_stat->team_id);
    //                 $teamcolor = $team->team_color;
    //                 $contract_jerseynum = Team_member::with('member_position')->where('team_id', $team->id)->where('member_id', Auth::user()->id)->first();
    //                 $total_played = Match_fixture::select('id')->where(function ($query) use ($team_id) {
    //                     $query->where('teamOne_id', '=', $team_id)
    //                         ->orWhere('teamTwo_id', '=', $team_id);
    //                 })->where('competition_id', $first_player_stat->competition_id)->where('finishdate_time', '!=', Null)->get();

    //                 $fixture_ids = array();
    //                 foreach ($total_played as $fixture) {
    //                     $fixture_ids[] = $fixture->id;
    //                 }
    //                 $player_played = Fixture_squad::whereIn('match_fixture_id', $fixture_ids)->where('team_id', $first_player_stat->team_id)->where('player_id', Auth::user()->id)->count();
    //                 if ($total_played->count() > 0) {
    //                     $played_precs = ($player_played / $total_played->count()) * 100;
    //                     $played_prec = number_format($played_precs, 2);
    //                 } else {
    //                     $played_prec = "00.00";
    //                 }
    //                 $id = Auth::user()->id;
    //                 $basic_stats = Sport_stat::whereIn('id', [1, 2, 3, 5])->where('is_active', 1)->get();

    //                 return view('frontend.dashboard', compact('is_player', 'is_team_admin', 'is_comp_admin', 'comp_follow', 'get_competitions', 'player_stats', 'next_fixture_date', 'next_match_opp_team', 'contract_jerseynum', 'team', 'teamcolor', 'total_played', 'player_played', 'played_prec', 'basic_stats', 'first_player_stat', 'first_comp_match_fixture', 'first_comp', 'team_follow', 'player_follow'));
    //             } else {
    //                 return view('frontend.dashboard', compact('is_player', 'is_team_admin', 'is_comp_admin', 'comp_follow', 'get_competitions', 'player_stats', 'first_comp_match_fixture', 'first_comp', 'team_follow', 'player_follow'));
    //             }
    //         } else {
    //             return view('frontend.dashboard', compact('is_player', 'is_team_admin', 'is_comp_admin', 'comp_follow', 'get_competitions', 'first_comp', 'first_comp_match_fixture', 'team_follow', 'player_follow'));
    //         }
    //     } else {
    //         if ($is_player > 0) {
    //             $player_stats = Match_fixture_stat::where('player_id', Auth::user()->id)->latest()->get();
    //             $first_player_stat = Match_fixture_stat::where('player_id', Auth::user()->id)->latest()->first();
    //             if (!empty($first_player_stat)) {
    //                 $team_id = $first_player_stat->team_id;
    //                 $next_fixture = Match_fixture::where(function ($query) use ($team_id) {
    //                     $query->where('teamOne_id', '=', $team_id)
    //                         ->orWhere('teamTwo_id', '=', $team_id);
    //                 })->where('startdate_time', Null)->latest()->first();

    //                 if (!empty($next_fixture)) {
    //                     if ($next_fixture->teamOne_id == $first_player_stat->team_id) {
    //                         $next_match_opp_team = Team::find($next_fixture->teamTwo_id);
    //                     } else {
    //                         $next_match_opp_team = Team::find($next_fixture->teamOne_id);
    //                     }
    //                     $next_fixture_date = strtoupper(date('d M Y', strtotime($next_fixture->fixture_date)));

    //                     $next_match = "";
    //                 } else {
    //                     $next_match_opp_team = "";
    //                     $next_fixture_date = "N/A";
    //                 }
    //                 $team = Team::find($first_player_stat->team_id);
    //                 $teamcolor = $team->team_color;
    //                 $contract_jerseynum = Team_member::with('member_position')->where('team_id', $team->id)->where('member_id', Auth::user()->id)->first();
    //                 $total_played = Match_fixture::select('id')->where(function ($query) use ($team_id) {
    //                     $query->where('teamOne_id', '=', $team_id)
    //                         ->orWhere('teamTwo_id', '=', $team_id);
    //                 })->where('competition_id', $first_player_stat->competition_id)->where('finishdate_time', '!=', Null)->get();

    //                 $fixture_ids = array();
    //                 foreach ($total_played as $fixture) {
    //                     $fixture_ids[] = $fixture->id;
    //                 }
    //                 $player_played = Fixture_squad::whereIn('match_fixture_id', $fixture_ids)->where('team_id', $first_player_stat->team_id)->where('player_id', Auth::user()->id)->count();
    //                 if ($total_played->count() > 0) {
    //                     $played_precs = ($player_played / $total_played->count()) * 100;
    //                     $played_prec = number_format($played_precs, 2);
    //                 } else {
    //                     $played_prec = "00.00";
    //                 }
    //                 $id = Auth::user()->id;
    //                 $basic_stats = Sport_stat::whereIn('id', [1, 2, 3, 5])->where('is_active', 1)->get();

    //                 return view('frontend.dashboard', compact('is_player', 'is_team_admin', 'is_comp_admin', 'comp_follow', 'get_competitions', 'player_stats', 'next_fixture_date', 'next_match_opp_team', 'contract_jerseynum', 'team', 'teamcolor', 'total_played', 'player_played', 'played_prec', 'basic_stats', 'first_player_stat', 'team_follow'));
    //             } else {
    //                 return view('frontend.dashboard', compact('is_player', 'is_team_admin', 'is_comp_admin', 'comp_follow', 'get_competitions', 'player_stats', 'team_follow'));
    //             }
    //         } else {
    //             return view('frontend.dashboard', compact('is_player', 'is_team_admin', 'is_comp_admin', 'comp_follow', 'get_competitions', 'team_follow'));
    //         }
    //     }
    // }

    public function get_comp_my_stat_pd(Request $request)
    {
        // return response()->json($request);
        $basic_stats = Sport_stat::whereIn('id', [1, 2, 3, 5])->where('is_active', 1)->get();
        $team_id = $request->team_id;
        $total_played = Match_fixture::select('id')->where(function ($query) use ($team_id) {
            $query->where('teamOne_id', '=', $team_id)
                ->orWhere('teamTwo_id', '=', $team_id);
        })->where('competition_id', $request->comp_id)->where('finishdate_time', '!=', Null)->get();

        $fixture_ids = array();
        foreach ($total_played as $fixture) {
            $fixture_ids[] = $fixture->id;
        }
        $player_played = Fixture_squad::whereIn('match_fixture_id', $fixture_ids)->where('team_id', $request->team_id)->where('player_id', Auth::user()->id)->count();
        if ($total_played->count() > 0) {
            $played_precs = ($player_played / $total_played->count()) * 100;
            $played_prec = number_format($played_precs, 2);
        } else {
            $played_prec = "00.00";
        }
?>
        <div class="col-md-1 width-7">
            <!-- Blank Div -->
        </div>
        <div class="text-center col-md-2 col-6 mobMrgRL">
            <div class="SpacingLine ">
                <div class="FiftyTwoPer">
                    <div class="PlayedStyle" id="my_played"><?php echo str_pad($total_played->count(), 2, "0", STR_PAD_LEFT); ?></div><strong class="Payed23" id="all_played"><?php echo str_pad($player_played, 2, "0", STR_PAD_LEFT); ?></strong><span class="PlayedUnderText" id="played_prec"> <?php echo $played_prec ?>%
                    </span>
                </div>
                <p class="Playedcolor">Played</p>
            </div>
        </div>
        <?php
        foreach ($basic_stats as $stat) {
            $team_stat = Match_fixture_stat::where('competition_id', $request->comp_id)->where('sport_stats_id', $stat->id)->where('team_id', $request->team_id)->count();

            $my_stat = Match_fixture_stat::where('competition_id', $request->comp_id)->where('sport_stats_id', $stat->id)->where('team_id', $request->team_id)->where('player_id', Auth::user()->id)->count();
            if ($team_stat > 0) {
                $stat_precs = ($my_stat / $team_stat) * 100;
                $stat_prec = number_format($stat_precs, 2);
            } else {
                $stat_prec = "00.00";
            }
        ?>

            <div class="text-center col-md-2 col-6 mobMrgRL">
                <div class="SpacingLine">
                    <div class="FiftyTwoPer">
                        <div class="PlayedStyle"><?php echo str_pad($team_stat, 2, "0", STR_PAD_LEFT); ?></div>
                        <strong class="Payed23"><?php echo str_pad($my_stat, 2, "0", STR_PAD_LEFT); ?></strong>
                        <span class="PlayedUnderText"> <span> <?php echo $stat_prec; ?> </span>% </span>
                    </div>
                    <p class="Playedcolor"><?php echo $stat->description; ?></p>
                </div>
            </div>
        <?php } ?>
        <div class="col-md-1 width-7">
        </div>

<?php
        // $competition_ids = Match_fixture_stat::where('team_id',$request->team_id)->where('player_id',Auth::user()->id)->pluck('competition_id');
        // $comp_ids = array_unique($competition_ids->toarray());
        // $competitions = Competition::whereIn('id',$comp_ids)->get();

        // if($request->comp_id == 0)
        // {
        // 	$comp_id = $comp_ids[0];
        // }
        // else
        // {
        // 	$comp_id = $request->comp_id;
        // }
        // $contract_jerseynum = Team_member::with('member_position')->where('team_id',$request->team_id)->where('member_id',Auth::user()->id)->first();
        // $m_position = $contract_jerseynum->member_position->name;
        // if($contract_jerseynum->jersey_number != NULL)
        // {
        // 	$j_num = str_pad($contract_jerseynum->jersey_number,2,"0", STR_PAD_LEFT);
        // }
        // else
        // {
        // 	$j_num = " ";
        // }
        // $team_id = $request->team_id;
        // $total_played = Match_fixture::select('id')->where(function ($query) use ($team_id) {
        // $query->where('teamOne_id', '=', $team_id)
        // ->orWhere('teamTwo_id', '=', $team_id);
        // })->where('competition_id',$comp_id)->where('finishdate_time','!=',Null)->get();
        // $fixture_ids = array();
        // foreach($total_played as $fixture)
        // {
        // 	$fixture_ids[] = $fixture->id;
        // }
        // $player_played = Fixture_squad::whereIn('match_fixture_id',$fixture_ids)->where('team_id',$team_id)->where('player_id',Auth::user()->id)->count();
        // if($total_played->count() > 0)
        // {
        // 	$played_precs = ($player_played / $total_played->count()) *100;
        // 	$played_prec = number_format($played_precs,2);
        // }
        // else
        // {
        // 	$played_prec = "00.00";
        // }

        // $all_stats = Sport_stat::where('stat_type_id',0)->where('must_track',1)->where('is_active',)->get();
        // $all_goals = Match_fixture_stat::where('competition_id',$comp_id)->where('sport_stats_id',1)->where('team_id',$request->team_id)->count();
        // $all_goal = str_pad($all_goals,2,"0", STR_PAD_LEFT);
        // $my_all_goals = Match_fixture_stat::where('competition_id',$comp_id)->where('sport_stats_id',1)->where('team_id',$request->team_id)->where('player_id',Auth::user()->id)->count();
        // $my_all_goal = str_pad($my_all_goals,2,"0", STR_PAD_LEFT);
        // if($all_goals > 0)
        // {
        // 	$goal_precs = ($my_all_goals / $all_goals) *100;
        // 	$goal_prec = number_format($goal_precs,2);
        // }
        // else
        // {
        // 	$goal_prec = "00.00";
        // }
        // $all_passess = Match_fixture_stat::where('competition_id',$comp_id)->where('sport_stats_id',5)->where('team_id',$request->team_id)->count();
        // $all_passes = str_pad($all_passess,2,"0", STR_PAD_LEFT);
        // $my_all_passess = Match_fixture_stat::where('competition_id',$comp_id)->where('sport_stats_id',5)->where('team_id',$request->team_id)->where('player_id',Auth::user()->id)->count();
        // $my_all_passes = str_pad($my_all_passess,2,"0", STR_PAD_LEFT);
        // if($all_passess > 0)
        // {
        // 	$passes_precs = ($my_all_passess / $all_passess) *100;
        // 	$passes_prec = number_format($passes_precs,2);
        // }
        // else
        // {
        // 	$passes_prec = "00.00";
        // }
        // $all_yellow_cards = Match_fixture_stat::where('competition_id',$comp_id)->where('team_id',$request->team_id)->where('sport_stats_id',2)->count();
        // $all_yellow_card = str_pad($all_yellow_cards,2,"0", STR_PAD_LEFT);
        // $my_yellow_cards = Match_fixture_stat::where('competition_id',$comp_id)->where('team_id',$request->team_id)->where('player_id',Auth::user()->id)->where('sport_stats_id',2)->count();
        // $my_yellow_card = str_pad($my_yellow_cards,2,"0", STR_PAD_LEFT);
        // if($all_yellow_cards > 0)
        // {
        // 	$yellow_card_precs = ($my_yellow_cards / $all_yellow_cards) *100;
        // 	$yellow_card_prec = number_format($yellow_card_precs,2);
        // }
        // else
        // {
        // 	$yellow_card_prec = "00.00";
        // }

        // $all_red_cards = Match_fixture_stat::where('competition_id',$comp_id)->where('team_id',$request->team_id)->where('sport_stats_id',3)->count();
        // $all_red_card = str_pad($all_red_cards,2,"0", STR_PAD_LEFT);
        // $my_red_cards = Match_fixture_stat::where('competition_id',$comp_id)->where('team_id',$request->team_id)->where('player_id',Auth::user()->id)->where('sport_stats_id',3)->count();
        // $my_red_card = str_pad($my_red_cards,2,"0", STR_PAD_LEFT);
        // if($all_red_cards > 0)
        // {
        // 	$red_card_precs = ($my_red_cards / $all_red_cards) *100;
        // 	$red_card_prec = number_format($red_card_precs,2);
        // }
        // else
        // {
        // 	$red_card_prec = "00.00";
        // }


        // return response()->json(['competitions' => $competitions,'j_num' => $j_num, 'all_goal' => $all_goal,'my_all_goal'=>$my_all_goal,'goal_prec'=>$goal_prec,'m_position'=>$m_position,'all_passes'=>$all_passes, 'my_all_passes'=>$my_all_passes,'passes_prec'=>$passes_prec,'all_yellow_card'=>$all_yellow_card,'my_yellow_card'=>$my_yellow_card,'yellow_card_prec'=>$yellow_card_prec, 'all_red_card'=>$all_red_card,'my_red_card'=>$my_red_card,'red_card_prec'=>$red_card_prec,'total_played'=>$total_played ,'player_played'=>$player_played, 'played_prec'=>$played_prec ]);
    }
    public function autosearch_player_name(Request $request)
    {

        // $data = User::select("id","first_name","last_name")
        // ->where("first_name","LIKE","%". $request->input('query')."%")
        // ->get();

        // return response()->json($data);

        $admin = [];
        // if($request->has('q')){
        //     $search = $request->q;
        //     $admin =User::select("id", "first_name as name")
        //     		->where('first_name', 'LIKE', "%$search%")
        //     		->get();
        // }

        $ufplayers = User_profile::where('profile_type_id', 2)
            ->groupBy('user_id')
            ->pluck('user_id');
        $ufplayers_array = $ufplayers->toArray();

        if ($request->has('q')) {
            $search = $request->q;
            $admin = User::select('users.id', 'users.first_name as name', 'users.last_name as l_name')
                // ->join('user_profiles','users.id','=','user_profiles.user_id')
                ->whereIn('id', $ufplayers_array)
                ->where('users.first_name', 'like', '%' . $search . '%')
                ->get();
        }

        return response()->json($admin);
    }
    public function team_comp_follow()
    {
        $team_follow = User_fav_follow::Where('user_id', Auth::user()->id)->where('is_type', 1)->where('is_follow', 1)->with('team')->limit(30)->orderBy('created_at', 'DESC')->get();
        $comp_follow = User_fav_follow::where('user_id', Auth::user()->id)->where('is_type', 2)->where('Is_follow', 1)->where('is_active', 1)->with('comp')->limit(30)->orderBy('created_at', 'DESC')->get();
        $player_follow = User_fav_follow::Where('user_id', Auth::user()->id)->where('is_type', 3)->where('is_follow', 1)->with('player', 'user')->whereHas("user", function ($subQuery) {
            $subQuery->where("profile_type_id", 2);
        })->limit(30)->orderBy('created_at', 'DESC')->get();
        return response()->json(['team_follow' => $team_follow, 'comp_follow' => $comp_follow, 'player_follow' => $player_follow]);
    }
    public function request_accept(Request $request)
    {
        $notification = Notification::find($request->noti_id);
        if ($notification->notify_module_id == 1) {
            $user_friend = User_friend::find($notification->type_id);
            $user_friend->request_status = 1;
            $user_friend->save();
        } elseif ($notification->notify_module_id == 2) {
            $team_member = Team_member::find($notification->type_id);
            $team_member->invitation_status = 1;
            $team_member->save();
            if ($team_member->member_id == Auth::user()->id) {
                $member_position = $team_member->member_position_id;
                $check_position = Member_position::find($member_position);
                if ($check_position->member_type == 2) {
                    $member_permission = new Member_permission();
                    $member_permission->permission_for = 1;
                    $member_permission->permission_id = $team_member->team_id;
                    $member_permission->member_id = $team_member->member_id;
                    $member_permission->member_position_id = $team_member->member_position_id;
                    $member_permission->save();
                }
            }
        }
        return response()->json($notification);
    }

    public function request_reject(Request $request)
    {
        $notification = Notification::find($request->noti_id);
        if ($notification->notify_module_id == 1) {
            $user_friend = User_friend::find($notification->type_id);
            $user_friend->request_status = 2;
            $user_friend->save();
        } elseif ($notification->notify_module_id == 2) {
            $team_member = Team_member::find($notification->type_id);
            $team_member->invitation_status = 2;
            $team_member->save();
        }
        return response()->json($notification);
    }

    public function request_remove(Request $request)
    {
        $notification = Notification::find($request->noti_id);
        $notification->is_active = 0;
        $notification->save();
        if ($notification->notify_module_id == 1) {
            $user_friend = User_friend::find($notification->type_id);
            $user_friend->request_status = 3;
            $user_friend->save();
        } elseif ($notification->notify_module_id == 2) {
            $team_member = Team_member::find($notification->type_id);
            $team_member->invitation_status = 3;
            $team_member->save();
        }
        return response()->json($notification);
    }
    public function attendee_team(Request $request)
    {
        // return response()->json($request);
        $attendee_team = Competition_attendee::with('team', 'competition')->where('competition_id', $request->competition_id)->where('attendee_id', $request->attendee_id)->get();
        return response()->json($attendee_team);
    }

    public function player_stats(Request $request)
    {
        // return response()->json($request);
        $my_stat = Match_fixture::where('competition_id', $request->competition_id)->where('teamOne_id', $request->team_id)->Orwhere('teamTwo_id', $request->team_id)->first();
        $jersey_num = Team_member::where('team_id', $request->team_id)->where('member_id', $request->attendee_id)->first('jersey_number');
        $fixture_squad = Fixture_squad::with('position')->where('match_fixture_id', $my_stat->id)->where('team_id', $request->team_id)->where('player_id', $request->attendee_id)->first('sport_ground_positions_id');
        $player_fixture_stat = Match_fixture_stat::where('match_fixture_id', $my_stat->id)->where('team_id', $request->team_id)->where('player_id', $request->attendee_id)->get();
        $team_fixture_stat = Match_fixture_stat::where('match_fixture_id', $my_stat->id)->where('team_id', $request->team_id)->get();
        return response()->json(['fixture_squad' => $fixture_squad, 'jersey_num' => $jersey_num, 'player_stat' => $player_fixture_stat, 'team_stat' => $team_fixture_stat]);
        // return response()->json($jersey_num);


    }

    public function top_performaer(Request $request)
    {
        $comp_match_fixture = Match_fixture::where('competition_id', $request->comp_id)->where('fixture_type', '!=', 9)->where('finishdate_time', '!=', NULL)->get();
        $matches_div = array();
        $top_performer = array();
        if ($comp_match_fixture->IsNotEmpty()) {
            $loop = 0;
            foreach ($comp_match_fixture as $fixture) {
                if ($fixture->winner_team_id == 0) {
                    $winner_team = Team::find($fixture->teamOne_id);
                    $winner_team_id = $fixture->teamOne_id;
                } else {
                    $winner_team = Team::find($fixture->winner_team_id);
                    $winner_team_id = $fixture->winner_team_id;
                }
                $winner_team_goal = Match_fixture_stat::where('match_fixture_id', $fixture->id)->where('team_id', $winner_team_id)->whereIn('sport_stats_id', [1, 54])->count();
                if ($fixture->teamOne_id == $winner_team_id) {
                    $opp_team = Team::find($fixture->teamTwo_id);
                    $opp_team_goal = Match_fixture_stat::where('match_fixture_id', $fixture->id)->where('team_id', $fixture->teamTwo_id)->whereIn('sport_stats_id', [1, 54])->count();
                } else {
                    $opp_team = Team::find($fixture->teamOne_id);
                    $opp_team_goal = Match_fixture_stat::where('match_fixture_id', $fixture->id)->where('team_id', $fixture->teamOne_id)->whereIn('sport_stats_id', [1, 54])->count();
                }
                $last_div = $comp_match_fixture->count() % 3;
                if ($last_div == 0) {
                    if (($loop == $comp_match_fixture->count() - 1) || ($loop == $comp_match_fixture->count() - 2) || ($loop == $comp_match_fixture->count() - 3)) {
                        $c = "bb-n";
                    } else {
                        $c = "";
                    }
                } elseif ($last_div == 1) {
                    if (($loop == $comp_match_fixture->count() - 1)) {
                        $c = "bb-n";
                    } else {
                        $c = "";
                    }
                } elseif ($last_div == 2) {
                    if (($loop == $comp_match_fixture->count() - 1) || ($loop == $comp_match_fixture->count() - 2)) {
                        $c = "bb-n";
                    } else {
                        $c = "";
                    }
                }


                $matches_div[] = '<div class="col-md-4 teams-box ' . $c . '">
												<p class="win">
												<a href="' . url('team') . '/' . $winner_team->id . '" target="_blank"><img class="icon-thumb rounded-circle img-fluid" src="' . url('frontend/logo') . '/' . $winner_team->team_logo . '" width="10%"></a>
												<a href="' . url('match-fixture') . '/' . $fixture->id . '" target="_blank" class="competion_selector">' . $winner_team->name . '
												<span class="score">' . $winner_team_goal . '</span>
												</p>
												<p>
												<a href="' . url('team') . '/' . $opp_team->id . '" target="_blank"><img class="icon-thumb rounded-circle img-fluid" src="' . url('frontend/logo') . '/' . $opp_team->team_logo . '" width="10%"></a>
												<a href="' . url('match-fixture') . '/' . $fixture->id . '" target="_blank" class="competion_selector">' . $opp_team->name . '<span
												class="score">' . $opp_team_goal . '</span>
												</p>
											</div>';
                $loop++;
            }

            $player_stats = Match_fixture_stat::where('competition_id', $request->comp_id)->where('sport_stats_id', 1)->get();
            $top_player_goal = $player_stats->groupBy('player_id');
            $playerids = array();
            foreach ($top_player_goal  as $top_player => $stat) {
                // $playerids[$stat->count()] = $top_player;
                $playerids[$top_player] = $stat->count();
            }
            // krsort($playerids);
            arsort($playerids);
            $stat_count_key = array_keys($playerids);

            if (count($stat_count_key) > 3) {
                $counter = 3;
            } else {
                $counter = count($stat_count_key);
            }
            for ($tp = 0; $tp < $counter; $tp++) {
                $playerid = $stat_count_key[$tp];
                $playergoal = $playerids[$playerid];

                // $playergoal = $stat_count_key[$tp];
                // $playerid = $playerids[$playergoal];
                $player = User::find($playerid);
                $sport_stat = Sport_stat::whereIn('stat_type_id', [0, 1])->whereIn('stat_type', [0, 1])->where('id', '!=', 1)->where('is_active', 1)->get();

                $comp_attend = Competition_attendee::where('attendee_id', $player->id)->get();
                $game_played = 0;
                foreach ($comp_attend as $comp) {
                    $team_id = $comp->team_id;
                    $check_fixtures = Match_fixture::where(function ($query) use ($team_id) {
                        $query->where('teamOne_id', '=', $team_id)
                            ->orWhere('teamTwo_id', '=', $team_id);
                    })->where('finishdate_time', '!=', NULL)->where('competition_id', $comp->Competition_id)->count();
                    if ($check_fixtures > 0) {
                        $game_played++;
                    }
                }
                $player_belong_team = Competition_attendee::where('Competition_id', $request->comp_id)->where('attendee_id', $playerid)->first();
                $team = Team::find($player_belong_team->team_id);

                $player_stat_count = array();
                foreach ($sport_stat as $stat) {
                    $stat_count = Match_fixture_stat::where('competition_id', $request->comp_id)->where("player_id", $player->id)->where("sport_stats_id", $stat->id)->get();
                    $player_stat_count[] = '<li>' . $stat_count->count() . ' ' . $stat->description;
                }
                $player_team = $team->id;
                $game_played = Match_fixture::select('id')->where(function ($query) use ($player_team) {
                    $query->where('teamOne_id', '=', $player_team)
                        ->orWhere('teamTwo_id', '=', $player_team);
                })->where('competition_id', $request->comp_id)->where('fixture_type', '!=', 9)->where('finishdate_time', '!=', Null)->get();
                $fixture_ids = array();
                foreach ($game_played as $fixture) {
                    $fixture_ids[] = $fixture->id;
                }
                $game_started = Fixture_squad::whereIn('match_fixture_id', $fixture_ids)->where('player_id', $player->id)->count();
                $cal_stat = ['<li>' . $game_played->count() . ' Games Played', '<li>' . $game_started . ' Games Started'];
                $array_merge = array_merge($cal_stat, $player_stat_count);

                $imploadallstate = implode('</li>', $array_merge);

                $top_performer[] = '

						<style>
						.performer-goal.green-bg-' . $team->id . ':after {
								background: ' . $team->team_color . ';
						}
						.performer-player-img.green-bg-' . $team->id . ':after {
								background: ' . $team->team_color . ';
						}
						</style>

						<div class="top-performer-box w-100 d-flex" >
							<div class="performer-goal green-bg-' . $team->id . ' position-relative col-md-3 pt-2 pe-4">
								<h2>' . $playergoal . '<span>Goals</span>
								</h2>
								<a href="' . url('team') . '/' . $team->id . '" class="ic-logo" target="_blank">
									<img class="rounded-circle" src="' . url('frontend/logo') . '/' . $team->team_logo . '">
								</a>
							</div>
							<div class="py-2 performer-detail col-md-5" style="background:' . $team->team_color . ' !important;">
								<div class="content-pos">
									<h5>
										<a href="' . url('player_profile') . '/' . $player->id . '" target="_blank">' . $player->first_name . ' ' . $player->last_name . '</a>
									</h5>
									<ul class="list-unstyled player_stat_count">
										' . $imploadallstate . '
									</ul>
								</div>
							</div>
							<div class="performer-player-img green-bg-' . $team->id . ' position-relative col-md-4 ">
								<div class="overflow-hidden w-100 br-right-0">
								<a href="' . url('player_profile') . '/' . $player->id . '" target="_blank"><img src="' . url('frontend/profile_pic') . '/' . $player->profile_pic . '" alt="player" class="img-fluid"> </a>
								</div>
							</div>
						</div>';
            }
        }
        return response()->json(['comp_id' => $request->comp_id, 'matches_div' => $matches_div, 'top_performer' => $top_performer]);
    }
    public function remove_p_boxes(Request $request)
    {
        $update_user = User::find(Auth::user()->id);
        if ($request->type == "player") {
            $update_user->p_box_player = 1;
        } elseif ($request->type == "team") {
            $update_user->p_box_team = 1;
        } elseif ($request->type == "comp") {
            $update_user->p_box_comp = 1;
        } else {
            $update_user->p_box_player = 0;
        }
        $update_user->save();
        return response()->json($update_user);
    }
    public function get_comp_logo(Request $request)
    {
        $competition = Competition::select('id', 'comp_logo')->find($request->comp_id);
        $comp_logo = url('frontend/logo') . '/' . $competition->comp_logo;
        $comp_link = url('competition') . '/' . $competition->id;
        return response()->json(['comp_logo' => $comp_logo, 'comp_link' => $comp_link]);
    }
}
