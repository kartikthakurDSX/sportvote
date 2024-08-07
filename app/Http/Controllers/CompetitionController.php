<?php

namespace App\Http\Controllers;

use App\Models\Comp_report_type;
use App\Models\Comp_rule_set;
use Illuminate\Http\Request;
use App\Models\Competition;
use App\Models\competition_type;
use App\Models\CompSubType;
use App\Models\Competition_attendee;
use App\Models\Team;
use App\Models\team_join;
use App\Models\Team_member;
use App\Models\User;
use App\Models\Notification;
use App\Models\Sport_level;
use App\Models\Sport_stat;
use App\Models\Member_position;
use App\Models\Role;
use App\Models\StatDecisionMaker;
use App\Models\Comp_member;
use App\Models\Competition_team_request;
use App\Models\User_profile;
use App\Models\StatTrack;
use App\Models\Match_fixture;
use App\Models\Fixture_squad;
use App\Models\Match_fixture_stat;
use App\Models\User_fav_follow;
use App\Models\voting;
use App\Models\Trophy_cabinet;
use Carbon\Carbon;
use App\Services\GitHub;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CompetitionController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        } else {
            $user_id = "";
        }
        $my_comp = Competition::where('user_id', $user_id)->where('comp_type_id', '!=', NULL)->where('is_active', '!=', 2)->with('sport', 'sport_comp', 'comptype', 'compsubtype')->orderby('id', 'DESC')->get();
        $my_draft_comp = Competition::where('user_id', $user_id)->where('is_active', 0)->with('sport')->latest()->get();
        $competition_request = Competition_team_request::where('user_id', 1)->with('competition', 'team')->get();
        // return $my_comp;
        $comp_follows_ids = User_fav_follow::where('is_type', 2)->where('user_id', $user_id)->where('Is_follow', 1)->where('is_active', 1)->pluck('type_id');
        $team_follows_ids = User_fav_follow::where('is_type', 1)->where('user_id', $user_id)->where('Is_follow', 1)->where('is_active', 1)->pluck('type_id');
        $player_follows_ids = User_fav_follow::where('is_type', 3)->where('user_id', $user_id)->where('Is_follow', 1)->where('is_active', 1)->pluck('type_id');
        $comp_follows_array = $comp_follows_ids->toArray();
        $team_follows_array = $team_follows_ids->toArray();
        $player_follows_array = $player_follows_ids->toArray();

        $comp_id_belongs_team = Competition_team_request::whereIn('team_id', $team_follows_array)->pluck('competition_id');
        $comp_belongs_team_array = array_unique($comp_id_belongs_team->toArray());
        $comp_id_belongs_player = Competition_attendee::whereIn('attendee_id', $player_follows_array)->pluck('Competition_id');
        $comp_belongs_player_array = array_unique($comp_id_belongs_player->toArray());

        $comp_follow = Competition::whereIn('id', $comp_follows_array)->with('sport', 'sport_comp', 'comptype', 'compsubtype')->orderby('id', 'DESC')->get();
        $team_follow = Competition::whereIn('id', $comp_belongs_team_array)->with('sport', 'sport_comp', 'comptype', 'compsubtype')->orderby('id', 'DESC')->get();
        $player_follow = Competition::whereIn('id', $comp_belongs_player_array)->with('sport', 'sport_comp', 'comptype', 'compsubtype')->orderby('id', 'DESC')->get();

        $all_comp = Competition::where('user_id', '!=', $user_id)->with('sport', 'sport_comp', 'comptype', 'compsubtype')->orderby('id', 'DESC')->get();

        // dd($competition_request);
        return view('frontend.competitions.index', compact('my_comp', 'competition_request', 'all_comp', 'my_draft_comp', 'comp_follow', 'team_follow', 'player_follow'));
    }
    public function participate_in()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        } else {
            $user_id = "";
        }

        $user_memberIn_comp = Comp_member::where('member_id', $user_id)->where('invitation_status', 1)->pluck('comp_id');
        $user_memberIn_comp_ids = $user_memberIn_comp->toArray();

        $comP_team_members = Competition_team_request::where('user_id', $user_id)->where('request_status', 1)->pluck('competition_id');
        $team_members_comP_ids = $comP_team_members->toArray();

        $adminInTeam = Team_member::where('member_id', Auth::user()->id)->where('member_position_id', 4)->where('invitation_status', 1)->pluck('team_id');
        $adminInTeam_ids = array_unique($adminInTeam->toArray());

        $teamsIn_comp = Competition_team_request::whereIn('team_id', $adminInTeam_ids)->where('request_status', 1)->pluck('competition_id');
        $team_member_comp = $teamsIn_comp->toArray();

        $player_parti_comps = Competition_attendee::where('attendee_id', $user_id)->pluck('Competition_id');
        $player_parti_comps_ids = $player_parti_comps->toArray();

        $comp_ids = array_unique(array_merge($user_memberIn_comp_ids, $team_members_comP_ids));
        $merge_team_member_comp = array_unique(array_merge($comp_ids, $team_member_comp));
        $user_participateComp_ids = array_unique(array_merge($merge_team_member_comp, $player_parti_comps_ids));

        arsort($user_participateComp_ids);
        $user_participateComp_data = Competition::whereIn('id', $user_participateComp_ids)->where('is_active', 1)->with('comp_fixture')->orderby('id', 'DESC')->get();

        $competition_request = Competition_team_request::where('user_id', $user_id)->with('competition', 'team', 'comp_fixture')->latest()->get();

        return view('frontend.competitions.participateIncomp', compact('competition_request', 'user_participateComp_data'));
    }

    public function all_competitions()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        } else {
            $user_id = "";
        }
        $all_comp = Competition::with('sport', 'sport_comp', 'comptype', 'compsubtype', 'comp_fixture')
            ->orderBy('id', 'DESC')
            ->paginate(20);

        return view('frontend.competitions.allCompetitions', compact('all_comp'));
    }

    public function follow_comp()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        } else {
            $user_id = "";
        }
        $comp_follows_ids = User_fav_follow::where('is_type', 2)->where('user_id', $user_id)->where('Is_follow', 1)->where('is_active', 1)->pluck('type_id');
        $comp_follows_array = $comp_follows_ids->toArray();
        $comp_follow = Competition::whereIn('id', $comp_follows_array)->with('sport', 'sport_comp', 'comptype', 'compsubtype', 'comp_fixture')->orderby('id', 'DESC')->get();
        $all_comp = Competition::where('user_id', '!=', $user_id)->with('sport', 'sport_comp', 'comptype', 'compsubtype')->orderby('id', 'DESC')->get();
        return view('frontend.competitions.followComp', compact('all_comp', 'comp_follow'));
    }

    public function my_competitions(Request $request)
    {
        $user_id = Auth::id();

        // Determine the page and limit based on the request or default values
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 100);

        // Retrieve paginated active competitions
        $my_comp = Competition::where('user_id', $user_id)
            ->whereNotNull('comp_type_id')
            ->where('is_active', '!=', 2)
            ->with('sport', 'sport_comp', 'comptype', 'compsubtype', 'comp_fixture')
            ->orderBy('id', 'DESC')
            ->paginate($perPage, ['*'], 'active_page', $page);

        // Retrieve paginated draft competitions
        $my_draft_comp = Competition::where('user_id', $user_id)
            ->where('is_active', 0)
            ->with('sport')
            ->latest()
            ->paginate($perPage, ['*'], 'draft_page', $page);

        return view('frontend.competitions.myCompetitions', compact('my_comp', 'my_draft_comp'));
    }

    public function create()
    {
        $com_type = competition_type::select('id', 'icon', 'name')->get();
        $com_report_type = Comp_report_type::where('sport_id', 1)->get();
        $teams = Team::select('id', 'name')->get();

        $current_step = 1;
        $competition_logo = "competitions-icon-128.png";
        $is_add_rule = 0;
        $league_table_markers = [6, 7, 8, 9, 11, 41, 50];
        $team_ranking_stats = Sport_stat::whereIn('id', $league_table_markers)->get();
        $team_stats = Sport_stat::where('stat_type_id', 0)->where('is_calculated', 0)->whereIn('stat_type', [0, 2])->where('is_active', 1)->orderBy('stat_type', 'ASC')->get();
        session(['createComp_id' => ""]);
        return view('frontend.competitions.create', compact('teams', 'team_stats', 'com_type', 'current_step', 'com_report_type', 'competition_logo', 'team_ranking_stats'));
    }

    public function store(Request $request)
    {
        $comp_name = $request->comp_name;
        $competition_id = $request->comp_id;
        $update_user = User::find(Auth::user()->id);
        $update_user->p_box_comp = 1;
        $update_user->save();
        if ($comp_name != null && $competition_id == null) {
            $competition = new Competition();
            $competition->user_id = Auth::user()->id;
            $competition->sport_id = 1;
            $competition->name = $comp_name;
            $competition->save();

            $comp_id = $competition->id;
            $is_add_rule = 1;
            if ($comp_id) {
                session(['createComp_id' => $comp_id]);
                return response()->json(['status' => 1, 'compe_id' => $comp_id, 'is_add_rule' => $is_add_rule]);
            } else {
                return response()->json(['status' => 0]);
            }
        } else {
            $competition = Competition::find($competition_id);
            $competition->name = $comp_name;
            $competition->save();
            $is_add_rule = 1;
            if ($competition) {
                session(['createComp_id' => $competition_id]);
                return response()->json(['status' => 1, 'compe_id' => $competition_id, 'is_add_rule' => $is_add_rule]);
            } else {
                return response()->json(['status' => 0]);
            }
        }
    }

    public function createComp(Request $request)
    {
        $competition_id = $request->comp_id;
        $comp_subType = $request->comp_sub_type_id;
        if ($comp_subType == "") {
            $sub_tupe = 1;
        } else {
            $sub_tupe = $comp_subType;
        }
        $competition = Competition::find($competition_id);
        if ($competition) {
            $competition->name = $request->comp_name;
            $competition->parent_id = $competition_id;
            $competition->comp_type_id = $request->comp_type_id;
            $competition->comp_subtype_id = $sub_tupe;
            $competition->location = $request->complocation;
            $competition->competition_half_time = $request->comp_half_time;
            $competition->description = $request->comp_desc;
            if ($request->comp_type_id == 1) {
                $competition->team_number = 2;
            } else {
                $competition->team_number = $request->select_team_number;
            }
            $competition->squad_players_num = $request->team_squad_player;
            $competition->lineup_players_num = $request->select_linup_player;
            $competition->report_type = $request->comp_report_type;
            $competition->vote_mins = $request->match_vote_min;
            $competition->start_datetime = $request->comp_start_datetime;
            $competition->is_active = 1;
            $competition->save();

            return response()->json(['status' => 2, 'compe_id' => $competition_id, "report_type" => $request->comp_report_type, "comp_type" => $request->comp_type_id,]);
        } else {
            return response()->json(['status' => 0]);
        }
    }

    public function save_competition(Request $request)
    {
        // return $request->all();
        //dd($this->comp_team_stat);
        $comp_id = $request->comp_id;
        $comp_type_id = $request->comp_type_id;
        $comp_team_stat = $request->comp_team_stat;
        $teamOne = $request->teamOne;
        $teamTwo = $request->teamTwo;
        $secondkeyranking = $request->secondkeyranking;
        $thirdkeyranking = $request->thirdkeyranking;
        $player_ranking = $request->player_ranking;

        if ($comp_id != "") {
            $StatTrackData = StatTrack::where('tracking_for', $comp_id)->count();
            if ($StatTrackData == 0) {
                if (count($comp_team_stat) > 0) {
                    if (count($comp_team_stat) > 0) {
                        $stat_ids = implode(',', $comp_team_stat);
                    }
                    $stat_tracking = new StatTrack();
                    $stat_tracking->tracking_type = 1;
                    $stat_tracking->tracking_for = $comp_id;
                    $stat_tracking->stat_type = 1;
                    $stat_tracking->stat_ids = $stat_ids;
                    $stat_tracking->is_active = 1;
                    $stat_tracking->save();
                }
            }
            $competition = Competition::find($comp_id);

            if ($comp_type_id == 1) {
                $check_team_num = Competition_team_request::where('competition_id', $competition->id)->whereNotIn('request_status', [2, 3])->count();
                if ($competition->team_number > $check_team_num) {
                    $team = Team::find($teamOne);
                    $comp_team_request = new Competition_team_request();
                    $comp_team_request->competition_id = $comp_id;
                    $comp_team_request->team_id = $teamOne;
                    $comp_team_request->user_id = $team->user_id;
                    $comp_team_request->save();

                    if ($team->user_id != Auth::user()->id) {
                        $notification = Notification::create([
                            'notify_module_id' => 3,
                            'type_id' => $comp_team_request->id,
                            'sender_id' => Auth::user()->id,
                            'reciver_id' => $team->user_id,
                        ]);
                    }

                    $team2 = Team::find($teamTwo);
                    $comp_team_request = new Competition_team_request();
                    $comp_team_request->competition_id = $comp_id;
                    $comp_team_request->team_id = $teamTwo;
                    $comp_team_request->user_id = $team2->user_id;
                    $comp_team_request->save();

                    if ($team2->user_id != Auth::user()->id) {
                        $notification = Notification::create([
                            'notify_module_id' => 3,
                            'type_id' => $comp_team_request->id,
                            'sender_id' => Auth::user()->id,
                            'reciver_id' => $team2->user_id,
                        ]);
                    }
                }
                return response()->json(['status' => 1, 'compe_id' => $comp_id]);
            } else {

                $stat_decision_makers = new StatDecisionMaker();
                $stat_decision_makers->decision_stat_for = 1;
                $stat_decision_makers->type_id = $comp_id;
                $stat_decision_makers->stat_type = 1;
                $stat_decision_makers->stat_id = 10;
                $stat_decision_makers->stat_order = 1;
                $stat_decision_makers->save();

                if ($secondkeyranking) {
                    $stat_decision_makers = new StatDecisionMaker();
                    $stat_decision_makers->decision_stat_for = 1;
                    $stat_decision_makers->type_id = $comp_id;
                    $stat_decision_makers->stat_type = 1;
                    $stat_decision_makers->stat_id = $secondkeyranking;
                    $stat_decision_makers->stat_order = 2;
                    $stat_decision_makers->save();
                }
                if ($thirdkeyranking) {
                    $stat_decision_makers = new StatDecisionMaker();
                    $stat_decision_makers->decision_stat_for = 1;
                    $stat_decision_makers->type_id = $comp_id;
                    $stat_decision_makers->stat_type = 1;
                    $stat_decision_makers->stat_id = $thirdkeyranking;
                    $stat_decision_makers->stat_order = 3;
                    $stat_decision_makers->save();
                }
                if ($player_ranking) {
                    $stat_decision_makers = new StatDecisionMaker();
                    $stat_decision_makers->decision_stat_for = 1;
                    $stat_decision_makers->type_id = $comp_id;
                    $stat_decision_makers->stat_type = 2;
                    $stat_decision_makers->stat_id = $player_ranking;
                    $stat_decision_makers->stat_order = 1;
                    $stat_decision_makers->save();
                }
                return response()->json(['status' => 1, 'compe_id' => $comp_id]);
            }
        }
    }

    public function show($id)
    {
        // Clear session data
        session(['createComp_id' => ""]);

        // Retrieve competition data
        $competition = Competition::with('user')
            ->where('is_active', '!=', 2)
            ->find($id);

        // Retrieve match fixtures for the competition
        // $match_fixtures = Match_fixture::where('competition_id', $competition->id)->get();
        $match_fixtures = Match_fixture::where('competition_id', $competition->id)
            ->orderBy('id', 'desc') // Replace 'column_name' with the actual column you want to order by
            ->get();
        // Calculate competition season
        if ($competition->comp_season_start && $competition->comp_season_end) {
            $cal_comp_season_start = date('M y', strtotime($competition->comp_season_start));
            $cal_comp_season_end = date('M y', strtotime($competition->comp_season_end));
            $comp_season = "$cal_comp_season_start - $cal_comp_season_end";
        } else {
            $comp_season = "SEP '23 - APR '24";
        }

        // Initialize arrays for fixture ids
        $fixture_ids = [];
        $finish_fixture_ids = [];
        foreach ($match_fixtures as $match_fixture) {
            $fixture_ids[] = $match_fixture->id;

            $finishdate_time = $match_fixture->finishdate_time;

            if ($finishdate_time !== null) {
                $match_fixture_finish_time = strtotime($finishdate_time);
                $cal_voting_time = $competition->vote_mins * 60;
                $voting_finish_time = $match_fixture_finish_time + $cal_voting_time;
                $cal_current_time = strtotime(now());

                if ($cal_current_time >= $voting_finish_time) {
                    $finish_fixture_ids[] = $match_fixture->id;

                    $Playervoting = voting::groupBy('player_id')
                        ->where('match_fixture_id', $match_fixture->id)
                        ->selectRaw('count(*) as total, player_id')
                        ->get();

                    $manoftheMatch_player_id = $Playervoting->toArray();

                    if ($Playervoting->count() > 0) {
                        $max_vote = max($manoftheMatch_player_id);
                        $mvp_player_id = $max_vote['player_id'];

                        $mvpPlayer_team_id = voting::where('match_fixture_id', $match_fixture->id)
                            ->where('player_id', $mvp_player_id)
                            ->where('status_desc', 0)
                            ->first();

                        $check_mvp_record = voting::where('match_fixture_id', $match_fixture->id)
                            ->where('status_desc', 1)
                            ->get();

                        if (count($check_mvp_record) === 0) {
                            $match_mvp_record = new voting();
                            $match_mvp_record->match_fixture_id = $match_fixture->id;
                            $match_mvp_record->team_id = $mvpPlayer_team_id->team_id;
                            $match_mvp_record->player_id = $mvp_player_id;
                            $match_mvp_record->status_desc = 1;
                            $match_mvp_record->save();
                        }
                    }
                }
            }
        }



        if ($competition->report_type == 1) {
            //Basic stats for team and player
            $sports_stat = Sport_stat::whereIn('stat_type_id', [0, 1])->where('is_active', 1)->where('stat_type', 1)->get();
            $team_stat = Sport_stat::whereIN('stat_type_id', [0, 2])->whereIn('stat_type', [0, 1])->where('is_active', 1)->get();
            $player_stat = Sport_stat::whereIn('stat_type_id', [0, 1])->whereIn('stat_type', [0, 1])->where('is_active', 1)->get();
        } else {
            //Detailed stats for team and player
            $detailed_stats = StatTrack::select('Stat_ids')->where('tracking_type', 1)->where('tracking_for', $id)->where('is_active', 1)->latest()->first();
            $stats_array = array();
            if (!empty($detailed_stats)) {
                $stats_array = explode(',', $detailed_stats->Stat_ids);
            } else {
                $stats_array = [1, 2, 3, 5, 47, 54];
            }

            $team_stat = Sport_stat::whereIn('id', $stats_array)->where('is_active', 1)->get();
            $sports_stat = Sport_stat::whereIn('stat_type_id', [1, 54])->where('is_active', 1)->get();
            // $player_stat = Sport_stat::whereIn('stat_type_id',[0,1])->where('is_active',1)->get();
            $player_stat = Sport_stat::whereIn('id', $stats_array)->where('is_active', 1)->get();
        }
        $mvp_winner_list = Fixture_squad::groupBy('player_id')->whereIn('match_fixture_id', $fixture_ids)->where('status_desc', 1)->selectRaw('count(*) as total, player_id')->get();
        // $recent_winner = $mvp_winner_list->toArray();

        $competition_fixture_list = voting::groupBy('player_id')->whereIn('match_fixture_id', $finish_fixture_ids)->where('status_desc', 1)->selectRaw('count(*) as total, player_id')->get();
        $recent_winner = $competition_fixture_list->toArray();
        // return $competition_fixture_list;
        $comp_teams = Competition_team_request::select('team_id')->where('competition_id', $id)->where('request_status', 1)->with('team:id,name,team_logo')->get();
        $comp_fixtures = Match_fixture::where('competition_id', $competition->id)->with('competition:id,name', 'teamOne:id,name,team_logo', 'teamTwo:id,name,team_logo')->get();
        $comp_teamOne = array();
        $comp_teamTwo = array();
        foreach ($comp_fixtures as $fixture) {
            $comp_teamOne[] = $fixture->teamOne_id;
            $comp_teamTwo[] = $fixture->teamTwo_id;
        }
        $comp_teamOne_ids = array_unique($comp_teamOne);
        $comp_teamTwo_ids = array_unique($comp_teamTwo);

        $team_ids = array();
        foreach ($comp_teams as $comp_ids) {
            $team_ids[] = $comp_ids->team_id;
        }
        $comp_admins = Comp_member::where('comp_id', $competition->id)->where('member_position_id', 7)->where('invitation_status', 1)->where('is_active', 1)->with('member')->pluck('member_id');
        $admins = $comp_admins->toArray();
        $total_goals = Match_fixture_stat::whereIn('match_fixture_id', $fixture_ids)->whereIn('stat_type', [1, 4])->where('is_active', 1)->whereIn('sport_stats_id', [1, 54])->get();
        $matches_played = Match_fixture::where('competition_id', $competition->id)->where('startdate_time', '!=', NULL)->where('finishdate_time', '!=', NULL)->count();
        if ($matches_played > 0) {
            $t_goal = $total_goals->count();
            $avg_goal = $t_goal / $matches_played;
        } else {
            $avg_goal = 0;
        }

        //return $recent_winner;
        if ($competition->comp_type_id == 2) {
            $total_fixture = Match_fixture::where('competition_id', $competition->id)->where('fixture_type', '!=', 9)->count();
            $matches_played = Match_fixture::where('competition_id', $competition->id)->where('startdate_time', '!=', NULL)->where('finishdate_time', '!=', NULL)->count();
            $first_sports_stat = Sport_stat::whereIn('stat_type_id', [0, 1, 2])->where('calc_type', 1)->where('is_active', 1)->first();
            $team_goals = Match_fixture_stat::where('competition_id', $competition->id)->where('sport_stats_id', $first_sports_stat->id)->get();
            $top_team_goal = $team_goals->groupBy('team_id');
            $top_player_goal = $team_goals->groupBy('player_id');
            //dd('knock out');
            return view('frontend.competitions.ko_competition', compact('competition', 'comp_season', 'total_fixture', 'matches_played', 'total_goals', 'top_team_goal', 'top_player_goal', 'recent_winner', 'avg_goal', 'fixture_ids', 'team_stat'));
        } elseif ($competition->comp_type_id == 3) {
            if ($competition->team_number % 2 == 0) {
                //Even Team
                $team_type = "Even";
                $total_rounds = $competition->team_number - 1;
                $round_fixtures = $competition->team_number / 2;
            } else {
                //Odd Team
                $team_type = "Odd";
                $total_rounds = $competition->team_number;
                $round_fixtures = (int) ($competition->team_number / 2);
            }

            $accepted_comp_team = Competition_team_request::where('competition_id', $competition->id)->where('request_status', 1)->count();
            //Quick compare graph
            $first_fixtures = Match_fixture::where('competition_id', $competition->id)->where('finishdate_time', '!=', null)->with('competition:id,name', 'teamOne:id,name,team_logo,team_color', 'teamTwo:id,name,team_logo,team_color')->first();

            if (!empty($first_fixtures)) {
                $firstL_won = Match_fixture::where('competition_id', $competition->id)
                    ->where('winner_team_id', $first_fixtures->teamOne->id)
                    ->count();
                $firstR_won = Match_fixture::where('competition_id', $competition->id)
                    ->where('winner_team_id', $first_fixtures->teamTwo->id)
                    ->count();
                $firstL_team_rank = Competition_team_request::select('rank')
                    ->where('competition_id', $competition->id)
                    ->where('team_id', $first_fixtures->teamOne->id)
                    ->first();
                $firstR_team_rank = Competition_team_request::select('rank')
                    ->where('competition_id', $competition->id)
                    ->where('team_id', $first_fixtures->teamTwo->id)
                    ->first();

                $fL_team_id = $first_fixtures->teamOne->id;
                $firstL_played = Match_fixture::where(function ($query) use ($fL_team_id) {
                    $query->where('teamOne_id', '=', $fL_team_id)
                        ->orWhere('teamTwo_id', '=', $fL_team_id);
                })->where('competition_id', $competition->id)
                    ->where('finishdate_time', '!=', null)
                    ->orderBy('finishdate_time', 'DESC')
                    ->get();

                $fR_team_id = $first_fixtures->teamTwo->id;
                $firstL_draw = Match_fixture::where(function ($query) use ($fL_team_id) {
                    $query->where('teamOne_id', '=', $fL_team_id)
                        ->orWhere('teamTwo_id', '=', $fL_team_id);
                })->where('competition_id', $competition->id)
                    ->where('fixture_type', 1)
                    ->count();

                $firstL_lost = Match_fixture::where(function ($query) use ($fL_team_id) {
                    $query->where('teamOne_id', '=', $fL_team_id)
                        ->orWhere('teamTwo_id', '=', $fL_team_id);
                })->where('competition_id', $competition->id)
                    ->where('winner_team_id', '!=', $fL_team_id)
                    ->count();
                $firstL_win_points = $firstL_won * 3;
                $firstL_draw_points = $firstL_draw * 1;
                $firstL_team_points = $firstL_win_points + $firstL_draw_points;

                $firstR_played = Match_fixture::where(function ($query) use ($fR_team_id) {
                    $query->where('teamOne_id', '=', $fR_team_id)
                        ->orWhere('teamTwo_id', '=', $fR_team_id);
                })->where('competition_id', $competition->id)
                    ->where('finishdate_time', '!=', null)
                    ->orderBy('finishdate_time', 'DESC')
                    ->get();

                $firstR_draw = Match_fixture::where(function ($query) use ($fR_team_id) {
                    $query->where('teamOne_id', '=', $fR_team_id)
                        ->orWhere('teamTwo_id', '=', $fR_team_id);
                })->where('competition_id', $competition->id)
                    ->where('fixture_type', 1)
                    ->count();
                $firstR_lost = Match_fixture::where(function ($query) use ($fR_team_id) {
                    $query->where('teamOne_id', '=', $fR_team_id)
                        ->orWhere('teamTwo_id', '=', $fR_team_id);
                })->where('competition_id', $competition->id)
                    ->where('winner_team_id', '!=', $fR_team_id)
                    ->count();
                $firstR_win_points = $firstR_won * 3;
                $firstR_draw_points = $firstR_draw * 1;
                $firstR_team_points = $firstR_win_points + $firstR_draw_points;

                $firstL_yellowcards = Match_fixture_stat::where('competition_id', $competition->id)
                    ->where('team_id', $fL_team_id)
                    ->where('sport_stats_id', 2)
                    ->count();
                $firstR_yellowcards = Match_fixture_stat::where('competition_id', $competition->id)
                    ->where('team_id', $fR_team_id)
                    ->where('sport_stats_id', 2)
                    ->count();
                $firstL_redcards = Match_fixture_stat::where('competition_id', $competition->id)
                    ->where('team_id', $fL_team_id)
                    ->where('sport_stats_id', 3)
                    ->count();
                $firstR_redcards = Match_fixture_stat::where('competition_id', $competition->id)
                    ->where('team_id', $fR_team_id)
                    ->where('sport_stats_id', 3)
                    ->count();
                $firstL_goal_for = Match_fixture_stat::where('competition_id', $competition->id)
                    ->where('team_id', $fL_team_id)
                    ->whereIn('sport_stats_id', [1, 54])
                    ->count();
                $firstR_goal_for = Match_fixture_stat::where('competition_id', $competition->id)
                    ->where('team_id', $fR_team_id)
                    ->whereIn('sport_stats_id', [1, 54])
                    ->count();

                $againts_firstL_team = Match_fixture::where(function ($query) use ($fL_team_id) {
                    $query->where('teamOne_id', '=', $fL_team_id)
                        ->orWhere('teamTwo_id', '=', $fL_team_id);
                })->where('competition_id', $competition->id)
                    ->where('finishdate_time', '!=', null)
                    ->get();
                $firstL_againts_goals = 0;

                foreach ($againts_firstL_team as $a_team) {
                    if ($a_team->teamOne_id == $fL_team_id) {
                        $goal_a = Match_fixture_stat::where('competition_id', $competition->id)
                            ->where('team_id', $a_team->teamTwo_id)
                            ->where('match_fixture_id', $a_team->id)
                            ->whereIn('sport_stats_id', [1, 54])
                            ->where('is_active', 1)
                            ->count();
                        $firstL_againts_goals = $firstL_againts_goals + $goal_a;
                    } else {
                        $goal_a = Match_fixture_stat::where('competition_id', $competition->id)
                            ->where('team_id', $a_team->teamOne_id)
                            ->where('match_fixture_id', $a_team->id)
                            ->whereIn('sport_stats_id', [1, 54])
                            ->where('is_active', 1)
                            ->count();
                        $firstL_againts_goals = $firstL_againts_goals + $goal_a;
                    }
                }

                $firstL_goal_differ = $firstL_goal_for - $firstL_againts_goals;
                $firstL_goal_differ = $firstL_goal_for - $firstL_againts_goals;

                $againts_firstR_team = Match_fixture::where(function ($query) use ($fR_team_id) {
                    $query->where('teamOne_id', '=', $fR_team_id)
                        ->orWhere('teamTwo_id', '=', $fR_team_id);
                })->where('competition_id', $competition->id)->where('finishdate_time', '!=', Null)->get();
                $firstR_againts_goals = 0;
                // dd($againts_team);
                foreach ($againts_firstR_team as $a_team) {
                    if ($a_team->teamOne_id == $fR_team_id) {
                        // $a_team_ids[] = $a_team->teamTwo_id;
                        $goal_a = Match_fixture_stat::where('competition_id', $competition->id)->where('team_id', $a_team->teamTwo_id)->where('match_fixture_id', $a_team->id)->whereIn('sport_stats_id', [1, 54])->where('is_active', 1)->count();
                        $firstR_againts_goals = $firstR_againts_goals + $goal_a;
                    } else {
                        $goal_a = Match_fixture_stat::where('competition_id', $competition->id)->where('team_id', $a_team->teamOne_id)->where('match_fixture_id', $a_team->id)->whereIn('sport_stats_id', [1, 54])->where('is_active', 1)->count();
                        $firstR_againts_goals = $firstR_againts_goals + $goal_a;
                    }
                }
                $firstR_goal_differ = $firstR_goal_for - $firstR_againts_goals;
                return view('frontend.competitions.leage_competition', compact('competition', 'comp_season', 'total_rounds', 'team_type', 'round_fixtures', 'comp_teams', 'admins', 'accepted_comp_team', 'team_stat', 'player_stat', 'recent_winner', 'fixture_ids', 'first_fixtures', 'firstL_team_points', 'firstR_team_points', 'firstL_played', 'firstR_played', 'firstL_yellowcards', 'firstR_yellowcards', 'firstL_redcards', 'firstR_redcards', 'firstL_won', 'firstR_won', 'firstL_draw', 'firstL_lost', 'firstR_draw', 'firstR_lost', 'firstL_goal_for', 'firstR_goal_for', 'firstR_againts_goals', 'firstR_goal_differ', 'firstL_againts_goals', 'firstL_goal_differ', 'team_ids', 'total_goals', 'avg_goal', 'firstL_team_rank', 'firstR_team_rank'));
            }
            return view('frontend.competitions.leage_competition', compact('competition', 'comp_season', 'total_rounds', 'team_type', 'round_fixtures', 'comp_teams', 'admins', 'accepted_comp_team', 'team_stat', 'player_stat', 'recent_winner', 'fixture_ids', 'first_fixtures', 'total_goals', 'avg_goal'));
        } elseif ($competition->comp_type_id == 1) {
            //dd('one of Game');
            return view('frontend.competitions.view', compact('competition'));
        }
    }

    public function comp_type($id)
    {
        $comp_type = competition_type::find($id);
        $comp_type_name = $comp_type->name;
        $comp_sub_type = CompSubType::where('competition_type_id', $id)->get();
        // dd($this->comp_type_d);
        if ($id == 1) {
            $comp_type = false;
        } else {
            $comp_type = true;
        }
        $comp_type_id = $id;
    }

    public function send_request_compadmin(Request $request)
    {
        $comp_id = $request->comp_id;
        $member_id = $request->memberid;
        if ($comp_id) {
            if ($member_id) {
                for ($x = 0; $x < count($member_id); $x++) {
                    if ($member_id[$x] == Auth::user()->id) {
                        $invitation_status = '1';
                    } else {
                        $invitation_status = '0';
                    }

                    $checkmember = Comp_member::where('comp_id', $comp_id)->where('member_id', $member_id[$x])->get();
                    if (count($checkmember) == 0) {
                        $comp_request = new Comp_member();
                        $comp_request->user_id = Auth::user()->id;
                        $comp_request->comp_id = $comp_id;
                        $comp_request->member_id = $member_id[$x];
                        $comp_request->member_position_id = 7;
                        $comp_request->invitation_status = $invitation_status;
                        $comp_request->save();
                        $comp_member_id = $comp_request->id;

                        $notification = Notification::create([
                            'notify_module_id' => 4,
                            'type_id' => $comp_member_id,
                            'sender_id' => Auth::user()->id,
                            'reciver_id' => $member_id[$x],
                        ]);
                    }
                }
            }
        }
    }

    public function send_request_referee(Request $request)
    {
        $comp_id = $request->comp_id;
        $referee_id = $request->refreeid;
        if ($comp_id) {
            if ($referee_id) {
                for ($x = 0; $x < count($referee_id); $x++) {
                    if ($referee_id[$x] == Auth::user()->id) {
                        $invitation_status = '1';
                    } else {
                        $invitation_status = '0';
                    }

                    $checkmember = Comp_member::where('comp_id', $comp_id)->where('member_id', $referee_id[$x])->get();
                    $checkCompAdmin = Comp_member::where('comp_id', $comp_id)->where('member_id', $referee_id[$x])->where('member_position_id', 7)->first();

                    if (count($checkmember) == 0) {
                        $comp_request = new Comp_member();
                        $comp_request->user_id = Auth::user()->id;
                        $comp_request->comp_id = $comp_id;
                        $comp_request->member_id = $referee_id[$x];
                        $comp_request->member_position_id = 6;
                        $comp_request->invitation_status = $invitation_status;
                        $comp_request->save();
                        $comp_member_id = $comp_request->id;

                        $notifications = Notification::where('notify_module_id', 4)->where('type_id', $comp_member_id)->where('reciver_id', $referee_id[$x])->get();
                        if ($referee_id[$x] != Auth::user()->id && count($notifications) == 0) {
                            $notification = Notification::create([
                                'notify_module_id' => 4,
                                'type_id' => $comp_member_id,
                                'sender_id' => Auth::user()->id,
                                'reciver_id' => $referee_id[$x],
                            ]);
                        }
                    } else {
                        if (!empty($checkCompAdmin) && $referee_id[$x] == Auth::user()->id) {
                            $comp_request = new Comp_member();
                            $comp_request->user_id = Auth::user()->id;
                            $comp_request->comp_id = $comp_id;
                            $comp_request->member_id = $referee_id[$x];
                            $comp_request->member_position_id = 6;
                            $comp_request->invitation_status = 1;
                            $comp_request->save();
                        }
                    }
                }
            }
        }
    }

    public function comp_top_fiveteam(Request $request)
    {
        if ($request->sport_id == 1) {
            $team_goals = Match_fixture_stat::where('competition_id', $request->comp_id)->whereIn('sport_stats_id', [$request->sport_id, 54])->get();
        } else {
            $team_goals = Match_fixture_stat::where('competition_id', $request->comp_id)->where('sport_stats_id', $request->sport_id)->get();
        }
        $data = 0;
        $winner_ids = array('NULL', 0);
        $recent_winner = Match_fixture::where('competition_id', $request->comp_id)->whereNotIn('winner_team_id', $winner_ids)->latest()->take(5)->get();
        if ($team_goals->IsNotEmpty()) {
            $data = 1;
            $top_team_goal = $team_goals->groupBy('team_id');
            //return response()->json(['data' => $data,'top_team_goal' => $top_team_goal,'top_player_goal' => $top_player_goal, 'recent_winner'=>$recent_winner]);

            foreach ($top_team_goal as $top_team => $stat) {
                $teamids[$top_team] = $stat->count();
            }
            arsort($teamids);
            $team_stat_count_key = array_keys($teamids);
            $top_teams_data = array();
            for ($tp = 0; $tp < count($team_stat_count_key); $tp++) {
                $teamid = $team_stat_count_key[$tp];
                $teamgoal = $teamids[$teamid];
                $team = Team::find($teamid);
                if ($tp < 5) {
                    $top_teams_data[] = '<li class="list-group-item d-flex justify-content-between align-items-start">
					<img class="img-fluid rounded-circle padd-RL" src="' . url('frontend/logo') . '/' . $team->team_logo . '"
					  width="25%">
					<div class="ms-2 me-auto EngCity">
						<div class=" ManCity">' . $team->name . '</div>
						 ' . $team->location . '
					</div>
				   <span class="badge">' . $teamgoal . '</span>
				</li>';
                }
            }

            return response()->json(['data' => $data, 'recent_winner' => $recent_winner, 'top_teams_data' => $top_teams_data]);
        } else {

            return response()->json(['data' => $data, 'recent_winner' => $recent_winner]);
        }
    }
    public function comp_top_fiveplayer(Request $request)
    {

        $player_goals = Match_fixture_stat::where('competition_id', $request->comp_id)->where('sport_stats_id', $request->sport_id)->get();
        $data = 0;
        $winner_ids = array('NULL', 0);
        $recent_winner = Match_fixture::where('competition_id', $request->comp_id)->whereNotIn('winner_team_id', $winner_ids)->latest()->take(5)->get();
        if ($player_goals->IsNotEmpty()) {
            $data = 1;
            $top_player_goal = $player_goals->groupBy('player_id');

            foreach ($top_player_goal as $top_player => $stat) {
                $playerids[$top_player] = $stat->count();
            }
            arsort($playerids);
            $player_stat_count_key = array_keys($playerids);
            $top_players_data = array();
            for ($tp = 0; $tp < count($player_stat_count_key); $tp++) {
                if ($tp < 5) {
                    $player_id = $player_stat_count_key[$tp];
                    $playergoal = $playerids[$player_id];
                    $player = User::select('id', 'first_name', 'last_name', 'profile_pic')->find($player_id);

                    $player_team_id = Match_fixture_stat::where('competition_id', $request->comp_id)->where('player_id', $player_id)->value('team_id');
                    $player_team = Team::select('name', 'id', 'team_color')->find($player_team_id);
                    $player_jersey_num = Team_member::where('team_id', $player_team_id)->where('member_id', $player_id)->value('jersey_number');

                    $top_players_data[] = '<li class="list-group-item d-flex justify-content-between align-items-start" title="' . $player->first_name . ' ' . $player->last_name . ' ' . $player_team->name . '">
						<style>
							.tpjersey' . $player_team->id . ':after {
								color:' . $player_team->team_color . ';
							}
						</style>
					   <span class="jersy-noTopFIve team-jersy-TopPlayer tpjersey' . $player_team->id . '">' . $player_jersey_num . '</span>
					   <img class="img-fluid rounded-circle padd-RL"
						   src="' . url('frontend/profile_pic') . '/' . $player->profile_pic . '" width="25%">
					   <div class="ms-2 me-auto EngCity">
						   <a href="' . url('player_profile/' . $player_id) . '" target="_blank">
							   <div class=" ManCity"  >
								   ' . $player->first_name . ' ' . $player->last_name . '
							   </div>
						   </a>
						   <a href="' . url('team/' . $player_team->id) . '" target="_blank">' . substr($player_team->name, 0, 13) . '</a>
					   </div>
					   <span class="badge">' . $playergoal . '</span>
				   </li>';
                }
            }

            return response()->json(['data' => $data, 'recent_winner' => $recent_winner, 'top_players_data' => $top_players_data]);
        } else {

            return response()->json(['data' => $data, 'recent_winner' => $recent_winner]);
        }
    }
    public function edit($id)
    {
        $competition = Competition::with('sport', 'comptype', 'compsubtype')->find($id);
        // return $competition;
        $admin = User::all();
        $com_type = competition_type::all();
        $sport_level = Sport_level::all();
        $player_stat = Sport_stat::where('stat_type_id', 1)->get();
        $team_stat = Sport_stat::where('stat_type_id', 2)->whereNotIn('id', [12, 13, 14])->get();
        $comp_admin = Member_position::where('member_type', 3)->get();
        $user = Role::where('name', 'user')->first()->users()->get();
        $comp_team_request = Competition_team_request::where('competition_id', $id)->get();
        $team_ranking_main = StatDecisionMaker::where('decision_stat_for', 2)->where('stat_order', 1)->where('type_id', $competition->id)->where('is_active', 1)->first();
        $team_ranking_second = StatDecisionMaker::where('decision_stat_for', 2)->where('stat_order', 2)->where('type_id', $competition->id)->where('is_active', 1)->first();
        $team_ranking_third = StatDecisionMaker::where('decision_stat_for', 2)->where('stat_order', 3)->where('type_id', $competition->id)->where('is_active', 1)->first();
        return view('frontend.competitions.edit', compact('competition', 'team_ranking_main', 'team_ranking_second', 'team_ranking_third', 'comp_team_request', 'admin', 'player_stat', 'team_stat', 'comp_admin', 'com_type', 'sport_level', 'user'));
    }


    public function update(Request $request, $id)
    {
        //
        //return $request->vote_mins;
        $competition = Competition::find($id);
        $competition->name = $request->name;
        $competition->description = $request->description;
        $competition->start_datetime = $request->start_datetime;
        $competition->end_datetime = $request->end_datetime;
        $competition->location = $request->location;
        $competition->report_type = $request->report_type;
        $competition->vote_mins = $request->vote_mins;
        $competition->sport_levels_id = $request->sport_level_id;

        $competition->save();
        if ($request->team_ranking_main != NULL) {
            $team_ranking_main = StatDecisionMaker::where('decision_stat_for', 2)->where('stat_order', 1)->where('type_id', $competition->id)->first();
            if (empty($team_ranking_main)) {
                $stat_decision_maker = new StatDecisionMaker();
                $stat_decision_maker->decision_stat_for = 2;
                $stat_decision_maker->type_id = $competition->id;
                $stat_decision_maker->stat_id = $request->team_ranking_main;
                $stat_decision_maker->stat_order = 1;
                $stat_decision_maker->save();
            } else {
                $stat_decision_maker = StatDecisionMaker::find($team_ranking_main->id);
                $stat_decision_maker->stat_id = $request->team_ranking_main;
                $stat_decision_maker->stat_order = 1;
                $stat_decision_maker->save();
            }

            $team_ranking_second = StatDecisionMaker::where('decision_stat_for', 2)->where('stat_order', 2)->where('type_id', $competition->id)->first();
            if (empty($team_ranking_second)) {
                $stat_decision_maker = new StatDecisionMaker();
                $stat_decision_maker->decision_stat_for = 2;
                $stat_decision_maker->type_id = $competition->id;
                $stat_decision_maker->stat_id = $request->team_ranking_second;
                $stat_decision_maker->stat_order = 2;
                $stat_decision_maker->save();
            } else {
                $stat_decision_maker = StatDecisionMaker::find($team_ranking_second->id);
                $stat_decision_maker->stat_id = $request->team_ranking_second;
                $stat_decision_maker->stat_order = 2;
                $stat_decision_maker->save();
            }

            $team_ranking_third = StatDecisionMaker::where('decision_stat_for', 2)->where('stat_order', 3)->where('type_id', $competition->id)->first();
            if (empty($team_ranking_third)) {
                $stat_decision_maker = new StatDecisionMaker();
                $stat_decision_maker->decision_stat_for = 2;
                $stat_decision_maker->type_id = $competition->id;
                $stat_decision_maker->stat_id = $request->team_ranking_third;
                $stat_decision_maker->stat_order = 3;
                $stat_decision_maker->save();
            } else {
                $stat_decision_maker = StatDecisionMaker::find($team_ranking_third->id);
                $stat_decision_maker->stat_id = $request->team_ranking_third;
                $stat_decision_maker->stat_order = 3;
                $stat_decision_maker->save();
            }
        }

        return redirect('competition');
    }


    public function destroy($id)
    {
        $block = Competition::find($id);
        $block->is_active = 2;
        $block->save();
        return redirect('competition');
    }

    public function mycompdestroy($id)
    {
        $comp = Competition::find($id);
        if ($comp) {
            $comp->is_active = 2;
            $comp->save();
            $comp_request_teams = Competition_team_request::where('competition_id', $id)->get();
            foreach ($comp_request_teams as $comp_request_team) {
                $request_team = Competition_team_request::find($comp_request_team->id);
                $request_team->request_status = 4;
                $request_team->save();
            }
            $Comp_members = Comp_member::where('comp_id', $id)->get();
            foreach ($Comp_members as $Comp_member) {
                $member = Comp_member::find($Comp_member->id);
                $member->is_active = 0;
                $member->save();
                $notifications = Notification::where('type_id', $Comp_member->id)->get();
                foreach ($notifications as $notification) {
                    $n = Notification::find($notification->id);
                    $n->is_active = 0;
                    $n->save();
                }
            }
            return back();
        }
    }

    public function comp_sub_type(Request $request)
    {
        $subtype = CompSubType::where('competition_type_id', $request->selectedValue)->get();
        return response()->json($subtype);
    }

    public function team_minmax(Request $request)
    {
        $teamminmax = CompSubType::find($request->subtypeID);
        $teammin = explode("-", $teamminmax->team_number);
        return response()->json($teammin);
    }

    public function search_team(Request $request)
    {
        $data = Team::where("id", $request->team_id)->first();
        if ($data) {
            return response()->json(["status" => 1, "data" => $data]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
    public function autosearch_team(Request $request)
    {

        $data = Team::select("id", "name", "team_logo")
            ->where("name", "LIKE", "%{$request->input('query')}%")
            ->get();

        return response()->json($data);
    }

    public function autosearch_comp(Request $request)
    {
        $data = Competition::select("id", "name")
            ->where("name", "LIKE", "%{$request->input('query')}%")
            ->get();

        return response()->json($data);
    }

    public function invitation(Request $request)
    {
        return response()->json($request);
    }

    public function competition_members(Request $request)
    {

        for ($x = 0; $x < count($request->memberid); $x++) {
            if ($request->memberid[$x] == Auth::user()->id) {
                $invitation_status = '1';
            } else {
                $invitation_status = '0';
            }
            $checkmember = Comp_member::where('comp_id', $request->competition_id)->where('member_id', $request->memberid[$x])->first();

            if (!($checkmember)) {
                $compmember = Comp_member::create([
                    'user_id' => Auth::user()->id,
                    'comp_id' => $request->competition_id,
                    'member_id' => $request->memberid[$x],
                    'member_position_id' => $request->memberpositionid,
                    'invitation_status' => $invitation_status,
                ]);
                $comp_member_id = $compmember->id;

                $notification = Notification::create([
                    'notify_module_id' => 4,
                    'type_id' => $comp_member_id,
                    'sender_id' => Auth::user()->id,
                    'reciver_id' => $request->memberid[$x],
                ]);
            } else {
                if ($checkmember->invitation_status == 3) {
                    if ($request->memberid[$x] == Auth::user()->id) {
                        $invitation_status = '1';
                    } else {
                        $invitation_status = '0';
                    }
                    $teammember = Comp_member::find($checkmember->id);
                    $teammember->invitation_status = $invitation_status;
                    $teammember->save();
                } else {
                    return response()->json('0');
                }
            }
        }
        $comp_member = Comp_member::where('comp_id', $request->competition_id)->with('competition', 'member', 'member_position')->get();
        return response()->json($comp_member);
    }

    public function remove_member(Request $request)
    {
        $comp_member_id = Comp_member::where('comp_id', $request->comp_id)->where('member_id', $request->noti_id)->value('id');
        $remove = Team_member::find($comp_member_id);
        $remove->delete();
        $remove_notification = Notification::where('type_id', $comp_member_id)->where('notify_module_id', 4)->value('id');
        $remove_noti = Notification::find($remove_notification);
        $remove_noti->delete();
        return response()->json('1');
    }

    public function send_comp_invitation(Request $request)
    {
        //    return response()->json($request);
        for ($x = 0; $x < count($request->team_id); $x++) {

            $team = Team::find($request->team_id[$x]);

            $comp_team_request = new Competition_team_request();
            $comp_team_request->competition_id = $request->competition_id;
            $comp_team_request->team_id = $request->team_id[$x];
            $comp_team_request->user_id = $team->user_id;
            $comp_team_request->save();

            $comp_team_request_id = $comp_team_request->id;
            $notification = Notification::create([
                'notify_module_id' => 3,
                'type_id' => $comp_team_request_id,
                'sender_id' => Auth::user()->id,
                'reciver_id' => $team->user_id,
            ]);
        }
        return response()->json('1');
    }

    public function send_comp_invitation1(Request $request)
    {
        //    return response()->json($request);


        $team = Team::find($request->team_id);
        $comp_team_check = Competition_team_request::where('competition_id', $request->competition_id)->where('team_id', $request->team_id)->get();
        if (empty($comp_team_check)) {
            $comp_team_request = new Competition_team_request();
            $comp_team_request->competition_id = $request->competition_id;
            $comp_team_request->team_id = $request->team_id;
            $comp_team_request->user_id = $team->user_id;
            $comp_team_request->save();

            $comp_team_request_id = $comp_team_request->id;
            $notification = Notification::create([
                'notify_module_id' => 3,
                'type_id' => $comp_team_request_id,
                'sender_id' => Auth::user()->id,
                'reciver_id' => $team->user_id,
            ]);

            return response()->json('1');
        } else {
            return response()->json('0');
        }
    }

    public function team_rank_determine(Request $request)
    {

        if ($request->team_2nd_rank) {
            $team_stat = Sport_stat::where('stat_type_id', 2)->where('id', '!=', $request->team_rank_id)->where('id', '!=', $request->team_2nd_rank)->get();
        } else {
            $team_stat = Sport_stat::where('stat_type_id', 2)->where('id', '!=', $request->team_rank_id)->get();
        }
        return response()->json($team_stat);
    }

    public function player_rank_determine(Request $request)
    {

        if ($request->player_2nd_rank) {
            $player_stat = Sport_stat::where('stat_type_id', 1)->where('id', '!=', $request->player_rank_id)->where('id', '!=', $request->player_2nd_rank)->get();
        } else {
            $player_stat = Sport_stat::where('stat_type_id', 1)->where('id', '!=', $request->player_rank_id)->get();
        }

        return response()->json($player_stat);
    }

    // crop image 123
    public function comp_logo_crop(Request $request)
    {
        $path = 'frontend/logo';
        $file = $request->file('file');
        $new_image_name = 'UIMG' . date('Ymd') . uniqid() . '.jpg';
        $upload = $file->move(public_path($path), $new_image_name);

        // return response()->json($request);
        $comp_logos = Competition::where('user_id', Auth::user()->id)->latest()->first();
        // return response()->json($comp_logos->id);
        $comp_logo = Competition::find($comp_logos->id);
        $comp_logo->comp_logo = $new_image_name;
        $comp_logo->save();
        $competition_logo = $comp_logo->comp_logo;

        if ($upload) {
            return response()->json(['status' => 1, 'msg' => $competition_logo, 'element' => $competition_logo]);
        } else {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong, try again later']);
        }
    }
    public function edit_comp_logo(Request $request, $id)
    {
        $path = 'frontend/logo';
        $file = $request->file('file');
        $new_image_name = 'UIMG' . date('Ymd') . uniqid() . '.jpg';
        $upload = $file->move(public_path($path), $new_image_name);

        // return response()->json($request);
        $comp_logos = Competition::find($id);
        // return response()->json($comp_logos->id);
        $comp_logo = Competition::find($comp_logos->id);
        $comp_logo->comp_logo = $new_image_name;
        $comp_logo->save();
        $competition_logo = $comp_logo->comp_logo;

        if ($upload) {
            return response()->json(['status' => 1, 'msg' => $competition_logo, 'element' => $competition_logo]);
        } else {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong, try again later']);
        }
    }
    public function edit_compbanner(Request $request, $id)
    {
        $path = 'frontend/banner';
        $file = $request->file('comp_banner');
        $new_image_name = 'UIMG' . date('Ymd') . uniqid() . '.jpg';
        $upload = $file->move(public_path($path), $new_image_name);

        // return response()->json($request);
        $comp_banner = Competition::find($id);
        $comp_banner->comp_banner = $new_image_name;
        $comp_banner->save();
        $competition_banner = $comp_banner->comp_banner;

        if ($upload) {
            return response()->json(['status' => 1, 'msg' => $competition_banner, 'element' => $competition_banner]);
        } else {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong, try again later']);
        }
    }
    // KO Competition Page
    public function ko_competition($id)
    {
        $competition = Competition::find($id);
        return view('frontend.competitions.ko_competition', compact('competition'));
    }
    public function autosearch_user(Request $request)
    {
        $admin = [];
        if ($request->has('q')) {
            $search = $request->q;

            $admin = User::select("id", "first_name as name", "last_name as l_name")
                ->where('first_name', 'LIKE', "$search%")
                ->get();
        }

        // if($request->has('q')){
        // $search = $request->q;
        // $admin = User::select('users.id','users.first_name as name','users.last_name')
        // ->join('user_profiles','users.id','=','user_profiles.user_id')
        // ->where('users.first_name', 'like' , '%'. $search .'%')
        // ->get();
        // }

        return response()->json($admin);
    }
    public function autosearch_userprofile(Request $request)
    {
        $admin = [];
        if ($request->has('q')) {
            $search = $request->q;

            $admin = User::select("id", "first_name as name", "last_name as l_name")
                ->where('first_name', 'LIKE', "$search%")
                ->get();
        }

        // if($request->has('q')){
        // $search = $request->q;
        // $admin = User::select('users.id','users.first_name as name','users.last_name')
        // ->join('user_profiles','users.id','=','user_profiles.user_id')
        // ->where('users.first_name', 'like' , '%'. $search .'%')
        // ->get();
        // }

        return response()->json($admin);
    }
    public function autosearch_refreeprofile(Request $request)
    {
        $admin = [];
        if ($request->has('q')) {
            $search = $request->q;

            $admin = User::select("id", "first_name as name", "last_name as l_name")
                ->where('first_name', 'LIKE', "$search%")
                ->get();
        }

        // if($request->has('q')){
        // $search = $request->q;
        // $admin = User::select('users.id','users.first_name as name','users.last_name')
        // ->join('user_profiles','users.id','=','user_profiles.user_id')
        // ->where('users.first_name', 'like' , '%'. $search .'%')
        // ->get();
        // }

        return response()->json($admin);
    }

    public function add_admins(Request $request)
    {
        for ($x = 0; $x < count($request->admins_ids); $x++) {
            $check_comp_member = Comp_member::where('comp_id', $request->comp_id)->where('member_id', $request->admins_ids[$x])->where('member_position_id', 7)->first();
            if (!empty($check_comp_member)) {
                if ($check_comp_member->invitation_status == 1) {
                } else {
                    $update_request = Comp_member::find($check_comp_member->id);
                    $update_request->invitation_status = 0;
                    $update_request->user_id = Auth::user()->id;
                    $update_request->save();

                    $notifications = Notification::where('notify_module_id', 4)->where('type_id', $update_request->id)->where('reciver_id', $request->admins_ids[$x])->get();
                    if (count($notifications) == 0) {
                        $notification = Notification::create([
                            'notify_module_id' => 4,
                            'type_id' => $update_request->id,
                            'sender_id' => Auth::user()->id,
                            'reciver_id' => $request->admins_ids[$x],
                        ]);
                    }
                }
            } else {
                if ($request->admins_ids[$x] != Auth::user()->id) {
                    $send_request = new Comp_member();
                    $send_request->user_id = Auth::user()->id;
                    $send_request->comp_id = $request->comp_id;
                    $send_request->member_id = $request->admins_ids[$x];
                    $send_request->member_position_id = 7;
                    $send_request->invitation_status = 0;
                    $send_request->save();

                    $notifications = Notification::where('notify_module_id', 4)->where('type_id', $send_request->id)->where('reciver_id', $request->admins_ids[$x])->get();
                    if (count($notifications) == 0) {
                        $notification = Notification::create([
                            'notify_module_id' => 4,
                            'type_id' => $send_request->id,
                            'sender_id' => Auth::user()->id,
                            'reciver_id' => $request->admins_ids[$x],
                        ]);
                    }
                }
            }
        }
        return response()->json();
    }
    public function add_referee(Request $request)
    {
        for ($x = 0; $x < count($request->admins_ids); $x++) {
            $check_comp_member = Comp_member::where('comp_id', $request->comp_id)->where('member_id', $request->admins_ids[$x])->where('member_position_id', 6)->get();
            if (count($check_comp_member) > 0) {
                if ($check_comp_member->invitation_status == 1) {
                } else {
                    $update_request = Comp_member::find($check_comp_member->id);
                    $update_request->invitation_status = 0;
                    $update_request->user_id = Auth::user()->id;
                    $update_request->save();

                    $notifications = Notification::where('notify_module_id', 4)->where('type_id', $update_request->id)->where('reciver_id', $request->admins_ids[$x])->get();
                    if (count($notifications) == 0) {
                        $notification = Notification::create([
                            'notify_module_id' => 4,
                            'type_id' => $update_request->id,
                            'sender_id' => Auth::user()->id,
                            'reciver_id' => $request->admins_ids[$x],
                        ]);
                    }
                }
            } else {
                if ($request->admins_ids[$x] != Auth::user()->id) {
                    $send_request = new Comp_member();
                    $send_request->user_id = Auth::user()->id;
                    $send_request->comp_id = $request->comp_id;
                    $send_request->member_id = $request->admins_ids[$x];
                    $send_request->member_position_id = 6;
                    $send_request->invitation_status = 0;
                    $send_request->save();

                    $notifications = Notification::where('notify_module_id', 4)->where('type_id', $send_request->id)->where('reciver_id', $request->admins_ids[$x])->get();
                    if (count($notifications) == 0) {
                        $notification = Notification::create([
                            'notify_module_id' => 4,
                            'type_id' => $send_request->id,
                            'sender_id' => Auth::user()->id,
                            'reciver_id' => $request->admins_ids[$x],
                        ]);
                    }
                } else {

                    $send_request = new Comp_member();
                    $send_request->user_id = Auth::user()->id;
                    $send_request->comp_id = $request->comp_id;
                    $send_request->member_id = $request->admins_ids[$x];
                    $send_request->member_position_id = 6;
                    $send_request->invitation_status = 1;
                    $send_request->save();
                }
            }
        }
        return response()->json();
    }
    // public function edit_compbanner(Request $request,$comp_id)
    // {


    // 	//return response($comp_id);
    // 	$imagePath = 'public/files';
    // 	$file = $request->file('comp_banner');
    // 	$upload = $request->comp_banner->store($imagePath);
    // 	$explodefile = explode('/', $upload);
    //         $imageName = end($explodefile);
    //     $comp_banner = Competition::find($comp_id);
    //     $comp_banner->comp_banner = $imageName;
    // 	$comp_banner->save();
    //     if($upload)
    //     {
    //             return response()->json(['status'=>1, 'msg'=>$comp_banner, 'element'=>$comp_banner]);
    //     }else{
    //         return response()->json(['status'=>0, 'msg'=>'Something went wrong, try again later']);
    //     }
    // }
    public function create_fixture(Request $request)
    {
        $comp_referee = Comp_member::select('id')->where('comp_id', $request->comp_id)->where('member_position_id', 6)->where('invitation_status', 1)->where('is_active', 1)->first();
        if (!empty($comp_referee)) {
            return response()->json(1);
        } else {
            return response()->json(0);
        }
    }
    public function save_comp_contact(Request $request)
    {
        $comp_info = Competition::find($request->comp_id);
        $comp_info->comp_email = $request->comp_email;
        $comp_info->comp_phone_number = $request->comp_phonenumber;
        $comp_info->comp_address = $request->comp_address;
        $comp_info->save();
        return response()->json($request);
    }
    public function top_players_sats_list(Request $request)
    {
        $team_goals = Match_fixture_stat::where('competition_id', $request->comp_id)->where('sport_stats_id', $request->statId)->get();
        $top_player_goal = $team_goals->groupBy('player_id');

        foreach ($top_player_goal as $top_player => $stat) {
            $players_stat[$top_player] = $stat->count();
        }
        arsort($players_stat);
        $player_data = array_chunk($players_stat, 5, true);

?>
        <div class="owlToper owl-carousel owl-theme owlTopPlayers">
            <?php
            foreach ($player_data as $data) {
            ?>
                <div class="item">
                    <?php
                    foreach ($data as $player_id => $player_goal) {
                        $player_info = User::select('id', 'first_name', 'last_name', 'profile_pic')->find($player_id);
                        $playerteam_id = Match_fixture_stat::where('competition_id', $request->comp_id)->where('player_id', $player_id)->value('team_id');
                        $playerteam = Team::select('name', 'id', 'team_color')->find($playerteam_id);
                        $player_jersey_num = Team_member::where('team_id', $playerteam_id)->where('member_id', $player_id)->value('jersey_number');
                    ?>
                        <div class=" W-100">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <style>
                                    .tpjersey<?php echo $playerteam->id; ?>:after {
                                        color: <?php echo $playerteam->team_color; ?>;
                                    }
                                </style>
                                <span class="jersy-noTopFIve team-jersy-TopPlayer tpjersey<?php echo $playerteam->id; ?>"> <?php echo $player_jersey_num; ?> </span>
                                <img class="img-fluid rounded-circle padd-RL" src="<?php echo url('frontend/profile_pic') ?>/<?php echo $player_info->profile_pic; ?>" style="width:25% !important;">
                                <div class="ms-2 me-auto EngCity">
                                    <div class=" ManCity">
                                        <a href="<?php url('player_profile/' . $player_id) ?>" target="_blank">
                                            <?php echo $player_info->first_name . ' ' . $player_info->last_name; ?> </a>
                                    </div>
                                    <a href="<?php echo url('team/' . $playerteam->id) ?>" target="_blank"> <?php echo $playerteam->name; ?> </a>
                                </div>
                                <span class="badge"> <?php echo $player_goal; ?></span>
                            </li>
                        </div>
                    <?php } ?>
                </div>

            <?php
            } ?>
        </div>
        <script src="{{url('frontend/js/owl.carousel.min.js')}}"></script>
        <script type="text/javascript">
            $('.owlTopPlayers').owlCarousel({
                loop: false,
                margin: 10,
                nav: false,
                // items: 1,
                responsive: {
                    0: {
                        items: 1
                    },
                    // 600: {
                    //     items: 3
                    // },
                    // 1000: {
                    //     items: 4
                    // }
                }
            })
        </script>
    <?php

    }
    public function top_teams_sats_list(Request $request)
    {
        $team_goals = Match_fixture_stat::where('competition_id', $request->comp_id)->where('sport_stats_id', $request->statId)->get();
        $top_team_goal = $team_goals->groupBy('team_id');

        foreach ($top_team_goal as $top_team => $stat) {
            $team_stat[$top_team] = $stat->count();
        }
        arsort($team_stat);
        $team_data = array_chunk($team_stat, 5, true);
    ?>
        <div class="owlToper owl-carousel owl-theme owlTopTeams">
            <?php
            foreach ($team_data as $data) {
            ?>
                <div class="item">
                    <?php
                    foreach ($data as $team_id => $team_stat) {
                    ?>
                        <?php $team_info = Team::select('id', 'name', 'location', 'team_logo')->find($team_id); ?>
                        <div class=" W-100">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <img class="img-fluid rounded-circle padd-RL" src="<?php echo url('frontend/logo') ?>/<?php echo $team_info->team_logo; ?>" style="width:25% !important;">
                                <div class="ms-2 me-auto EngCity">
                                    <div class=" ManCity"> <?php echo $team_info->name ?></div>
                                    <?php echo $team_info->location; ?>
                                </div>
                                <span class="badge"><?php echo $team_stat; ?></span>
                            </li>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            <?php
            }
            ?>
        </div>
        <?php
        ?>
        <script type="text/javascript">
            $('.owlTopTeams').owlCarousel({
                loop: false,
                margin: 10,
                nav: false,
                // items: 1,
                responsive: {
                    0: {
                        items: 1
                    },
                    // 600: {
                    //     items: 3
                    // },
                    // 1000: {
                    //     items: 4
                    // }
                }
            })
        </script>
        <?php
    }

    public function create_league_fixture(Request $request)
    {
        // return "create fixture";
        $competition = Competition::select('id', 'team_number', 'location', 'comp_subtype_id')->find($request->comp_id);
        // return $request;
        if ($competition->team_number % 2 == 0) {
            //Even Team
            $t_rounds = $competition->team_number - 1;
            $r_fixtures = $competition->team_number / 2;
        } else {
            //Odd Team
            $t_rounds = $competition->team_number;
            $r_fixtures = (int) ($competition->team_number / 2);
        }
        if ($competition->comp_subtype_id == 5) {
            $total_rounds = $t_rounds * 2;
            $round_fixtures = $r_fixtures;
        } elseif ($competition->comp_subtype_id == 6) {
            $total_rounds = $t_rounds * 3;
            $round_fixtures = $r_fixtures;
        } else {
            $total_rounds = $t_rounds;
            $round_fixtures = $r_fixtures;
        }
        $select_date_name = array();
        $select_TR_name = array();
        $select_TL_name = array();

        $fixture_teams_array = array();
        $fixture_dates = array();

        $all_collect_fixture = array();

        $collect_datalist = array();
        for ($x = 1; $x <= $total_rounds; $x++) {
            for ($i = 0; $i < $round_fixtures; $i++) {
                // For New Fixtures
                $date_var = "round" . $x . "_date_" . $i;
                $tl_var = "round" . $x . "_TL_" . $i;
                $tr_var = "round" . $x . "_TR_" . $i;

                if ($request[$tl_var] == "") {
                    return response()->json(['status' => 0, 'message' => 'Create All Rounds Fixtures']);
                }
                if ($request[$tr_var] == "") {
                    return response()->json(['status' => 0, 'message' => 'Create All Rounds Fixtures']);
                }

                $collect_datalist[$x . '-' . $i]['round_date'] = $request[$date_var];
                $collect_datalist[$x . '-' . $i]['round_tr'] = $request[$tr_var];
                $collect_datalist[$x . '-' . $i]['round_tl'] = $request[$tl_var];
                $collect_datalist[$x . '-' . $i]['round'] = $x;

                $fixture_teams = $request[$tl_var] . 'vs' . $request[$tr_var];
                array_push($fixture_teams_array, $fixture_teams);
                array_push($fixture_dates, $request[$date_var]);

                $collect_fixture = array('round' => $x, 'team' => $fixture_teams);
                array_push($all_collect_fixture, $collect_fixture);
            }
        }

        foreach ($fixture_dates as $k => $v) {
            if ($v == '') {
                return response()->json(['status' => 0, 'message' => 'Select Date And Time for All Rounds Fixtures']);
            }
        }

        $array_count = array_count_values($fixture_teams_array);
        foreach ($array_count as $key => $value) {
            if ($competition->comp_subtype_id == 4) {
                if ($key == 'vs') {
                    return response()->json(['status' => 0, 'message' => 'Create All Rounds Fixtures']);
                }
                // else{
                // 	if($value > 1){
                // 		$results = array_keys(array_filter(array_count_values(array_column($all_collect_fixture, 'team')), static function($count) { return $count > 1; }));
                // 		$rounds = array();
                // 		foreach ($all_collect_fixture as $v) {
                // 			foreach ($results as $value) {
                // 				if($value == $v['team']){
                // 					if(!in_array($v['round'], $rounds)){
                // 						$rounds[] = $v['round'];
                // 					}
                // 				}
                // 			}
                // 		}
                // 		return response()->json(['status'=>0, 'message'=>'Same fixtures are created in rounds '.implode(', ', $rounds)]);
                // 	}
                // }
            }
            if ($competition->comp_subtype_id == 5) {
                if ($key == 'vs') {
                    return response()->json(['status' => 0, 'message' => 'Create All Rounds Fixtures']);
                }
                // else{
                // 	if($value > 2){
                // 		$results = array_keys(array_filter(array_count_values(array_column($all_collect_fixture, 'team')), static function($count) { return $count > 2; }));
                // 		$rounds = array();
                // 		foreach ($all_collect_fixture as $v) {
                // 			foreach ($results as $value) {
                // 				if($value == $v['team']){
                // 					if(!in_array($v['round'], $rounds)){
                // 						$rounds[] = $v['round'];
                // 					}
                // 				}
                // 			}
                // 		}
                // 		return response()->json(['status'=>0, 'message'=>'Same fixtures are created more than 2 times in rounds '.$rounds]);
                // 	}
                // }
            }
            if ($competition->comp_subtype_id == 6) {
                if ($key == 'vs') {
                    return response()->json(['status' => 0, 'message' => 'Create All Rounds Fixtures']);
                }
                // else{
                // 	if($value > 3){
                // 		$results = array_keys(array_filter(array_count_values(array_column($all_collect_fixture, 'team')), static function($count) { return $count > 3; }));
                // 		$rounds = array();
                // 		foreach ($all_collect_fixture as $v) {
                // 			foreach ($results as $value) {
                // 				if($value == $v['team']){
                // 					if(!in_array($v['round'], $rounds)){
                // 						$rounds[] = $v['round'];
                // 					}
                // 				}
                // 			}
                // 		}
                // 		return response()->json(['status'=>0, 'message'=>'Same fixtures are created more than 3 times in rounds '.$rounds]);
                // 	}
                // }
            }
        }

        // return $array_count;
        $comp_referee = Comp_member::select('member_id')->where('comp_id', $request->comp_id)->where('member_position_id', 6)->where('invitation_status', 1)->where('is_active', 1)->first();

        // Insersion for New Fixtures
        foreach ($collect_datalist as $y => $cdata) {
            if ((!empty($collect_datalist[$y]['round_date'])) && (!empty($collect_datalist[$y]['round_tr']) && $collect_datalist[$y]['round_tr'] != "Select Team") && (!empty($collect_datalist[$y]['round_tl']) && $collect_datalist[$y]['round_tl'] != "Select Team")) {
                $match_fixture = new match_fixture();
                $match_fixture->competition_id = $request->comp_id;
                $match_fixture->teamOne_id = $cdata['round_tl'];
                $match_fixture->teamTwo_id = $cdata['round_tr'];
                $match_fixture->fixture_date = $cdata['round_date'];
                $match_fixture->fixture_type = 0;
                $match_fixture->fixture_round = $cdata['round'];
                // $match_fixture->refree_id = $comp_referee->member_id;
                $match_fixture->venue = "comp";
                $match_fixture->location = $competition->location;
                $match_fixture->save();
            } else {

                // for validation
            }
        }

        return response()->json(['status' => 1, 'message' => 'All Rounds Fixtures are created']);
    }

    public function edit_league_fixture(Request $request)
    {
        // return "create fixture";
        $competition = Competition::select('id', 'team_number', 'location', 'comp_subtype_id')->find($request->comp_id);
        // return $request;
        if ($competition->team_number % 2 == 0) {
            //Even Team
            $t_rounds = $competition->team_number - 1;
            $r_fixtures = $competition->team_number / 2;
        } else {
            //Odd Team
            $t_rounds = $competition->team_number;
            $r_fixtures = (int) ($competition->team_number / 2);
        }

        if ($competition->comp_subtype_id == 5) {
            $total_rounds = $t_rounds * 2;
            $round_fixtures = $r_fixtures;
        } elseif ($competition->comp_subtype_id == 6) {
            $total_rounds = $t_rounds * 3;
            $round_fixtures = $r_fixtures;
        } else {
            $total_rounds = $t_rounds;
            $round_fixtures = $r_fixtures;
        }
        $select_date_name = array();
        $select_TR_name = array();
        $select_TL_name = array();

        $editfixture_dates = array();
        $editfixture_teams_array = array();
        $all_collect_fixture = array();

        $collect_datalist = array();
        $updatedcollect_datalist = array();
        for ($x = 1; $x <= $total_rounds; $x++) {
            for ($i = 0; $i < $round_fixtures; $i++) {

                //For Updated Fixtures
                $update_date_var = "updateround" . $x . "_date_" . $i;
                $update_tl_var = "updateround" . $x . "_TL_" . $i;
                $update_tr_var = "updateround" . $x . "_TR_" . $i;
                $update_fixtureid = "updateround" . $x . "_fixid_" . $i;

                if ($request[$update_tl_var] == "") {
                    return response()->json(['status' => 0, 'message' => 'Create All Rounds Fixtures']);
                }
                if ($request[$update_tr_var] == "") {
                    return response()->json(['status' => 0, 'message' => 'Create All Rounds Fixtures']);
                }

                $updatedcollect_datalist[$x . '-' . $i]['round_date'] = $request[$update_date_var];
                $updatedcollect_datalist[$x . '-' . $i]['round_tr'] = $request[$update_tr_var];
                $updatedcollect_datalist[$x . '-' . $i]['round_tl'] = $request[$update_tl_var];
                $updatedcollect_datalist[$x . '-' . $i]['round_fixid'] = $request[$update_fixtureid];
                $updatedcollect_datalist[$x . '-' . $i]['round'] = $x;

                $edit_fixture_teams = $request[$update_tl_var] . 'vs' . $request[$update_tr_var];
                array_push($editfixture_teams_array, $edit_fixture_teams);
                array_push($editfixture_dates, $request[$update_date_var]);

                $collect_fixture = array('round' => $x, 'team' => $edit_fixture_teams);
                array_push($all_collect_fixture, $collect_fixture);
            }
        }

        foreach ($editfixture_dates as $k => $v) {
            if ($v == '') {
                return response()->json(['status' => 0, 'message' => 'Select Date And Time for All Rounds Fixtures']);
            }
        }

        $editarray_count = array_count_values($editfixture_teams_array);
        // return $editarray_count;
        foreach ($editarray_count as $key => $value) {
            if ($competition->comp_subtype_id == 4) {
                if ($key == 'vs') {
                    return response()->json(['status' => 0, 'message' => 'Create All Rounds Fixtures']);
                }
                // else{
                // 	if($value > 1){
                // 		$results = array_keys(array_filter(array_count_values(array_column($all_collect_fixture, 'team')), static function($count) { return $count > 1; }));
                // 		$rounds = array();
                // 		foreach ($all_collect_fixture as $v) {
                // 			foreach ($results as $value) {
                // 				if($value == $v['team']){
                // 					if(!in_array($v['round'], $rounds)){
                // 						$rounds[] = $v['round'];
                // 					}
                // 				}
                // 			}
                // 		}
                // 		return response()->json(['status'=>0, 'message'=>'Same fixtures are created in rounds '.implode(', ', $rounds)]);
                // 	}
                // }
            }
            if ($competition->comp_subtype_id == 5) {
                if ($key == 'vs') {
                    return response()->json(['status' => 0, 'message' => 'Create All Rounds Fixtures']);
                }
                // else{
                // 	if($value > 2){
                // 		$results = array_keys(array_filter(array_count_values(array_column($all_collect_fixture, 'team')), static function($count) { return $count > 2; }));
                // 		$rounds = array();
                // 		foreach ($all_collect_fixture as $v) {
                // 			foreach ($results as $value) {
                // 				if($value == $v['team']){
                // 					if(!in_array($v['round'], $rounds)){
                // 						$rounds[] = $v['round'];
                // 					}
                // 				}
                // 			}
                // 		}
                // 		return response()->json(['status'=>0, 'message'=>'Same fixtures are created more than 2 times in rounds '.implode(', ', $rounds)]);
                // 	}
                // }
            }
            if ($competition->comp_subtype_id == 6) {
                if ($key == 'vs') {
                    return response()->json(['status' => 0, 'message' => 'Create All Rounds Fixtures']);
                }
                // else{
                // 	if($value > 3){
                // 		$results = array_keys(array_filter(array_count_values(array_column($all_collect_fixture, 'team')), static function($count) { return $count > 3; }));
                // 		$rounds = array();
                // 		foreach ($all_collect_fixture as $v) {
                // 			foreach ($results as $value) {
                // 				if($value == $v['team']){
                // 					if(!in_array($v['round'], $rounds)){
                // 						$rounds[] = $v['round'];
                // 					}
                // 				}
                // 			}
                // 		}
                // 		return response()->json(['status'=>0, 'message'=>'Same fixtures are created more than 3 times in rounds '.implode(', ', $rounds)]);
                // 	}
                // }
            }
        }

        // return $array_count;
        $comp_referee = Comp_member::select('member_id')->where('comp_id', $request->comp_id)->where('invitation_status', 1)->where('is_active', 1)->first();

        // Update for existing Fixtures
        foreach ($updatedcollect_datalist as $y => $cdata) {
            if ((!empty($updatedcollect_datalist[$y]['round_fixid'])) && (!empty($updatedcollect_datalist[$y]['round_date'])) && (!empty($updatedcollect_datalist[$y]['round_tr']) && $updatedcollect_datalist[$y]['round_tr'] != "Select Team") && (!empty($updatedcollect_datalist[$y]['round_tl']) && $updatedcollect_datalist[$y]['round_tl'] != "Select Team")) {
                $update_match_fixture = match_fixture::where('id', $cdata['round_fixid'])->update(['teamOne_id' => $cdata['round_tl'], 'teamTwo_id' => $cdata['round_tr'], 'fixture_date' => $cdata['round_date']]);
            } else {
                // for validation
            }
        }


        return response()->json(['status' => 1, 'message' => 'All Rounds Fixtures are created']);
    }

    public function temp_league_team(Request $request)
    {
        $teamlogo = Team::select('id', 'team_logo')->find($request->team_id);

        return response()->json(['teamlogo' => $teamlogo, 't_fixture' => $request->logo_fixture, 't_round' => $request->logo_round, 't_position' => $request->logo_position]);
    }
    public function league_quick_compare(Request $request)
    {
        $teamlogo = Team::select('id', 'team_logo')->find($request->team_id);
        $opp_team_logo = Team::select('id', 'team_logo')->find($request->opp_team);
        // $team_fixtures = Match_fixture::where('competition_id',$request->comp_id)->where('teamOne_id',$request->team_id)->where('teamTwo_id',$request->opp_team)->where('finishdate_time','!=',null)->get();
        $team_id = $request->team_id;
        $team_fixtures = Match_fixture::where(function ($query) use ($team_id) {
            $query->where('teamOne_id', '=', $team_id)
                ->orWhere('teamTwo_id', '=', $team_id);
        })->where('competition_id', $request->comp_id)->where('finishdate_time', '!=', Null)->get();
        $right_team_id = $request->opp_team;
        $right_team_played = Match_fixture::where(function ($query) use ($right_team_id) {
            $query->where('teamOne_id', '=', $right_team_id)
                ->orWhere('teamTwo_id', '=', $right_team_id);
        })->where('competition_id', $request->comp_id)->where('finishdate_time', '!=', Null)->orderBy('finishdate_time', 'DESC')->get();
        if ($team_fixtures->count() > 0 || $right_team_played->count() > 0) {
            $left_team_won = Match_fixture::where('competition_id', $request->comp_id)->where('fixture_type', 2)->where('winner_team_id', $request->team_id)->count();
            $right_team_won = Match_fixture::where('competition_id', $request->comp_id)->where('fixture_type', 2)->where('winner_team_id', $request->opp_team)->count();

            $left_team_id = $request->team_id;
            $left_team_played = Match_fixture::where(function ($query) use ($left_team_id) {
                $query->where('teamOne_id', '=', $left_team_id)
                    ->orWhere('teamTwo_id', '=', $left_team_id);
            })->where('competition_id', $request->comp_id)->where('finishdate_time', '!=', Null)->orderBy('finishdate_time', 'DESC')->get();
            $left_team_lost = Match_fixture::where(function ($query) use ($left_team_id) {
                $query->where('teamOne_id', '=', $left_team_id)
                    ->orWhere('teamTwo_id', '=', $left_team_id);
            })->where('competition_id', $request->comp_id)->where('fixture_type', 2)->where('winner_team_id', '!=', $left_team_id)->count();
            $left_team_draw = Match_fixture::where(function ($query) use ($left_team_id) {
                $query->where('teamOne_id', '=', $left_team_id)
                    ->orWhere('teamTwo_id', '=', $left_team_id);
            })->where('competition_id', $request->comp_id)->where('fixture_type', 1)->count();
            $left_win_points = $left_team_won * 3;
            $left_draw_points = $left_team_draw * 1;
            $left_team_points = $left_win_points + $left_draw_points;


            $right_team_lost = Match_fixture::where(function ($query) use ($right_team_id) {
                $query->where('teamOne_id', '=', $right_team_id)
                    ->orWhere('teamTwo_id', '=', $right_team_id);
            })->where('competition_id', $request->comp_id)->where('fixture_type', 2)->where('winner_team_id', '!=', $right_team_id)->count();
            $right_team_draw = Match_fixture::where(function ($query) use ($right_team_id) {
                $query->where('teamOne_id', '=', $right_team_id)
                    ->orWhere('teamTwo_id', '=', $right_team_id);
            })->where('competition_id', $request->comp_id)->where('fixture_type', 1)->count();
            $right_win_points = $right_team_won * 3;
            $right_draw_points = $right_team_draw * 1;
            $right_team_points = $right_win_points + $right_draw_points;
            $left_team_yellowcards = Match_fixture_stat::where('competition_id', $request->comp_id)->where('team_id', $left_team_id)->where('sport_stats_id', 2)->count();
            $right_team_yellowcards = Match_fixture_stat::where('competition_id', $request->comp_id)->where('team_id', $right_team_id)->where('sport_stats_id', 2)->count();
            $left_team_redcards = Match_fixture_stat::where('competition_id', $request->comp_id)->where('team_id', $left_team_id)->where('sport_stats_id', 3)->count();
            $right_team_redcards = Match_fixture_stat::where('competition_id', $request->comp_id)->where('team_id', $right_team_id)->where('sport_stats_id', 3)->count();
            $left_team_goal_for = Match_fixture_stat::where('competition_id', $request->comp_id)->where('team_id', $left_team_id)->where('sport_stats_id', 1)->count();
            $right_team_goal_for = Match_fixture_stat::where('competition_id', $request->comp_id)->where('team_id', $right_team_id)->where('sport_stats_id', 1)->count();
            $left_team_rank = Competition_team_request::select('rank')->where('competition_id', $request->comp_id)->where('team_id', $left_team_id)->first();
            $right_team_rank = Competition_team_request::select('rank')->where('competition_id', $request->comp_id)->where('team_id', $right_team_id)->first();

            $againts_left_team = Match_fixture::where(function ($query) use ($left_team_id) {
                $query->where('teamOne_id', '=', $left_team_id)
                    ->orWhere('teamTwo_id', '=', $left_team_id);
            })->where('competition_id', $request->comp_id)->where('finishdate_time', '!=', Null)->get();
            $left_team_againts_goals = 0;
            // dd($againts_team);
            foreach ($againts_left_team as $a_team) {
                if ($a_team->teamOne_id == $left_team_id) {
                    // $a_team_ids[] = $a_team->teamTwo_id;
                    $goal_a = Match_fixture_stat::where('competition_id', $request->comp_id)->where('team_id', $a_team->teamTwo_id)->where('match_fixture_id', $a_team->id)->where('sport_stats_id', 1)->where('is_active', 1)->count();
                    $left_team_againts_goals = $left_team_againts_goals + $goal_a;
                } else {
                    $goal_a = Match_fixture_stat::where('competition_id', $request->comp_id)->where('team_id', $a_team->teamOne_id)->where('match_fixture_id', $a_team->id)->where('sport_stats_id', 1)->where('is_active', 1)->count();
                    $left_team_againts_goals = $left_team_againts_goals + $goal_a;
                }
            }
            $left_team_goal_differ = $left_team_goal_for - $left_team_againts_goals;
            $againts_right_team = Match_fixture::where(function ($query) use ($right_team_id) {
                $query->where('teamOne_id', '=', $right_team_id)
                    ->orWhere('teamTwo_id', '=', $right_team_id);
            })->where('competition_id', $request->comp_id)->where('finishdate_time', '!=', Null)->get();
            $right_team_againts_goals = 0;
            // dd($againts_team);
            foreach ($againts_right_team as $a_team) {
                if ($a_team->teamOne_id == $right_team_id) {
                    // $a_team_ids[] = $a_team->teamTwo_id;
                    $goal_a = Match_fixture_stat::where('competition_id', $request->comp_id)->where('team_id', $a_team->teamTwo_id)->where('match_fixture_id', $a_team->id)->where('sport_stats_id', 1)->where('is_active', 1)->count();
                    $right_team_againts_goals = $right_team_againts_goals + $goal_a;
                } else {
                    $goal_a = Match_fixture_stat::where('competition_id', $request->comp_id)->where('team_id', $a_team->teamOne_id)->where('match_fixture_id', $a_team->id)->where('sport_stats_id', 1)->where('is_active', 1)->count();
                    $right_team_againts_goals = $right_team_againts_goals + $goal_a;
                }
            }
            $right_team_goal_differ = $right_team_goal_for - $right_team_againts_goals;
        ?>
            <div class="pr-0 col-md-6 col-6 ">
                <div class="row">
                    <div class="p-12 col-md-4 col-12 W-50tab">
                        <div class="RankedSec">
                            <span class="RankedText">RANKED<br>
                            </span>
                            <p class="RankedNo"><?php if ($team_fixtures->count() > 0) {
                                                    echo str_pad($left_team_rank->rank, 2, 0, STR_PAD_LEFT);
                                                } else {
                                                    echo "##";
                                                } ?></p>
                        </div>
                    </div>
                    <div class="p-12 col-md-4 col-12 W-50tab">
                        <div class=" borderPoint">
                            <span class="RankedText">POINTS<br>
                            </span>
                            <p class="RankedNo"><?php if ($team_fixtures->count() > 0) {
                                                    echo str_pad($left_team_points, 2, 0, STR_PAD_LEFT);
                                                } else {
                                                    echo "##";
                                                } ?> </p>
                        </div>
                    </div>
                    <div class="p-12 col-md-4 col-12 New-on-Tab">
                        <div class="d-flex">
                            <div class="yelTxt">
                                <span class="YellInnerTxt"><?php echo str_pad($left_team_yellowcards, 2, 0, STR_PAD_LEFT); ?></span>
                            </div>
                            <div class="cards-det">
                                <span class="YellCard">YELLOW</span>
                                <p class="mb-2 YellCard">CARDS</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="RedTxt">
                                <span class="YellInnerTxt"><?php echo str_pad($left_team_redcards, 2, 0, STR_PAD_LEFT); ?></span>
                            </div>
                            <div class="cards-det">
                                <span class="RedCard">RED</span>
                                <p class="mb-2 RedCard ">CARDS</p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4 col-12 webkitCenter">
                        <div class="mb-2 Donut-Chart">
                            <?php
                            if ($left_team_won == 0 && $left_team_draw == 0 && $left_team_lost == 0) {
                            } elseif ($left_team_won == 0 && $left_team_draw == 0 && $left_team_lost != 0) {
                                $multiplyer = (int) (90 / count($left_team_played));
                                $thirdcircle = $left_team_lost * $multiplyer;
                            ?>
                                <div class="donut" style="--third: .<?php echo $thirdcircle; ?>;  --donut-spacing: 0;">
                                    <!-- <div class="donut__slice donut__slice__first"></div>
										  <div class="donut__slice donut__slice__second"></div> -->
                                    <div class="donut__slice donut__slice__third"></div>
                                    <div class="donut__label">
                                        <div class="donut__label__heading">
                                            <?php echo str_pad(count($left_team_played), 2, 0, STR_PAD_LEFT); ?>
                                        </div>
                                        <div class="donut__label__sub">
                                            PLAYED
                                        </div>
                                    </div>
                                </div>
                            <?php
                            } elseif ($left_team_won == 0 && $left_team_draw != 0 && $left_team_lost == 0) {
                                $multiplyer = (int) (90 / count($left_team_played));
                                $secondcircle = $left_team_draw * $multiplyer;
                            ?>
                                <div class="donut" style="--second: .<?php echo $secondcircle; ?>;  --donut-spacing: 0;">
                                    <!-- <div class="donut__slice donut__slice__first"></div> -->
                                    <div class="donut__slice donut__slice__second"></div>
                                    <!-- <div class="donut__slice donut__slice__third"></div> -->
                                    <div class="donut__label">
                                        <div class="donut__label__heading">
                                            <?php echo str_pad(count($left_team_played), 2, 0, STR_PAD_LEFT); ?>
                                        </div>
                                        <div class="donut__label__sub">
                                            PLAYED
                                        </div>
                                    </div>
                                </div> <?php
                                    } elseif ($left_team_won == 0 && $left_team_draw != 0 && $left_team_lost != 0) {
                                        $multiplyer = (int) (100 / count($left_team_played));
                                        $secondcircle = $left_team_draw * $multiplyer;
                                        $thirdcircle = $left_team_lost * $multiplyer;
                                        if ($secondcircle > $thirdcircle) {
                                            $var_setL = 'max';
                                        } else {
                                            $var_setL = 'unset';
                                        }
                                        ?>

                                <style>
                                    .Competitionn-Page-Additional .leftdonut.donut__slice__second {
                                        --second-start: calc(var(--first));
                                        --second-check: unset(var(--second-start) - .5, 0);
                                        -webkit-clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
                                        clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
                                    }

                                    .Competitionn-Page-Additional .leftdonut.donut__slice__third {
                                        --third-start: calc(var(--first) + var(--second));
                                        --third-check: <?php echo $var_setL; ?>((var(--third-start) - .5), 0);
                                        -webkit-clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
                                        clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
                                    }
                                </style>
                                <div class="donut" style="--first: .0; --second: .<?php echo $secondcircle; ?>; --third: .<?php echo $thirdcircle ?>;  --donut-spacing: 0;">
                                    <div class="donut__slice donut__slice__first"></div>
                                    <div class="donut__slice leftdonut donut__slice__second"></div>
                                    <div class="donut__slice leftdonut donut__slice__third"></div>
                                    <div class="donut__label">
                                        <div class="donut__label__heading">
                                            <?php echo str_pad(count($left_team_played), 2, 0, STR_PAD_LEFT); ?>
                                        </div>
                                        <div class="donut__label__sub">
                                            PLAYED
                                        </div>
                                    </div>
                                </div> <?php
                                    } elseif ($left_team_won != 0 && $left_team_draw == 0 && $left_team_lost == 0) {
                                        $multiplyer = (int) (90 / count($left_team_played));
                                        $firstcircle = $left_team_won * $multiplyer;
                                        ?>
                                <div class="donut" style="--first: .<?php echo $firstcircle; ?>; --donut-spacing: 0;">
                                    <div class="donut__slice donut__slice__first"></div>
                                    <!-- <div class="donut__slice donut__slice__second"></div>
										 <div class="donut__slice donut__slice__third"></div> -->
                                    <div class="donut__label">
                                        <div class="donut__label__heading">
                                            <?php echo str_pad(count($left_team_played), 2, 0, STR_PAD_LEFT); ?>
                                        </div>
                                        <div class="donut__label__sub">
                                            PLAYED
                                        </div>
                                    </div>
                                </div>
                            <?php
                                    } elseif ($left_team_won != 0 && $left_team_draw == 0 && $left_team_lost != 0) {
                                        $multiplyer = (int) (100 / count($left_team_played));
                                        $firstcircle = $left_team_won * $multiplyer;
                                        $secondcircle = $left_team_draw * $multiplyer;
                                        $thirdcircle = $left_team_lost * $multiplyer;

                                        if ($left_team_won > $left_team_lost) {
                                            $lvar_set = 'max';
                                        } else {
                                            $lvar_set = 'unset';
                                        }
                            ?>
                                <style>
                                    .Competitionn-Page-Additional .leftdonut.donut__slice__third {
                                        --third-start: calc(var(--first) + var(--second));
                                        --third-check: <?php echo $lvar_set; ?>((var(--third-start) - .5), 0);
                                        -webkit-clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
                                        clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
                                    }
                                </style>
                                <div class="donut" style="--first: .<?php echo $firstcircle; ?>; --second: .0; --third: .<?php echo $thirdcircle; ?>;  --donut-spacing: 0;">
                                    <div class="donut__slice donut__slice__first"></div>
                                    <div class="donut__slice leftdonut donut__slice__third"></div>
                                    <div class="donut__label">
                                        <div class="donut__label__heading">
                                            <?php echo str_pad(count($left_team_played), 2, 0, STR_PAD_LEFT); ?>
                                        </div>
                                        <div class="donut__label__sub">
                                            PLAYED
                                        </div>
                                    </div>
                                </div>
                            <?php } elseif ($left_team_won != 0 && $left_team_draw != 0 && $left_team_lost == 0) {
                                        $multiplyer = (int) (100 / count($left_team_played));
                                        $firstcircle = $left_team_won * $multiplyer;
                                        $secondcircle = $left_team_draw * $multiplyer;

                                        if ($left_team_won > $left_team_draw) {
                                            $lvar_set = 'max';
                                        } else {
                                            $lvar_set = 'unset';
                                        }
                            ?>
                                <style>
                                    .Competitionn-Page-Additional .leftdonut.donut__slice__second {
                                        --second-start: calc(var(--first));
                                        --second-check: <?php echo $lvar_set; ?>(var(--second-start) - .5, 0);
                                        -webkit-clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
                                        clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
                                    }
                                </style>
                                <div class="donut" style="--first: .<?php echo $firstcircle; ?> ; --second: .<?php echo $secondcircle ?>; --donut-spacing: 0;">
                                    <div class="donut__slice donut__slice__first"></div>
                                    <div class="donut__slice leftdonut donut__slice__second"></div>
                                    <div class="donut__label">
                                        <div class="donut__label__heading">
                                            <?php echo str_pad(count($left_team_played), 2, 0, STR_PAD_LEFT); ?>
                                        </div>
                                        <div class="donut__label__sub">
                                            PLAYED
                                        </div>
                                    </div>
                                </div>
                            <?php } elseif ($left_team_won != 0 && $left_team_draw != 0 && $left_team_lost != 0) {
                                        $multiplyer = (int) (100 / count($left_team_played));
                                        $firstcircle = $left_team_won * $multiplyer;
                                        $secondcircle = $left_team_draw * $multiplyer;
                                        $thirdcircle = $left_team_lost * $multiplyer;

                                        if ($left_team_won < $left_team_lost && $left_team_draw < $left_team_lost) {
                                            $varl_set = 'unset';
                                        } else {
                                            $varl_set = 'max';
                                        }
                            ?>
                                <style>
                                    .Competitionn-Page-Additional .leftdonut.donut__slice__second {
                                        --second-start: calc(var(--first));
                                        --second-check: unset((var(--second-start) - .5), 0);
                                        -webkit-clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
                                        clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
                                    }

                                    .Competitionn-Page-Additional .leftdonut.donut__slice__third {
                                        --third-start: calc(var(--first) + var(--second));
                                        --third-check: <?php echo $varl_set; ?>(calc(var(--third-start) - .5), 0);
                                        -webkit-clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
                                        clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
                                    }
                                </style>
                                <div class="donut" style="--first: .<?php echo $firstcircle; ?>; --second: .<?php echo $secondcircle; ?>; --third: .<?php echo $thirdcircle; ?>;  --donut-spacing: 0;">
                                    <div class="donut__slice leftdonut donut__slice__first"></div>
                                    <div class="donut__slice leftdonut donut__slice__second"></div>
                                    <div class="donut__slice leftdonut donut__slice__third"></div>
                                    <div class="donut__label">
                                        <div class="donut__label__heading">
                                            <?php echo str_pad(count($left_team_played), 2, 0, STR_PAD_LEFT); ?>
                                        </div>
                                        <div class="donut__label__sub">
                                            PLAYED
                                        </div>
                                    </div>
                                </div> <?php
                                    }
                                        ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 TabView ">
                        <div class=" borderPoint">
                            <div class="d-flex ">
                                <div class="box-grenn">

                                </div>
                                <div class="cards-det">
                                    <span class="Box-grenn-txt"><?php echo str_pad($left_team_won, 2, 0, STR_PAD_LEFT); ?> WON</span>
                                </div>
                            </div>
                            <div class="d-flex ">
                                <div class="box-gray">

                                </div>
                                <div class="cards-det">
                                    <span class="Box-grenn-txt"><?php echo str_pad($left_team_draw, 2, 0, STR_PAD_LEFT); ?> DRAW</span>
                                </div>
                            </div>
                            <div class="d-flex ">
                                <div class="box-Reddd">

                                </div>
                                <div class="cards-det">
                                    <span class="Box-grenn-txt"><?php echo str_pad($left_team_lost, 2, 0, STR_PAD_LEFT); ?> LOST</span>
                                </div>
                            </div>
                            <span class="Box-grenn-txt">TEAM FORM</span>
                            <p class="line-height-Team-form">
                                <?php
                                $rtf = 0;
                                foreach ($left_team_played as $a_team) {
                                    $rtf++;
                                    if ($rtf <= 5) {
                                        if ($a_team->fixture_type == 1) {
                                ?>
                                            <span class="D-Tean-form"> D</span>
                                            <?php } else if ($a_team->fixture_type == 2) {
                                            if ($a_team->winner_team_id == $request->team_id) { ?>
                                                <span class="G-Tean-form"> W</span>
                                            <?php } else { ?>
                                                <span class="R-Tean-form"> L</span>
                                <?php }
                                        } else {
                                        }
                                    }
                                } ?>
                                <?php
                                $restofteamform = 5 - $left_team_played->count();
                                for ($r = 1; $r <= $restofteamform; $r++) { ?>
                                    <span class="R-Tean-form" style="background-color:#003b5f !important;"> NA</span>
                                <?php } ?>

                            </p>
                        </div>
                    </div>
                    <div class="pl-0 col-md-4 col-12 tabFull">
                        <div class="d-flex justi_centr-tab">
                            <div class="BlueTxt">
                                <div class="YellInnerTxt"><?php echo str_pad($left_team_goal_differ, 2, 0, STR_PAD_LEFT); ?><p class="GoalsD"> GOAL D.</p>
                                </div>
                            </div>
                            <div class="cards-det">
                                <span class="Green"><?php echo str_pad($left_team_goal_for, 2, 0, STR_PAD_LEFT); ?></span>
                                <p class="mb-2 RedD"><?php echo str_pad($left_team_againts_goals, 2, 0, STR_PAD_LEFT); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pl-0 col-md-6 col-6 BorL-1">
                <div class="row">
                    <div class="p-12 col-md-4 col-12 W-50tab">
                        <div class="RankedSec">
                            <span class="RankedText">RANKED<br>
                            </span>
                            <p class="RankedNo"><?php if ($right_team_played->count() > 0) {
                                                    echo str_pad($right_team_rank->rank, 2, 0, STR_PAD_LEFT);
                                                } else {
                                                    echo "##";
                                                } ?></p>
                        </div>
                    </div>
                    <div class="p-12 col-md-4 col-12 W-50tab">
                        <div class=" borderPoint">
                            <span class="RankedText">POINTS<br>
                            </span>
                            <p class="RankedNo"><?php if ($right_team_played->count() > 0) {
                                                    echo str_pad($right_team_points, 2, 0, STR_PAD_LEFT);
                                                } else {
                                                    echo "##";
                                                } ?></p>
                        </div>
                    </div>
                    <div class="p-12 col-md-4 col-12 New-on-Tab">
                        <div class="d-flex">
                            <div class="yelTxt">
                                <span class="YellInnerTxt"><?php echo str_pad($right_team_yellowcards, 2, 0, STR_PAD_LEFT); ?></span>
                            </div>
                            <div class="cards-det">
                                <span class="YellCard">YELLOW</span>
                                <p class="mb-2 YellCard">CARDS</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="RedTxt">
                                <span class="YellInnerTxt"><?php echo str_pad($right_team_redcards, 2, 0, STR_PAD_LEFT); ?></span>
                            </div>
                            <div class="cards-det">
                                <span class="RedCard">RED</span>
                                <p class="mb-2 RedCard ">CARDS</p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4 col-12 webkitCenter">
                        <div class="mb-2 Donut-Chart">
                            <?php
                            if ($right_team_won == 0 && $right_team_draw == 0 && $right_team_lost == 0) {
                            } elseif ($right_team_won == 0 && $right_team_draw == 0 && $right_team_lost != 0) {
                                $Rmultiplyer = (int) (90 / count($right_team_played));
                                $Rthirdcircle = $right_team_lost * $Rmultiplyer;
                            ?>
                                <div class="donut" style=" --third: .<?php echo $Rthirdcircle; ?>;  --donut-spacing: 0;">
                                    <!-- <div class="donut__slice donut__slice__first"></div>
												  <div class="donut__slice donut__slice__second"></div> -->
                                    <div class="donut__slice donut__slice__third"></div>
                                    <div class="donut__label">
                                        <div class="donut__label__heading">
                                            <?php echo str_pad(count($right_team_played), 2, 0, STR_PAD_LEFT); ?>
                                        </div>
                                        <div class="donut__label__sub">
                                            PLAYED
                                        </div>
                                    </div>
                                </div>
                            <?php
                            } elseif ($right_team_won == 0 && $right_team_draw != 0 && $right_team_lost == 0) {
                                $Rmultiplyer = (int) (90 / count($right_team_played));
                                $Rsecondcircle = $right_team_draw * $Rmultiplyer;
                            ?>
                                <div class="donut" style=" --second: .<?php echo $Rsecondcircle; ?>;  --donut-spacing: 0;">
                                    <!-- <div class="donut__slice donut__slice__first"></div> -->
                                    <div class="donut__slice donut__slice__second"></div>
                                    <!-- <div class="donut__slice donut__slice__third"></div> -->
                                    <div class="donut__label">
                                        <div class="donut__label__heading">
                                            <?php echo str_pad(count($right_team_played), 2, 0, STR_PAD_LEFT); ?>
                                        </div>
                                        <div class="donut__label__sub">
                                            PLAYED
                                        </div>
                                    </div>
                                </div> <?php
                                    } elseif ($right_team_won == 0 && $right_team_draw != 0 && $right_team_lost != 0) {
                                        $Rmultiplyer = (int) (100 / count($right_team_played));
                                        $Rsecondcircle = $right_team_draw * $Rmultiplyer;
                                        $Rthirdcircle = $right_team_lost * $Rmultiplyer;
                                        if ($Rsecondcircle > $Rthirdcircle) {
                                            $var_setR = 'max';
                                        } else {
                                            $var_setR = 'unset';
                                        }
                                        ?>
                                <style>
                                    .Competitionn-Page-Additional .rightdonut.donut__slice__second {
                                        --second-start: calc(var(--first));
                                        --second-check: unset(var(--second-start) - .5, 0);
                                        -webkit-clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
                                        clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
                                    }

                                    .Competitionn-Page-Additional .rightdonut.donut__slice__third {
                                        --third-start: calc(var(--first) + var(--second));
                                        --third-check: <?php echo $var_setR; ?>((var(--third-start) - .5), 0);
                                        -webkit-clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
                                        clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
                                    }
                                </style>

                                <div class="donut" style=" --first: .0; --second: .<?php echo $Rsecondcircle; ?>; --third: .<?php echo $Rthirdcircle; ?>;  --donut-spacing: 0;">
                                    <div class="donut__slice donut__slice__first"></div>
                                    <div class="donut__slice rightdonut donut__slice__second"></div>
                                    <div class="donut__slice rightdonut donut__slice__third"></div>
                                    <div class="donut__label">
                                        <div class="donut__label__heading">
                                            <?php echo str_pad(count($right_team_played), 2, 0, STR_PAD_LEFT); ?>
                                        </div>
                                        <div class="donut__label__sub">
                                            PLAYED
                                        </div>
                                    </div>
                                </div> <?php
                                    } elseif ($right_team_won != 0 && $right_team_draw == 0 && $right_team_lost == 0) {
                                        $Rmultiplyer = (int) (90 / count($right_team_played));
                                        $Rfirstcircle = $right_team_won * $Rmultiplyer;
                                        ?>
                                <div class="donut" style="--first: .<?php echo $Rfirstcircle; ?>;  --donut-spacing: 0;">
                                    <div class="donut__slice donut__slice__first"></div>
                                    <!-- <div class="donut__slice donut__slice__second"></div>
												 <div class="donut__slice donut__slice__third"></div> -->
                                    <div class="donut__label">
                                        <div class="donut__label__heading">
                                            <?php echo str_pad(count($right_team_played), 2, 0, STR_PAD_LEFT); ?>
                                        </div>
                                        <div class="donut__label__sub">
                                            PLAYED
                                        </div>
                                    </div>
                                </div>
                            <?php
                                    } elseif ($right_team_won != 0 && $right_team_draw == 0 && $right_team_lost != 0) {
                                        $Rmultiplyer = (int) (100 / count($right_team_played));
                                        $Rfirstcircle = $right_team_won * $Rmultiplyer;
                                        $Rthirdcircle = $right_team_lost * $Rmultiplyer;
                                        if ($right_team_won > $right_team_lost) {
                                            $rvar_set = 'max';
                                        } else {
                                            $rvar_set = 'unset';
                                        }
                            ?>
                                <style>
                                    .Competitionn-Page-Additional .rightdonut.donut__slice__third {
                                        --third-start: calc(var(--first) + var(--second));
                                        --third-check: <?php echo $rvar_set; ?>(calc(var(--third-start) - .5), 0);
                                        -webkit-clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
                                        clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
                                    }
                                </style>
                                <div class="donut" style="--first: .<?php echo $Rfirstcircle; ?>; --second:  .0; --third: .<?php echo $Rthirdcircle; ?>;  --donut-spacing: 0;">
                                    <div class="donut__slice rightdonut donut__slice__first"></div>
                                    <!-- <div class="donut__slice donut__slice__second"></div> -->
                                    <div class="donut__slice rightdonut donut__slice__third"></div>
                                    <div class="donut__label">
                                        <div class="donut__label__heading">
                                            <?php echo str_pad(count($right_team_played), 2, 0, STR_PAD_LEFT); ?>
                                        </div>
                                        <div class="donut__label__sub">
                                            PLAYED
                                        </div>
                                    </div>
                                </div>
                            <?php } elseif ($right_team_won != 0 && $right_team_draw != 0 && $right_team_lost == 0) {
                                        $Rmultiplyer = (int) (100 / count($right_team_played));
                                        $Rfirstcircle = $right_team_won * $Rmultiplyer;
                                        $Rsecondcircle = $right_team_draw * $Rmultiplyer;
                                        if ($right_team_won > $right_team_draw) {
                                            $rvar_set = 'max';
                                        } else {
                                            $rvar_set = 'unset';
                                        }
                            ?>
                                <style>
                                    .Competitionn-Page-Additional .rightdonut.donut__slice__second {
                                        --second-start: calc(var(--first));
                                        --second-check: <?php echo $rvar_set; ?>(var(--second-start) - .5, 0);
                                        -webkit-clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
                                        clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
                                    }
                                </style>
                                <div class="donut" style="--first: .<?php echo $Rfirstcircle; ?>; --second: .<?php echo $Rsecondcircle; ?>;  --donut-spacing: 0;">
                                    <div class="donut__slice rightdonut donut__slice__first"></div>
                                    <div class="donut__slice rightdonut donut__slice__second"></div>
                                    <!-- <div class="donut__slice donut__slice__third"></div> -->
                                    <div class="donut__label">
                                        <div class="donut__label__heading">
                                            <?php echo str_pad(count($right_team_played), 2, 0, STR_PAD_LEFT); ?>
                                        </div>
                                        <div class="donut__label__sub">
                                            PLAYED
                                        </div>
                                    </div>
                                </div>
                            <?php } elseif ($right_team_won != 0 && $right_team_draw != 0 && $right_team_lost != 0) {
                                        $Rmultiplyer = (int) (100 / count($right_team_played));
                                        $Rfirstcircle = $right_team_won * $Rmultiplyer;
                                        $Rsecondcircle = $right_team_draw * $Rmultiplyer;
                                        $Rthirdcircle = $right_team_lost * $Rmultiplyer;

                                        if ($right_team_won < $right_team_lost && $right_team_draw < $right_team_lost) {
                                            $var_r_set = 'unset';
                                        } else {
                                            $var_r_set = 'max';
                                        }
                            ?>
                                <style>
                                    .Competitionn-Page-Additional .rightdonut.donut__slice__second {
                                        --second-start: calc(var(--first));
                                        --second-check: unset(var(--second-start) - .5, 0);
                                        -webkit-clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
                                        clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
                                    }

                                    .Competitionn-Page-Additional .rightdonut.donut__slice__third {
                                        --third-start: calc(var(--first) + var(--second));
                                        --third-check: <?php echo $var_r_set; ?>(calc(var(--third-start) - .5), 0);
                                        -webkit-clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
                                        clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
                                    }
                                </style>
                                <div class="donut" style="--first: .<?php echo $Rfirstcircle; ?>; --second: .<?php echo $Rsecondcircle; ?>; --third: .<?php echo $Rthirdcircle; ?>;  --donut-spacing: 0;">
                                    <div class="donut__slice rightdonut donut__slice__first"></div>
                                    <div class="donut__slice rightdonut donut__slice__second"></div>
                                    <div class="donut__slice rightdonut donut__slice__third"></div>
                                    <div class="donut__label">
                                        <div class="donut__label__heading">
                                            <?php echo str_pad(count($right_team_played), 2, 0, STR_PAD_LEFT); ?>
                                        </div>
                                        <div class="donut__label__sub">
                                            PLAYED
                                        </div>
                                    </div>
                                </div> <?php
                                    }
                                        ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 TabView">
                        <div class=" borderPoint">
                            <div class="d-flex ">
                                <div class="box-grenn">

                                </div>
                                <div class="cards-det">
                                    <span class="Box-grenn-txt"><?php echo str_pad($right_team_won, 2, 0, STR_PAD_LEFT); ?> WON</span>
                                </div>
                            </div>
                            <div class="d-flex ">
                                <div class="box-gray">

                                </div>
                                <div class="cards-det">
                                    <span class="Box-grenn-txt"><?php echo str_pad($right_team_draw, 2, 0, STR_PAD_LEFT); ?> DRAW</span>
                                </div>
                            </div>
                            <div class="d-flex ">
                                <div class="box-Reddd">
                                </div>
                                <div class="cards-det">
                                    <span class="Box-grenn-txt"><?php echo str_pad($right_team_lost, 2, 0, STR_PAD_LEFT); ?> LOST</span>
                                </div>
                            </div>
                            <span class="Box-grenn-txt">TEAM FORM</span>
                            <p class="line-height-Team-form">
                                <?php
                                $Rrtf = 0;
                                foreach ($right_team_played as $a_team) {
                                    $Rrtf++;
                                    if ($Rrtf <= 5) {
                                        if ($a_team->fixture_type == 1) {
                                ?> <span class="D-Tean-form"> D</span> <?php
                                                                    } else if ($a_team->fixture_type == 2) {
                                                                        if ($a_team->winner_team_id == $request->opp_team) { ?>
                                                <span class="G-Tean-form"> W</span>
                                            <?php } else { ?>
                                                <span class="R-Tean-form"> L</span>
                                    <?php }
                                                                    }
                                                                }
                                                            }
                                                            $restofteamform = 5 - $right_team_played->count();
                                                            for ($r = 1; $r <= $restofteamform; $r++) { ?>
                                    <span class="R-Tean-form" style="background-color:#003b5f !important;"> NA</span>
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                    <div class="pl-0 col-md-4 col-12 tabFull">
                        <div class="d-flex justi_centr-tab ">
                            <div class="BlueTxt">
                                <div class="YellInnerTxt"><?php echo str_pad($right_team_goal_differ, 2, 0, STR_PAD_LEFT); ?><p class="GoalsD"> GOAL D.</p>
                                </div>
                            </div>
                            <div class="cards-det">
                                <span class="Green"><?php echo str_pad($right_team_goal_for, 2, 0, STR_PAD_LEFT); ?></span>
                                <p class="mb-2 RedD"><?php echo str_pad($right_team_againts_goals, 2, 0, STR_PAD_LEFT); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <?php
                } else {
                    ?> <div class="pr-0 col-md-12 col-12 ">
                <p class="text-center"> No Data Found</p> <?php
                                                        }
                                                    }
                                                    public function on_change_get_team_logo(Request $request)
                                                    {
                                                        $team_info = Team::select('id', 'name', 'team_logo', 'team_color')->find($request->team_id);
                                                        $opp_team = Team::select('id', 'name', 'team_logo', 'team_color')->find($request->team_id2);
                                                        return response()->json(['team_info' => $team_info, 'opp_team' => $opp_team]);
                                                    }
                                                    public function on_change_mvp_winner(Request $request)
                                                    {
                                                        $competition = Competition::find($request->comp_id);
                                                        $match_fixtures = Match_fixture::where('competition_id', $request->comp_id)->get();
                                                        $fixture_ids = array();
                                                        $finish_fixture_ids = array();
                                                        foreach ($match_fixtures as $match_fixture) {
                                                            $fixture_ids[] = $match_fixture->id;
                                                            if ($match_fixture->finishdate_time != null) {
                                                                $match_fixture_finish_time = strtotime($match_fixture->finishdate_time);
                                                                $cal_voting_time = $competition->vote_mins * 60;
                                                                $voting_finish_time = $match_fixture_finish_time + $cal_voting_time;
                                                                $cal_current_time = strtotime(now());
                                                                if ($cal_current_time >= $voting_finish_time) {
                                                                    $finish_fixture_ids[] = $match_fixture->id;
                                                                }
                                                            }
                                                        }

                                                        $recent_finishMatch_fixtures = Match_fixture::where('competition_id', $request->comp_id)->orderBy('finishdate_time', 'DESC')->get();
                                                        // return $recent_finishMatch_fixtures;
                                                        $finish_fixture_ids1 = array();
                                                        foreach ($recent_finishMatch_fixtures as $finishMatch_fixture) {
                                                            if ($finishMatch_fixture->finishdate_time != null) {

                                                                $match_fixture_finish_time1 = strtotime($finishMatch_fixture->finishdate_time);
                                                                $cal_voting_time1 = $competition->vote_mins * 60;
                                                                $voting_finish_time1 = $match_fixture_finish_time1 + $cal_voting_time1;
                                                                $cal_current_time1 = strtotime(now());
                                                                if ($cal_current_time1 >= $voting_finish_time1) {
                                                                    $finish_fixture_ids1[] = $finishMatch_fixture->id;
                                                                }
                                                            }
                                                        }

                                                        // return $finish_fixture_ids1;
                                                        if ($request->winner_type == 2) {
                                                            $mvp_winner_list = Fixture_squad::whereIn('match_fixture_id', $fixture_ids)->where('status_desc', 1)->latest()->get();
                                                            $mvp_winner_most = array();
                                                            $competition_fixture_list = voting::select('player_id')->whereIn('match_fixture_id', $finish_fixture_ids1)->where('status_desc', 1)->orderBy('id', 'DESC')->get();
                                                            // return $competition_fixture_list;
                                                            $recent_winner_array = $competition_fixture_list->toArray();

                                                            // foreach($recent_winner as $mvp)
                                                            // {
                                                            // 	$mvp_winner_most[$mvp['player_id']] = $mvp['total'];
                                                            // }

                                                            foreach ($recent_winner_array as $mvp) {
                                                                $total_count = count(array_keys($recent_winner_array, $mvp));
                                                                $mvp_winner_most[$mvp['player_id']] = $total_count;
                                                            }
                                                            $i = 0;
                                                            $vote_count_key = array_keys($mvp_winner_most);

                                                            if (count($vote_count_key) > 0) {
                                                                for ($winners = 0; $winners < count($vote_count_key); $winners++) {
                                                                    if ($i < 5) {
                                                                        $mvpplayerid = $vote_count_key[$winners];
                                                                        $playervote = $mvp_winner_most[$mvpplayerid];
                                                                        $mvpplayer = user::select('id', 'first_name', 'last_name', 'profile_pic')->find($mvpplayerid);
                                                                        $mvpplayer_team_id = voting::whereIn('match_fixture_id', $finish_fixture_ids1)->where('player_id', $mvpplayerid)->value('team_id');
                                                                        $mvpplayer_team = Team::select('name', 'id', 'team_color')->find($mvpplayer_team_id);
                                                                        $mvpplayer_jersey_num = Team_member::where('team_id', $mvpplayer_team_id)->where('member_id', $mvpplayerid)->value('jersey_number');
                                                            ?>
                            <li class="list-group-item d-flex justify-content-between align-items-start" title="<?php echo $mvpplayer->first_name . ' ' . $mvpplayer->last_name . ' ,' . $mvpplayer->name ?>">
                                <style>
                                    .mvpplayer<?php echo $mvpplayer_team->id; ?>:after {
                                        color: <?php echo $mvpplayer_team->team_color; ?>;
                                    }
                                </style>
                                <span class="jersy-noTopFIve team-jersy-TopPlayer mvpplayer<?php echo $mvpplayer_team->id; ?>"><?php echo $mvpplayer_jersey_num; ?></span>
                                <img class="img-fluid rounded-circle padd-RL" src="<?php echo url('frontend/profile_pic') ?>/<?php echo $mvpplayer->profile_pic; ?>" width="25%">
                                <div class="ms-2 me-auto EngCity">
                                    <a href="<?php echo url('player_profile/' . $mvpplayerid) ?>" target="_blank">
                                        <div class=" ManCity">
                                            <?php echo $mvpplayer->first_name . ' ' . $mvpplayer->last_name; ?>
                                        </div>
                                    </a>
                                    <a href="<?php echo url('team/' . $mvpplayer_team->id) ?>" target="_blank"> <?php echo $mvpplayer_team->name; ?> </a>
                                </div>
                                <span class="badge"><?php echo $playervote; ?></span>
                            </li>
                    <?php
                                                                    }

                                                                    $i++;
                                                                }
                                                            } else {
                    ?>
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <p style="text-align:center; font-weight:bold;">No Data Found</p>
                    </div>
                    <?php
                                                            }
                                                        } else {
                                                            $mvp_winner_list = Fixture_squad::groupBy('player_id')->whereIn('match_fixture_id', $fixture_ids)->where('status_desc', 1)->selectRaw('count(*) as total, player_id')->get();
                                                            // $recent_winner = $mvp_winner_list->toArray();
                                                            $competition_fixture_list = voting::groupBy('player_id')->whereIn('match_fixture_id', $fixture_ids)->where('status_desc', 1)->selectRaw('count(*) as total, player_id')->get();
                                                            $recent_winner = $competition_fixture_list->toArray();

                                                            if (count($recent_winner) > 0) {
                                                                $mvp_winner_most = array();
                                                                foreach ($recent_winner as $mvp) {
                                                                    $mvp_winner_most[$mvp['player_id']] = $mvp['total'];
                                                                }

                                                                arsort($mvp_winner_most);
                                                                $vote_count_key = array_keys($mvp_winner_most);
                                                                for ($tp = 0; $tp < count($vote_count_key); $tp++) {
                                                                    if ($tp < 5) {
                                                                        $mvpplayerid = $vote_count_key[$tp];
                                                                        $playervote = $mvp_winner_most[$mvpplayerid];
                                                                        $mvpplayer = user::select('id', 'first_name', 'last_name', 'profile_pic')->find($mvpplayerid);
                                                                        $mvpplayer_team_id = voting::whereIn('match_fixture_id', $fixture_ids)->where('player_id', $mvpplayerid)->value('team_id');
                                                                        $mvpplayer_team = Team::select('name', 'id', 'team_color')->find($mvpplayer_team_id);
                                                                        $mvpplayer_jersey_num = Team_member::where('team_id', $mvpplayer_team_id)->where('member_id', $mvpplayerid)->value('jersey_number');
                    ?>
                            <li class="list-group-item d-flex justify-content-between align-items-start" title="<?php echo $mvpplayer->first_name . ' ' . $mvpplayer->last_name . ' ,' . $mvpplayer->name ?>">
                                <style>
                                    .mvpplayer<?php echo $mvpplayer_team->id; ?>:after {
                                        color: <?php echo $mvpplayer_team->team_color; ?>;
                                    }
                                </style>
                                <span class="jersy-noTopFIve team-jersy-TopPlayer mvpplayer<?php echo $mvpplayer_team->id; ?>"><?php echo $mvpplayer_jersey_num; ?></span>
                                <img class="img-fluid rounded-circle padd-RL" src="<?php echo url('frontend/profile_pic') ?>/<?php echo $mvpplayer->profile_pic; ?>" width="25%">
                                <div class="ms-2 me-auto EngCity">
                                    <a href="<?php url('player_profile/' . $mvpplayerid) ?>" target="_blank">
                                        <div class=" ManCity">
                                            <?php echo $mvpplayer->first_name . ' ' . $mvpplayer->last_name; ?>
                                        </div>
                                    </a>
                                    <a href="<?php url('team/' . $mvpplayer_team->id) ?>" target="_blank"> <?php echo $mvpplayer_team->name; ?> </a>
                                </div>
                                <span class="badge"><?php echo $playervote; ?></span>
                            </li>
                    <?php
                                                                    }
                                                                }
                                                            } else {
                    ?>
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <p style="text-align:center; font-weight:bold;">No Data Found</p>
                    </div>
                <?php
                                                            }
                                                        }
                                                    }
                                                    public function comp_admin_profile($admin_id, $comp_id)
                                                    {
                                                        $user_info = User::find($admin_id);
                                                        $total_inches = $user_info->height / 2.54;
                                                        $d_feet = (int) (round($total_inches) / 12);
                                                        $d_in = (int) (round($total_inches) - 12 * $d_feet);

                                                        // $height = $feet."' ".($inches%12).'"';
                                                        //weight converstion
                                                        $age = Carbon::parse($user_info->dob)->age;
                                                        $weight_lbs = (int) ($user_info->weight * 2.20462);
                                                        $trophy_cabinets = Trophy_cabinet::where('type', 1)->where('type_id', $user_info->id)->where('is_active', 1)->get();
                                                        $comp = Competition::find($comp_id);
                                                        return view('frontend.competitions.comp_admin_profile', compact('user_info', 'd_feet', 'd_in', 'age', 'weight_lbs', 'trophy_cabinets', 'comp'));
                                                    }
                                                    public function match_Details(Request $request)
                                                    {
                                                        $matches = Match_fixture::where('competition_id', $request->comp_id)
                                                            ->where('fixture_type', 2)
                                                            ->where('finishdate_time', '!=', null)
                                                            ->get();
                                                        $i = 0;
                                                        $htmlCode = '';
                                                        if ($matches->isNotEmpty()) {

                                                            foreach ($matches as $match) {
                                                                $winner_team = Team::find($match->winner_team_id);
                                                                $winner_team_goals = Match_fixture_stat::where('match_fixture_id', $match->id)
                                                                    ->where('team_id', $winner_team->id)
                                                                    ->where('sport_stats_id', 1)
                                                                    ->count();
                                                                if ($winner_team->id == $match->teamOne_id) {
                                                                    $opp_team = $match->teamTwo_id;
                                                                } else {
                                                                    $opp_team = $match->teamOne_id;
                                                                }
                                                                $opp_team_info = Team::find($opp_team);
                                                                $opp_team_goals = Match_fixture_stat::where('match_fixture_id', $match->id)
                                                                    ->where('team_id', $opp_team_info->id)
                                                                    ->where('sport_stats_id', 1)
                                                                    ->count();

                                                                $last_div = $matches->count() % 3;
                                                                if ($last_div == 0) {
                                                                    if ($i == $matches->count() - 1 || $i == $matches->count() - 2 || $i == $matches->count() - 3) {
                                                                        $c = 'bb-n';
                                                                    } else {
                                                                        $c = '';
                                                                    }
                                                                } elseif ($last_div == 1) {
                                                                    if ($i == $matches->count() - 1) {
                                                                        $c = 'bb-n';
                                                                    } else {
                                                                        $c = '';
                                                                    }
                                                                } elseif ($last_div == 2) {
                                                                    if ($i == $matches->count() - 1 || $i == $matches->count() - 2) {
                                                                        $c = 'bb-n';
                                                                    } else {
                                                                        $c = '';
                                                                    }
                                                                }

                                                                $htmlCode .= '<div class="col-md-4 teams-box ' . $c . ' ">
					<p class="win"><a href="' . url("team/" . $winner_team->id) . '" target="_blank"><img class="icon-thumb" src="' . url('frontend\logo') . '\\' . $winner_team->team_logo . '"
								width="10%" loading="lazy">' . $winner_team->name . '<span class="score">' . $winner_team_goals . '</span></a>
					</p>
					<p><a href="' . url('team/' . $opp_team_info->id) . '"
							target="_blank"><img class="icon-thumb"
								src="' . url('frontend\logo') . '\\' . $opp_team_info->team_logo . '"
								width="10%" loading="lazy">' . $opp_team_info->name . '<span
								class="score">' . $opp_team_goals . '</span></a>
					</p>
				</div>';
                                                                $i++;
                                                            }
                                                        } else {
                                                            $htmlCode = '<p> No Data Found!</p>';
                                                        }
                                                        echo $htmlCode;
                                                    }
                                                    public function public_top_performer(Request $request)
                                                    {
                                                        $player_stats = Match_fixture_stat::where('competition_id', $request->comp_id)->where('sport_stats_id', 1)->get();
                                                        $top_player_goal = $player_stats->groupBy('player_id');
                                                        $playerids = array();
                                                        foreach ($top_player_goal as $top_player => $stat) {
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

                                                            // $comp_attend = Competition_attendee::where('attendee_id',$player->id)->get();
                                                            // $game_played = 0;
                                                            // foreach($comp_attend as $comp)
                                                            // {
                                                            // 	$team_id = $comp->team_id;
                                                            // 	$check_fixtures = Match_fixture::where(function ($query) use ($team_id) {
                                                            // 		$query->where('teamOne_id', '=', $team_id)
                                                            // 		->orWhere('teamTwo_id', '=', $team_id);
                                                            // 		})->where('finishdate_time', '!=', NULL)->where('competition_id',$comp->Competition_id)->count();
                                                            // 	if($check_fixtures > 0)
                                                            // 	{
                                                            // 		$game_played++;
                                                            // 	}
                                                            // }
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
                                                            $game_started_fixtures = Match_fixture::select('id')->where(function ($query) use ($player_team) {
                                                                $query->where('teamOne_id', '=', $player_team)
                                                                    ->orWhere('teamTwo_id', '=', $player_team);
                                                            })->where('competition_id', $request->comp_id)->where('fixture_type', '!=', 9)->where('startdate_time', '!=', Null)->get();
                                                            foreach ($game_started_fixtures as $fixture) {
                                                                $fixture_ids[] = $fixture->id;
                                                            }
                                                            $game_started = Fixture_squad::whereIn('match_fixture_id', $fixture_ids)->where('player_id', $player->id)->count();
                                                            $cal_stat = ['<li>' . $game_played->count() . ' Games Played', '<li>' . $game_started . ' Games Started'];
                                                            $array_merge = array_merge($cal_stat, $player_stat_count);

                                                            $imploadallstate = implode('</li>', $array_merge);

                ?>

                <style>
                    .performer-goal.green-bg-<?php echo $team->id; ?>:after {
                        background: <?php echo $team->team_color; ?>;
                    }

                    .performer-player-img.green-bg-<?php echo $team->id; ?>:after {
                        background: <?php echo $team->team_color; ?>;
                    }
                </style>

                <div class="top-performer-box w-100 d-flex">
                    <div class="performer-goal green-bg-<?php echo $team->id; ?> position-relative col-md-3 pt-2 pe-4">
                        <h2><?php echo $playergoal ?><span>Goals</span>
                        </h2>
                        <a href="<?php echo url('team') ?>/<?php echo $team->id; ?>" class="ic-logo" target="_blank">
                            <img class="rounded-circle" src="<?php echo url('frontend/logo') ?>/<?php echo $team->team_logo ?>">
                        </a>
                    </div>
                    <div class="py-2 performer-detail col-md-5" style="background:<?php echo $team->team_color; ?> !important;">
                        <div class="content-pos">
                            <h5>
                                <a href="<?php echo url('player_profile') ?>/<?php echo $player->id; ?>" target="_blank"><?php echo $player->first_name; ?> <?php echo $player->last_name; ?></a>
                            </h5>
                            <ul class="list-unstyled player_stat_count">
                                <?php echo $imploadallstate; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="performer-player-img green-bg-<?php echo $team->id; ?> position-relative col-md-4 ">
                        <div class="overflow-hidden w-100 br-right-0">
                            <a href="<?php echo url('player_profile') ?>/ <?php echo $player->id; ?>" target="_blank"><img src="<?php echo url('frontend/profile_pic') ?>/<?php echo $player->profile_pic ?>" alt="player" class="img-fluid"> </a>
                        </div>
                    </div>
                </div>
    <?php
                                                        }
                                                    }

                                                    public function draftcomp($id)
                                                    {
                                                        $drftcomp_id = $id;
                                                        return view('frontend.competitions.draftComp', compact('drftcomp_id'));
                                                    }
                                                }
