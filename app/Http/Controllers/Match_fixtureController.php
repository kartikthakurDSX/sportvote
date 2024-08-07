<?php

namespace App\Http\Controllers;

use App\Models\Match_fixture;
use App\Models\Competition;
use App\Models\Competition_attendee;
use App\Models\SportGroundPosition;
use App\Models\Team;
use App\Models\Fixture_squad;
use App\Models\Fixture_substitute;
use App\Models\User;
use App\Models\Team_member;
use App\Models\StatTrack;
use App\Models\Sport_stat;
use App\Models\Match_fixture_stat;
use App\Models\Match_fixture_lapse;
use App\Models\Comp_member;


use Illuminate\Http\Request;

class Match_fixtureController extends Controller
{

    public function index()
    {
        return view('frontend.match_fixture.match_page');
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }
    public function show($id)
    {
        $match_fixture = Match_fixture::where('id', $id)
            ->first();

        if (!$match_fixture) {
            abort(404); // Handle the case where the match fixture is not found
        }

        $competition = Competition::where('id', $match_fixture->competition_id)
            ->select('id', 'user_id', 'name', 'lineup_players_num')
            ->first();

        if (!$competition) {
            abort(404); // Handle the case where the competition is not found
        }

        $teamOne = Team::where('id', $match_fixture->teamOne_id)
            ->select('id', 'user_id', 'team_logo', 'team_color', 'font_color', 'name', 'location')
            ->first();

        $teamTwo = Team::where('id', $match_fixture->teamTwo_id)
            ->select('id', 'user_id', 'team_logo', 'team_color', 'font_color', 'name', 'location')
            ->first();

        if (!$teamOne || !$teamTwo) {
            abort(404); // Handle the case where one of the teams is not found
        }

        $teamOne_attendees = Competition_attendee::where('team_id', $teamOne->id)
            ->where('competition_id', $match_fixture->competition_id)
            ->select('attendee_id')
            ->get();

        $teamTwo_attendees = Competition_attendee::where('team_id', $teamTwo->id)
            ->where('competition_id', $match_fixture->competition_id)
            ->select('attendee_id')
            ->get();

        $ground_map_position = SportGroundPosition::select('id', 'ground_coordinates', 'name')->get();

        $player_stats = Sport_stat::select('id', 'name')
            ->whereIn('stat_type_id', [0, 1])
            ->whereIn('stat_type', [0, 1])
            ->where('is_active', 1)
            ->get();

        $detailed_stats = StatTrack::select('Stat_ids')
            ->where('tracking_type', 1)
            ->where('tracking_for', $match_fixture->competition_id)
            ->where('is_active', 1)
            ->latest()
            ->first();

        $stats_array = $detailed_stats ? explode(',', $detailed_stats->Stat_ids) : [];

        $player_detailed_stats = Sport_stat::select('id', 'name')
            ->whereIn('id', $stats_array)
            ->where('is_active', 1)
            ->get();

        $comp_admins = Comp_member::where('comp_id', $competition->id)
            ->where('member_position_id', 7)
            ->where('invitation_status', 1)
            ->where('is_active', 1)
            ->with('member')
            ->pluck('member_id');

        $admins = $comp_admins->toArray();
        array_push($admins, $competition->user_id);

        $team_admins = Team_member::where(function ($query) use ($teamOne, $teamTwo) {
            $query->where('team_id', $teamOne->id)
                ->orWhere('team_id', $teamTwo->id);
        })
            ->where('member_position_id', 4)
            ->where('invitation_status', 1)
            ->with('member')
            ->pluck('member_id');

        $team_admins_ids = $team_admins->toArray();
        array_push($team_admins_ids, $teamOne->user_id, $teamTwo->user_id);

        $all_admins = array_unique(array_merge($admins, $team_admins_ids));

        return view('frontend.match-fixture.view', compact(
            'admins',
            'player_stats',
            'ground_map_position',
            'match_fixture',
            'competition',
            'teamOne',
            'teamTwo',
            'teamTwo_attendees',
            'teamOne_attendees',
            'player_detailed_stats',
            'all_admins',
            'team_admins_ids'
        ));
    }


    // public function show($id)
    // {
    //     $match_fixture = Match_fixture::where('id', $id)
    //     //->select('id','competition_id', 'teamOne_id', 'teamTwo_id')
    //     ->first();

    //     //return $match_fixture = Match_fixture::find($id);

    //     if (!$match_fixture) {
    //         abort(404); // Handle the case where the match fixture is not found
    //     }
    //     $competition = Competition::where('id', $match_fixture->competition_id)
    //     ->select('id', 'user_id','name','lineup_players_num')
    //     ->first();
    //    //return $competition = Competition::find($match_fixture->competition_id);

    //     if (!$competition) {
    //         abort(404); // Handle the case where the competition is not found
    //     }

    //     // $teamOne = Team::find($match_fixture->teamOne_id);
    //     // $teamTwo = Team::find($match_fixture->teamTwo_id);
    //     $teamOne = Team::where('id', $match_fixture->teamOne_id)
    //     ->select('id', 'user_id','team_logo','team_color','font_color','name','location')
    //     ->first();

    //   //  $teamTwo = Team::find($match_fixture->teamTwo_id);
    //     $teamTwo = Team::where('id', $match_fixture->teamTwo_id)
    //     ->select('id', 'user_id','team_logo','team_color','font_color','name','location')
    //     ->first();

    //     if (!$teamOne || !$teamTwo) {
    //         abort(404); // Handle the case where one of the teams is not found
    //     }

    //     // $teamOne_attendees = Competition_attendee::where('team_id', $teamOne->id)
    //     //     ->where('competition_id', $match_fixture->competition_id)
    //     //     ->get();

    //     // $teamTwo_attendees = Competition_attendee::where('team_id', $teamTwo->id)
    //     //     ->where('competition_id', $match_fixture->competition_id)
    //     //     ->get();

    //     // $ground_map_position = SportGroundPosition::get();

    //     $teamOne_attendees = Competition_attendee::where('team_id', $teamOne->id)
    //     ->where('competition_id', $match_fixture->competition_id)
    //     ->select('attendee_id')
    //     ->get();


    //     $teamTwo_attendees = Competition_attendee::where('team_id', $teamTwo->id)
    //         ->where('competition_id', $match_fixture->competition_id)
    //         ->select('attendee_id')
    //         ->get();

    //     // return $ground_map_position = SportGroundPosition::get();
    //     $ground_map_position = SportGroundPosition::select('id', 'ground_coordinates','name')->get();


    //     $player_stats = Sport_stat::select('id', 'name')
    //         ->whereIn('stat_type_id', [0, 1])
    //         ->whereIn('stat_type', [0, 1])
    //         ->where('is_active', 1)
    //         ->get();

    //     $detailed_stats = StatTrack::select('Stat_ids')
    //         ->where('tracking_type', 1)
    //         ->where('tracking_for', $match_fixture->competition_id)
    //         ->where('is_active', 1)
    //         ->latest()
    //         ->first();

    //     $stats_array = $detailed_stats ? explode(',', $detailed_stats->Stat_ids) : [];

    //     $player_detailed_stats = Sport_stat::select('id', 'name')
    //         ->whereIn('id', $stats_array)
    //         ->where('is_active', 1)
    //         ->get();

    //     $comp_admins = Comp_member::where('comp_id', $competition->id)
    //         ->where('member_position_id', 7)
    //         ->where('invitation_status', 1)
    //         ->where('is_active', 1)
    //         ->with('member')
    //         ->pluck('member_id');

    //     $admins = $comp_admins->toArray();
    //     array_push($admins, $competition->user_id);

    //     $team_admins = Team_member::where(function ($query) use ($teamOne, $teamTwo) {
    //         $query->where('team_id', $teamOne->id)
    //             ->orWhere('team_id', $teamTwo->id);
    //     })
    //         ->where('member_position_id', 4)
    //         ->where('invitation_status', 1)
    //         ->with('member')
    //         ->pluck('member_id');

    //     $team_admins_ids = $team_admins->toArray();
    //     array_push($team_admins_ids, $teamOne->user_id, $teamTwo->user_id);

    //     $all_admins = array_unique(array_merge($admins, $team_admins_ids));

    //     return view('frontend.match-fixture.view', compact('admins','player_stats','ground_map_position','match_fixture',
    //         'competition',
    //         'teamOne',
    //         'teamTwo',
    //         'teamTwo_attendees',
    //         'teamOne_attendees',
    //         'player_detailed_stats',
    //         'all_admins',
    //         'team_admins_ids'
    //     )
    //     );

    // }

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

    public function player_image(Request $request)
    {
        $players = explode(',', $request->players);
        $player_image = User::select('profile_pic')->where('id', $players[0])->first();
        $jersey_numebr = Team_member::select('jersey_number')->where('team_id', $request->team_id)->where('member_id', $players[0])->where('invitation_status', 1)->where('is_active', 1)->first();
        if (!empty($jersey_numebr)) {
            $j_num = $jersey_numebr->jersey_number;
        } else {
            $j_num = "";
        }

        return response()->json(['player_image' => $player_image, 'jersey_numebr' => $j_num]);
    }
    public function save_lineup_players(Request $request)
    {
        //return response()->json($request->selectedPlayerData);
        $competition = Match_fixture::select('competition_id')->find($request->match_fixture_id);
        $lineup_players = Competition::select('lineup_players_num')->find($competition->competition_id);

        if (count($request->selectedPlayerData) <= $lineup_players->lineup_players_num) {

            for ($i = 0; $i < count($request->selectedPlayerData); $i++) {
                $exits_player = Fixture_squad::select('id', 'player_id', 'match_fixture_id', 'team_id')->where('match_fixture_id', $request->match_fixture_id)->where('team_id', $request->team_id)->where('sport_ground_positions_id', $request->selectedPlayerData[$i]['postion'])->first();
                if (!empty($exits_player)) {
                    $fixture_squad = Fixture_squad::find($exits_player->id);
                    $fixture_squad->is_active = 2;
                    $fixture_squad->save();
                }
                $fixture_squad = new Fixture_squad();
                $fixture_squad->match_fixture_id = $request->match_fixture_id;
                $fixture_squad->team_id = $request->team_id;
                $fixture_squad->player_id = $request->selectedPlayerData[$i]['playerId'];
                $fixture_squad->sport_ground_positions_id = $request->selectedPlayerData[$i]['postion'];
                $fixture_squad->is_active = 1;
                $fixture_squad->save();
            }
            return response()->json('player_id');
        } else {
            return response()->json(['status' => 0, 'lineup_players' => $lineup_players->lineup_players_num]);
        }
    }

    public function fixture_squads_players(Request $request)
    {
        $players = explode(',', $request->players);
        $first_player_img_name = User::select('profile_pic')->where('id', $players[0])->first();
        $check1 = Fixture_squad::where('match_fixture_id', $request->match_fixture_id)->where('team_id', $request->team_id)->where('player_id', $players[0])->with('position', 'player')->first();
        $fixtures_lineup_player = Fixture_squad::where('match_fixture_id', $request->match_fixture_id)->where('team_id', $request->team_id)->count();
        $competition = Match_fixture::select('competition_id')->find($request->match_fixture_id);
        $lineup_players = Competition::select('lineup_players_num')->find($competition->competition_id);

        if ($fixtures_lineup_player < $lineup_players->lineup_players_num) {
            if (!empty($check1)) {
                $player_squad = $check1;
                $player_ground_positions_ids = SportGroundPosition::where('ground_coordinates', $request->ground_position)->pluck('id');
                $player_count = Fixture_squad::where('match_fixture_id', $request->match_fixture_id)->where('team_id', $request->team_id)->whereIn('sport_ground_positions_id', $player_ground_positions_ids)->count();
                return response()->json(['player_squad' => $player_squad, 'player_count' => $player_count]);
            } else {
                $fixture_squad = new Fixture_squad();
                $fixture_squad->match_fixture_id = $request->match_fixture_id;
                $fixture_squad->team_id = $request->team_id;
                $fixture_squad->player_id = $players[0];
                $fixture_squad->sport_ground_positions_id = $players[1];
                $fixture_squad->is_active = 1;
                $fixture_squad->save();
                $player_ground_positions_ids = SportGroundPosition::where('ground_coordinates', $request->ground_position)->pluck('id');
                $player_count = Fixture_squad::where('match_fixture_id', $request->match_fixture_id)->where('team_id', $request->team_id)->whereIn('sport_ground_positions_id', $player_ground_positions_ids)->count();
                return response()->json(['new' => $fixture_squad, 'player_count' => $player_count, 'first_player_img_name' => $first_player_img_name]);
            }
        } else {
            return response()->json(['lineup_players' => $lineup_players->lineup_players_num]);
        }
    }
    public function change_squad_player_position(Request $request)
    {
        $players = explode(',', $request->players);
        $player_on_exist_position = Fixture_squad::where('match_fixture_id', $request->match_fixture_id)->where('team_id', $request->team_id)->where('sport_ground_positions_id', $players[1])->where('is_active', 1)->first();
        $first_player_img_name = User::select('profile_pic')->where('id', $players[0])->first();
        if (!empty($player_on_exist_position)) {
            $exist_player_id = $player_on_exist_position->player_id;
            $old_position = '';
            $update_player_position = Fixture_squad::find($request->fixture_squad_id);
            $update_player_position->player_id = $exist_player_id;
            $update_player_position->is_active = 1;
            $update_player_position->save();

            $update_exist_player = Fixture_squad::find($player_on_exist_position->id);
            $update_exist_player->player_id = $players[0];
            $update_exist_player->save();
        } else {
            $delete_player_position = Fixture_squad::find($request->fixture_squad_id);
            $old_position = $delete_player_position->sport_ground_positions_id;
            $delete_player_position->delete();
            $fixture_squad = new Fixture_squad();
            $fixture_squad->match_fixture_id = $request->match_fixture_id;
            $fixture_squad->team_id = $request->team_id;
            $fixture_squad->player_id = $players[0];
            $fixture_squad->sport_ground_positions_id = $players[1];
            $fixture_squad->is_active = 1;
            $fixture_squad->save();
        }


        $player_info = Fixture_squad::with('position', 'player')->find($request->fixture_squad_id);
        return response()->json(['player_info' => $player_info, 'first_player_img_name' => $first_player_img_name, 'old_position' => $old_position]);
    }
    public function find_position_player(Request $request)
    {
        $players = explode(',', $request->players);
        $player = Fixture_squad::where('match_fixture_id', $request->match_fixture_id)->where('team_id', $request->team_id)->where('sport_ground_positions_id', $players[1])->where('is_active', 1)->with('position')->first();
        $old_position = SportGroundPosition::find($players[1]);
        if (!empty($player)) {
            $option_val = $player->player_id . ',' . $player->sport_ground_positions_id;
            $gmp_position = $player->position->name;
        } else {
            $option_val = "";
            $gmp_position = $old_position->name;
        }
        $first_player_img_name = User::select('profile_pic')->where('id', $players[0])->first();
        return response()->json(['option_val' => $option_val, 'gmp_position' => $gmp_position, 'first_player_img_name' => $first_player_img_name]);
    }

    // public function fixture_squads_players(Request $request)
    // {
    // $players = explode(',',$request->players);
    // $check1 = Fixture_squad::where('match_fixture_id',$request->match_fixture_id)->where('team_id',$request->team_id)->where('player_id',$players[0])->value('id');
    // $check2 = Fixture_squad::where('match_fixture_id',$request->match_fixture_id)->where('team_id',$request->team_id)->where('sport_ground_positions_id',$players[1])->value('id');

    // if($check1)
    // {
    // $player_squad = Fixture_squad::find($check1);
    // return response(['exist_player' => $player_squad]);
    // }
    // elseif($check2)
    // {
    // $fixture_squad = Fixture_squad::find($check2);
    // $fixture_squad->player_id = $players[0];
    // $fixture_squad->save();
    // return response(['update_player' => $fixture_squad]);

    // }
    // else
    // {
    // $fixture_squad = new Fixture_squad();
    // $fixture_squad->match_fixture_id =  $request->match_fixture_id;
    // $fixture_squad->team_id =  $request->team_id;
    // $fixture_squad->player_id =  $players[0];
    // $fixture_squad->sport_ground_positions_id =  $players[1];
    // $fixture_squad->save();
    // return response()->json(['new' => $fixture_squad]);
    // }



    // }

    public function submit_fixture_squad(Request $request)
    {
        //return response()->json($request->players);
        $data = array_values(array_filter($request->players));
        $match_comp_id = Match_fixture::select('competition_id', 'startdate_time')->find($request->match_fixture_id);
        $comp_lineUpnum = Competition::select('lineup_players_num')->find($match_comp_id->competition_id);

        $match_fix_id = $request->match_fixture_id;
        $team_id = $request->team_id;

        // $stored_fixtures = Fixture_squad::where('match_fixture_id',$match_fix_id)->where('team_id',$team_id)->delete();
        // foreach($stored_fixtures as $sdata){
        // 	$delete = Fixture_squad::delete($sdata->id);
        // }

        if (count($data) == $comp_lineUpnum->lineup_players_num) {
            //return response()->json(count($data));

            $player_ids_array = array();
            for ($x = 0; $x < count($data); $x++) {
                $players = explode(',', $data[$x]);
                $player_ids_array[] = $players[0];
            }

            $result = array();
            for ($x = 0; $x < count($data); $x++) {
                $players = explode(',', $data[$x]);
                $fixture_count = Fixture_squad::where('match_fixture_id', $request->match_fixture_id)->where('team_id', $request->team_id)->count();
                //return response()->json($check);
                if ($fixture_count > 0 && $fixture_count >= $comp_lineUpnum->lineup_players_num) {
                    $swap_lineup_players = Fixture_squad::select('id', 'match_fixture_id', 'team_id', 'player_id')->where('match_fixture_id', $request->match_fixture_id)->where('team_id', $request->team_id)->where('player_id', $players[0])->first();
                    // return $swap_lineup_players;
                    if (!empty($swap_lineup_players)) {
                        $result[] = "update-" . $players[0];
                        $fixture_squad = Fixture_squad::find($swap_lineup_players->id);
                        $fixture_squad->sport_ground_positions_id = $players[1];
                        $fixture_squad->is_active = 1;
                        $fixture_squad->save();
                    } else {
                        $swap_subtitute_player = Fixture_squad::select('id', 'player_id', 'match_fixture_id', 'team_id', 'sport_ground_positions_id')->where('match_fixture_id', $request->match_fixture_id)->where('team_id', $request->team_id)->where('sport_ground_positions_id', $players[1])->first();

                        if (!empty($swap_subtitute_player)) {
                            // $result[] = "update-" . $players[0];
                            // $existfixture_squad = fixture_squad::find($swap_subtitute_player->id);
                            // $existfixture_squad->is_active = 2;
                            // $existfixture_squad->save();
                            $check_fixture_halftype = Match_fixture_stat::where('match_fixture_id', $request->match_fixture_id)->where('sport_stats_id', 14)->latest()->first();

                            if (!empty($check_fixture_halftype)) {
                                $fixture_half_type = 2;
                            } else {
                                $fixture_half_type = 1;
                            }

                            $existfixture_squad_player = fixture_squad::find($swap_subtitute_player->id);
                            if ($match_comp_id->startdate_time != '') {
                                $substitue_player = new Fixture_substitute();
                                $substitue_player->match_fixture_id = $existfixture_squad_player->match_fixture_id;
                                $substitue_player->team_id = $existfixture_squad_player->team_id;
                                $substitue_player->player_id = $existfixture_squad_player->player_id;
                                $substitue_player->sub_player_id = $players[0];
                                $substitue_player->half_type = $fixture_half_type;
                                $substitue_player->save();

                                $fixture_stat = new Match_fixture_stat();
                                $fixture_stat->match_fixture_id = $existfixture_squad_player->match_fixture_id;
                                $fixture_stat->team_id = $existfixture_squad_player->team_id;
                                $fixture_stat->player_id = $existfixture_squad_player->player_id;
                                $fixture_stat->stat_type = 3;
                                $fixture_stat->sport_stats_id = 53;
                                $fixture_stat->fixture_substitute_id = $substitue_player->id;
                                $fixture_stat->competition_id = $match_comp_id->competition_id;
                                $fixture_stat->stat_time = $request->stattime;
                                $fixture_stat->half_type = $fixture_half_type;
                                $fixture_stat->save();

                                $result[] = "new-" . $players[0];
                                $fixture_squad = new Fixture_squad();
                                $fixture_squad->match_fixture_id = $request->match_fixture_id;
                                $fixture_squad->team_id = $request->team_id;
                                $fixture_squad->player_id = $players[0];
                                $fixture_squad->sport_ground_positions_id = $players[1];
                                $fixture_squad->is_active = 1;
                                $fixture_squad->save();

                                $existfixture_squad = fixture_squad::find($swap_subtitute_player->id);
                                $existfixture_squad->delete();

                                if ($fixture_half_type == 1) {
                                    $latest_fixture_stat = Match_fixture_stat::where('match_fixture_id', $existfixture_squad_player->match_fixture_id)->where('sport_stats_id', 12)->latest()->first();
                                    $last_dateTimeObject1 = date_create($latest_fixture_stat->stat_time);
                                    $last_dateTimeObject2 = date_create($fixture_stat->stat_time);
                                    $difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
                                    $stat_time_record = $difference->format('%H:%I:%S');

                                    $first_half_total_pause = Match_fixture_lapse::where('match_fixture_id', $existfixture_squad_player->match_fixture_id)->where('lapse_type', 5)->get();
                                    $collect_lapse_diff_time = array();
                                    foreach ($first_half_total_pause as $tttt) {
                                        $collect_lapse_diff_time[] = strtotime($tttt->lapse_diff);
                                    }
                                    $sum_lapse_time = array_sum($collect_lapse_diff_time);
                                    $lapse_diff = date("i:s", $sum_lapse_time);

                                    $update_stat = Match_fixture_stat::find($fixture_stat->id);
                                    $update_stat->stat_diff = $lapse_diff;
                                    $update_stat->stat_time_record = $stat_time_record;
                                    $update_stat->save();
                                } else {

                                    $check_halftype = Match_fixture_stat::where('match_fixture_id', $existfixture_squad_player->match_fixture_id)->where('sport_stats_id', 14)->latest()->first();
                                    if (!empty($check_halftype)) {

                                        $second_half_total_pause = Match_fixture_lapse::where('match_fixture_id', $existfixture_squad_player->match_fixture_id)->where('lapse_type', 8)->get();

                                        $collect_lapse_diff_time = array();
                                        foreach ($second_half_total_pause as $tttt) {
                                            $collect_lapse_diff_time[] = strtotime($tttt->lapse_diff);
                                        }
                                        $sum_lapse_time = array_sum($collect_lapse_diff_time);

                                        $lapse_diff = date("i:s", $sum_lapse_time);

                                        $last_dateTimeObject1 = date_create($check_halftype->stat_time);
                                        $last_dateTimeObject2 = date_create($fixture_stat->stat_time);
                                        $difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
                                        // $stat_diff =  $difference->format('%H:%I:%S');
                                        $stat_time_record = $difference->format('%H:%I:%S');

                                        $update_stat = Match_fixture_stat::find($fixture_stat->id);
                                        $update_stat->stat_diff = $lapse_diff;
                                        $update_stat->stat_time_record = $stat_time_record;
                                        $update_stat->save();
                                    }
                                }
                            } else {
                                $existfixture_squad = fixture_squad::find($swap_subtitute_player->id);
                                $existfixture_squad->delete();
                            }
                        } else {

                            $check_exist_players_count = Fixture_squad::where('match_fixture_id', $request->match_fixture_id)->where('team_id', $request->team_id)->count();
                            $check_isPlayer_exist_onground = Fixture_squad::where('match_fixture_id', $request->match_fixture_id)->where('team_id', $request->team_id)->where('player_id', $players[0])->count();

                            if ($check_exist_players_count == $comp_lineUpnum->lineup_players_num && $check_isPlayer_exist_onground == 0) {

                                $delete_all_fixture_squad = Fixture_squad::where('match_fixture_id', $request->match_fixture_id)->where('team_id', $request->team_id)->whereNotIn('player_id', $player_ids_array)->delete();

                                $result[] = "new-" . $players[0];
                                $fixture_squad = new Fixture_squad();
                                $fixture_squad->match_fixture_id = $request->match_fixture_id;
                                $fixture_squad->team_id = $request->team_id;
                                $fixture_squad->player_id = $players[0];
                                $fixture_squad->sport_ground_positions_id = $players[1];
                                $fixture_squad->is_active = 1;
                                $fixture_squad->save();
                            } else {
                                if ($check_exist_players_count <= $comp_lineUpnum->lineup_players_num) {

                                    $result[] = "new-" . $players[0];
                                    $fixture_squad = new Fixture_squad();
                                    $fixture_squad->match_fixture_id = $request->match_fixture_id;
                                    $fixture_squad->team_id = $request->team_id;
                                    $fixture_squad->player_id = $players[0];
                                    $fixture_squad->sport_ground_positions_id = $players[1];
                                    $fixture_squad->is_active = 1;
                                    $fixture_squad->save();
                                }
                            }
                        }
                    }
                } else {
                    $result[] = "new-" . $players[0];
                    $fixture_squad = new Fixture_squad();
                    $fixture_squad->match_fixture_id = $request->match_fixture_id;
                    $fixture_squad->team_id = $request->team_id;
                    $fixture_squad->player_id = $players[0];
                    $fixture_squad->sport_ground_positions_id = $players[1];
                    $fixture_squad->is_active = 1;
                    $fixture_squad->save();
                }
            }
            return response()->json(['fixture_squad' => $fixture_squad, 'result' => $result]);
        } else {
            return response()->json(['comp_lineUpnum' => $comp_lineUpnum->lineup_players_num]);
        }
    }


    public function player_info_fixture(Request $request)
    {
        $cal_currentdatetime = strtotime(now());
        $currentdatetime = date('Y-m-d H:i:s', $cal_currentdatetime);
        $players = explode(',', $request->player_id);
        $player_info = User::select('id', 'first_name', 'last_name', 'profile_pic')->find($players[0]);
        $team = Team::select('id', 'team_logo')->find($players[1]);
        $fixture_position = Fixture_squad::select('id', 'sport_ground_positions_id')->where('team_id', $players[1])->where('match_fixture_id', $request->match_fixture_id)->where('player_id', $players[0])->with('position')->get();

        $stat_count = Match_fixture_stat::select('id', 'competition_id', 'sport_stats_id')->where('match_fixture_id', $request->match_fixture_id)->where('player_id', $players[0])->where('team_id', $players[1])->get();
        $player_stats = Sport_stat::select('id')->whereIn('stat_type_id', [0, 1])->get();
        $competition = Match_fixture::select('competition_id')->find($request->match_fixture_id);
        $comp_report_type = Competition::select('report_type')->find($competition->competition_id);

        $stat_data = array();
        foreach ($player_stats as $stat) {
            $stat_data[$stat->id] = Match_fixture_stat::where('match_fixture_id', $request->match_fixture_id)->where('player_id', $players[0])->where('team_id', $players[1])->where('sport_stats_id', $stat->id)->count();
        }

        return response()->json(['player_info' => $player_info, 'fixture_position' => $fixture_position, 'team' => $team, 'stat_data' => $stat_data, 'stat_count' => $stat_count, 'comp_report_type' => $comp_report_type, 'currentdatetime' => $currentdatetime]);
    }

    public function ownGoal_statTime(Request $request)
    {
        $data = $request->time;
        if ($data == "currenttime") {
            $nowTime = now();
            return response()->json(['status' => 1, 'nowtime' => $nowTime]);
        }
    }

    public function fixture_stat(Request $request)
    {
        // return response()->json($request);
        $match_fixture = Match_fixture::find($request->match_fixture_id);
        //$fixture_lapse_type = Match_fixture_lapse::where('match_fixture_id',$request->match_fixture_id)->orderBy('id', 'desc')->latest()->first();
        $latest_fixture_stat = Match_fixture_stat::where('match_fixture_id', $request->match_fixture_id)->where('sport_stats_id', 12)->latest()->first();

        $check = Match_fixture_stat::where('match_fixture_id', $request->match_fixture_id)->where('team_id', $request->team_id)->whereIn('stat_type', [0, 1])->where('player_id', $request->player_id)->get();

        $competition = Competition::find($match_fixture->competition_id);

        $red_card = Match_fixture_stat::where('match_fixture_id', $request->match_fixture_id)->where('team_id', $request->team_id)->whereIn('stat_type', [0, 1])->where('player_id', $request->player_id)->where('sport_stats_id', 3)->get();
        $yellow_card = Match_fixture_stat::where('match_fixture_id', $request->match_fixture_id)->where('team_id', $request->team_id)->whereIn('stat_type', [0, 1])->where('player_id', $request->player_id)->where('sport_stats_id', 2)->get();

        $team = Team::find($request->team_id);
        if (!empty($latest_fixture_stat)) {
            if ($latest_fixture_stat->sport_stats_id != 13) {
                if ($latest_fixture_stat->sport_stats_id != 15) {
                    if ($check->IsNotEmpty()) {
                        if ($red_card->count() == 1) {
                            return response()->json(['red_card' => $red_card, 'team' => $team]);
                        } elseif ($yellow_card->count() == 2) {
                            return response()->json(['yellow_card' => $yellow_card, 'team' => $team]);
                        } else {

                            $check_halftype = Match_fixture_stat::where('match_fixture_id', $request->match_fixture_id)->where('sport_stats_id', 14)->latest()->first();

                            if (!empty($check_halftype)) {
                                $half_type = 2;
                            } else {
                                $half_type = 1;
                            }

                            $fixture_stat = new Match_fixture_stat();
                            $fixture_stat->match_fixture_id = $request->match_fixture_id;
                            $fixture_stat->team_id = $request->team_id;
                            $fixture_stat->player_id = $request->player_id;
                            $fixture_stat->sport_stats_id = $request->stat_id;
                            if ($request->stat_id == 54) {
                                $fixture_stat->stat_type = 4;
                                $fixture_stat->ression = $request->ownGoal_ression;
                            }
                            $fixture_stat->competition_id = $match_fixture->competition_id;
                            $fixture_stat->stat_time = $request->statdatetime;
                            $fixture_stat->half_type = $half_type;
                            $fixture_stat->save();
                        }
                    } else {
                        $check_halftype = Match_fixture_stat::where('match_fixture_id', $request->match_fixture_id)->where('sport_stats_id', 14)->latest()->first();


                        if (!empty($check_halftype)) {
                            $half_type = 2;
                        } else {
                            $half_type = 1;
                        }
                        $fixture_stat = new Match_fixture_stat();
                        $fixture_stat->match_fixture_id = $request->match_fixture_id;
                        $fixture_stat->team_id = $request->team_id;
                        $fixture_stat->player_id = $request->player_id;
                        $fixture_stat->sport_stats_id = $request->stat_id;
                        if ($request->stat_id == 54) {
                            $fixture_stat->stat_type = 4;
                            $fixture_stat->reason = $request->ownGoal_ression;
                        }
                        $fixture_stat->competition_id = $match_fixture->competition_id;
                        $fixture_stat->stat_time = $request->statdatetime;
                        $fixture_stat->half_type = $half_type;
                        $fixture_stat->save();
                    }

                    $count_fixture_stat = Match_fixture_stat::where('match_fixture_id', $request->match_fixture_id)->count();
                    //dd($count_pause_lapse_time);
                    if ($count_fixture_stat == 1) {
                        $dateTimeObject1 = date_create($match_fixture->startdate_time);
                        $dateTimeObject2 = date_create($fixture_stat->stat_time);
                        $difference = date_diff($dateTimeObject1, $dateTimeObject2);
                        $stat_diff = $difference->format('%H:%I:%S');
                    } else {
                        //enter manual time by comp admin
                        $last_dateTimeObject1 = date_create($latest_fixture_stat->stat_time);
                        $last_dateTimeObject2 = date_create($fixture_stat->stat_time);
                        $difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
                        $stat_diff = $difference->format('%H:%I:%S');
                    }

                    // $update_fixture_stat = Match_fixture_stat::find($fixture_stat->id);
                    // $update_fixture_stat->stat_diff = $stat_diff;
                    // $update_fixture_stat->save();

                    // $all_fixture_stat = Match_fixture_stat::where('match_fixture_id', $request->match_fixture_id)->where('half_type', $half_type)->get();
                    // $collect_stat_diff_time =  array();
                    // foreach ($all_fixture_stat as $tttt) {
                    //     $collect_stat_diff_time[] =  strtotime($tttt->stat_diff);
                    // }
                    // $sum_stat_time = array_sum($collect_stat_diff_time);

                    // $stat_time_record = date("i:s", $sum_stat_time);
                    // $update_fixture_stat_record = Match_fixture_stat::find($fixture_stat->id);
                    // $update_fixture_stat_record->stat_time_record = $stat_time_record;
                    // $update_fixture_stat_record->save();





                    $last_dateTimeObject1 = date_create($latest_fixture_stat->stat_time);
                    $last_dateTimeObject2 = date_create($fixture_stat->stat_time);
                    $difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
                    $stat_time_record = $difference->format('%H:%I:%S');

                    $first_half_total_pause = Match_fixture_lapse::where('match_fixture_id', $match_fixture->id)->where('lapse_type', 5)->get();

                    $collect_lapse_diff_time = array();
                    foreach ($first_half_total_pause as $tttt) {
                        $collect_lapse_diff_time[] = strtotime($tttt->lapse_diff);
                    }
                    $sum_lapse_time = array_sum($collect_lapse_diff_time);

                    $lapse_diff = date("i:s", $sum_lapse_time);

                    $competition_half_time = $competition->competition_half_time;

                    $explode_lapse_diff = explode(':', $lapse_diff);
                    if (count($explode_lapse_diff) > 2) {

                        $cal_lapse_diff_time = ($explode_lapse_diff[0] * 3600) + $explode_lapse_diff[1] * 60 + $explode_lapse_diff[2];
                    } else {
                        $cal_lapse_diff_time = ($explode_lapse_diff[0] * 60) + $explode_lapse_diff[1];
                    }

                    $explode_stat_time_record = explode(':', $stat_time_record);
                    $cal_stat_time_record = $explode_stat_time_record[0] * 3600 + $explode_stat_time_record[1] * 60 + $explode_stat_time_record[2];
                    $cal_stat_time = $cal_stat_time_record - $cal_lapse_diff_time;

                    $cal_days = floor($cal_stat_time / (60 * 60 * 24)); //day
                    $cal_stat_time %= (60 * 60 * 24);
                    $cal_hours = floor($cal_stat_time / (60 * 60)); //hour
                    $cal_stat_time %= (60 * 60);
                    $cal_min = floor($cal_stat_time / 60); //min
                    $cal_stat_time %= 60;
                    $cal_sec = $cal_stat_time;

                    if ($cal_min >= $competition_half_time) {
                        $calStat_record_time = $cal_stat_time_record - $cal_sec;
                        $calDays1 = floor($calStat_record_time / (60 * 60 * 24)); //day
                        $calStat_record_time %= (60 * 60 * 24);
                        $calHours1 = floor($calStat_record_time / (60 * 60)); //hour
                        $calStat_record_time %= (60 * 60);
                        $calMin1 = floor($calStat_record_time / 60); //min
                        $calStat_record_time %= 60;
                        $calSec1 = $calStat_record_time;
                        if ($calHours1 < 10) {
                            $h_zeros1 = '0' . $calHours1;
                        } elseif ($calHours1 == 0) {
                            $h_zeros1 = '00';
                        } else {
                            $h_zeros1 = '';
                        }
                        if ($calSec1 < 10) {
                            $s_zeros1 = '0';
                        } else {
                            $s_zeros1 = '';
                        }
                        if ($calMin1 < 10) {
                            $s_zerom1 = '0';
                        } else {
                            $s_zerom1 = '';
                        }
                        $stat_record_time = $h_zeros1 . ':' . $s_zerom1 . $calMin1 . ':' . $s_zeros1 . $calSec1;
                    } else {
                        $stat_record_time = $stat_time_record;
                    }



                    $update_stat = Match_fixture_stat::find($fixture_stat->id);
                    $update_stat->stat_diff = $lapse_diff;
                    $update_stat->stat_time_record = $stat_record_time;
                    $update_stat->save();

                    if (!empty($check_halftype)) {

                        $second_half_total_pause = Match_fixture_lapse::where('match_fixture_id', $match_fixture->id)->where('lapse_type', 8)->get();

                        $collect_lapse_diff_time = array();
                        foreach ($second_half_total_pause as $tttt) {
                            $collect_lapse_diff_time[] = strtotime($tttt->lapse_diff);
                        }
                        $sum_lapse_time = array_sum($collect_lapse_diff_time);

                        $lapse_diff = date("i:s", $sum_lapse_time);

                        $last_dateTimeObject1 = date_create($check_halftype->stat_time);
                        $last_dateTimeObject2 = date_create($fixture_stat->stat_time);
                        $difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
                        // $stat_diff =  $difference->format('%H:%I:%S');
                        $stat_time_record = $difference->format('%H:%I:%S');


                        $competition_half_time = $competition->competition_half_time;

                        $explode_lapse_diff = explode(':', $lapse_diff);
                        if (count($explode_lapse_diff) > 2) {

                            $cal_lapse_diff_time = ($explode_lapse_diff[0] * 3600) + $explode_lapse_diff[1] * 60 + $explode_lapse_diff[2];
                        } else {
                            $cal_lapse_diff_time = ($explode_lapse_diff[0] * 60) + $explode_lapse_diff[1];
                        }

                        $explode_stat_time_record = explode(':', $stat_time_record);
                        $cal_stat_time_record = $explode_stat_time_record[0] * 3600 + $explode_stat_time_record[1] * 60 + $explode_stat_time_record[2];
                        $cal_stat_time = $cal_stat_time_record - $cal_lapse_diff_time;

                        $cal_day2s = floor($cal_stat_time / (60 * 60 * 24)); //day
                        $cal_stat_time %= (60 * 60 * 24);
                        $cal_hour2s = floor($cal_stat_time / (60 * 60)); //hour
                        $cal_stat_time %= (60 * 60);
                        $cal_min2 = floor($cal_stat_time / 60); //min
                        $cal_stat_time %= 60;
                        $cal_sec2 = $cal_stat_time;

                        if ($cal_min2 >= $competition_half_time) {
                            $calStat_record_time = $cal_stat_time_record - $cal_sec2;
                            $calDays = floor($calStat_record_time / (60 * 60 * 24)); //day
                            $calStat_record_time %= (60 * 60 * 24);
                            $calHours = floor($calStat_record_time / (60 * 60)); //hour
                            $calStat_record_time %= (60 * 60);
                            $calMin = floor($calStat_record_time / 60); //min
                            $calStat_record_time %= 60;
                            $calSec = $calStat_record_time;
                            if ($calHours < 10) {
                                $h_zeros = '0' . $calHours;
                            } elseif ($calHours == 0) {
                                $h_zeros = '00';
                            } else {
                                $h_zeros = '';
                            }
                            if ($calSec < 10) {
                                $s_zeros = '0';
                            } else {
                                $s_zeros = '';
                            }
                            if ($calMin < 10) {
                                $s_zerom = '0';
                            } else {
                                $s_zerom = '';
                            }
                            $stat_record_time = $h_zeros . ':' . $s_zerom . $calMin . ':' . $s_zeros . $calSec;
                        } else {
                            $stat_record_time = $stat_time_record;
                        }

                        $update_stat = Match_fixture_stat::find($fixture_stat->id);
                        $update_stat->stat_diff = $lapse_diff;
                        $update_stat->stat_time_record = $stat_record_time;
                        $update_stat->save();
                    }


                    return response()->json(['status' => 1, 'fixture_stat' => $fixture_stat, 'team' => $team, 'stattime' => $stat_record_time]);
                } else {
                    return response()->json(0);
                }
            } else {
                return response()->json(0);
            }
        } else {
            return response()->json(0);
        }
    }

    public function autosearch_refree_name()
    {
        return "hello";
    }
    public function substitutePLayer(Request $request)
    {
        if ($request->fromSubstitude && $request->fromSubstitudePositionId && $request->fromSubstitudeTeamId && $request->match_fixture_id && $request->substitudeDesc && $request->toSubstitute && $request->toSubstitutePositionId && $request->toSubstituteTeamId) {
            //replacement from player details
            $fromSubstitute = Fixture_squad::where('match_fixture_id', $request->match_fixture_id)->where('team_id', $request->toSubstituteTeamId)->where('player_id', $request->toSubstitute)->first();
            if (!$fromSubstitute) {
                $fromSubstitute = new Fixture_squad();
                $fromSubstitute->match_fixture_id = $request->match_fixture_id;
                $fromSubstitute->team_id = $request->toSubstituteTeamId;
                $fromSubstitute->player_id = $request->toSubstitute;
            }

            $fromSubstitute->sport_ground_positions_id = $request->toSubstitutePositionId;
            $fromSubstitute->is_active = 2; //For now
            $fromSubstitute->status_desc = $request->substitudeDesc;
            $fromSubstitute->save();

            //new player in groud details
            $toSubstitute = Fixture_squad::where('match_fixture_id', $request->match_fixture_id)->where('team_id', $request->fromSubstitudeTeamId)->where('player_id', $request->fromSubstitude)->first();
            if (!$toSubstitute) {
                $toSubstitute = new Fixture_squad();
                $toSubstitute->match_fixture_id = $request->match_fixture_id;
                $toSubstitute->team_id = $request->fromSubstitudeTeamId;
                $toSubstitute->player_id = $request->fromSubstitude;
            }

            $toSubstitute->sport_ground_positions_id = $request->fromSubstitudePositionId;
            $toSubstitute->is_active = 1; //For now
            $toSubstitute->status_desc = 'This Player is substitute by ' . $request->toSubstitute;
            $toSubstitute->save();
            return response()->json(['status' => 200, 'message' => 'Substitute Update Successfully.', 'result' => null]);
        } else {
            return response()->json(['status' => 501, 'result' => null, 'message' => 'Error in request. request can`t fullfilled the request parameter.']);
        }
    }
}
