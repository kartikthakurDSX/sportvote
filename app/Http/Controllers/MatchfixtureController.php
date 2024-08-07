<?php

namespace App\Http\Controllers;
use App\Models\Match_fixture;
use App\Models\Competition;
use App\Models\Competition_attendee;
use App\Models\SportGroundPosition;
use App\Models\Team;
use App\Models\Fixture_squad;
use App\Models\User;
use App\Models\Sport_stat;
use App\Models\Match_fixture_stat;
use App\Models\Match_fixture_lapse;
use App\Models\Comp_member;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class MatchfixtureController extends Controller
{

    public function index()
    {

      return view('frontend.match-fixture.match_page'); // not used
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
        return "this ";
        $match_fixture = Match_fixture::find($id);
        $competition = Competition::find($match_fixture->competition_id);
        $teamOne = Team::find($match_fixture->teamOne_id);
        $teamTwo = Team::find($match_fixture->teamTwo_id);
        $teamOne_attendees = Competition_attendee::where('team_id',$teamOne->id)->where('competition_id',$match_fixture->competition_id)->get();
        $teamTwo_attendees = Competition_attendee::where('team_id',$teamTwo->id)->where('competition_id',$match_fixture->competition_id)->get();
        $ground_map_position = SportGroundPosition::all();
        $fixture_squad_teamOne = Fixture_squad::where('match_fixture_id',$match_fixture->id)->where('team_id',$teamOne->id)->get();
        $fixture_squad_teamTwo = Fixture_squad::where('match_fixture_id',$match_fixture->id)->where('team_id',$teamTwo->id)->get();
		$fixture_lapse_type = Match_fixture_lapse::where('match_fixture_id',$match_fixture->id)->orderBy('id', 'desc')->latest()->first();
        $player_stats = Sport_stat::whereIn('stat_type_id',[0,1])->get();

        // $fixture_stat_record = Match_fixture_stat::where('match_fixture_id',$match_fixture->id)->get();
        $team_stats = Sport_stat::where('stat_type_id',2)->get();
		$comp_admins = Comp_member::where('comp_id',$competition->id)->where('member_position_id',7)->where('invitation_status',1)->with('member')->pluck('member_id');
		$admins = $comp_admins->toArray();


		return view('frontend.match-fixture.view',compact('admins','fixture_lapse_type','team_stats','player_stats','fixture_squad_teamOne','fixture_squad_teamTwo','ground_map_position','match_fixture','competition','teamOne','teamTwo','teamTwo_attendees','teamOne_attendees',));



      // return view('frontend.match-fixture.view',compact('team_stats','player_stats','fixture_squad_teamOne','fixture_squad_teamTwo','ground_map_position','match_fixture','competition','teamOne','teamTwo','teamTwo_attendees','teamOne_attendees'));
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

    public function fixture_squads_players(Request $request)
    {
       $players = explode(',',$request->players);
       $check1 = Fixture_squad::where('match_fixture_id',$request->match_fixture_id)->where('team_id',$request->team_id)->where('player_id',$players[0])->value('id');
       $check2 = Fixture_squad::where('match_fixture_id',$request->match_fixture_id)->where('team_id',$request->team_id)->where('sport_ground_positions_id',$players[1])->value('id');

       if($check1)
        {
            $player_squad = Fixture_squad::find($check1);
            return response(['exist_player' => $player_squad]);
        }
        elseif($check2)
        {
            $fixture_squad = Fixture_squad::find($check2);
            $fixture_squad->player_id = $players[0];
            $fixture_squad->save();
            return response(['update_player' => $fixture_squad]);

        }
        else
        {
            $fixture_squad = new Fixture_squad();
            $fixture_squad->match_fixture_id =  $request->match_fixture_id;
            $fixture_squad->team_id =  $request->team_id;
            $fixture_squad->player_id =  $players[0];
            $fixture_squad->sport_ground_positions_id =  $players[1];
            $fixture_squad->save();
            return response()->json(['new' => $fixture_squad]);
        }



    }

    public function submit_fixture_squad(Request $request)
    {
        // return response()->json($request);
        if($request->players)
        {
            for ($x = 0; $x < count($request->players); $x++)
            {
                if($request->players[$x])
                {
                    $players = explode(',',$request->players[$x]);
                    $check = Fixture_squad::where('match_fixture_id',$request->match_fixture_id)->where('team_id',$request->team_id)->where('player_id',$players[0])->where('sport_ground_positions_id',$players[1])->value('id');
                    $check2 = Fixture_squad::where('match_fixture_id',$request->match_fixture_id)->where('team_id',$request->team_id)->where('sport_ground_positions_id',$players[1])->value('id');
                    if($check)
                    {
                        $fixture_squad = Fixture_squad::find($check);
                        $fixture_squad->is_active = 1;
                        $fixture_squad->save();
                        return response()->json('is_active');
                    }
                    elseif($check2)
                    {
                        $fixture_squad = Fixture_squad::find($check2);
                        $fixture_squad->player_id = $players[0];
                        $fixture_squad->is_active = 1;
                        $fixture_squad->save();
                        return response()->json('update_player_id');
                    }
                    else
                    {
                        return response()->json('0');

                    }
                }


            }

        }

    }


    public function player_info_fixture(Request $request)
    {
        $players = explode(',',$request->player_id);
        $player_info = User::find($players[0]);
        $team = Team::find($players[1]);
        $fixture_position = Fixture_squad::where('team_id', $players[1])->where('match_fixture_id',$request->match_fixture_id)->where('player_id',$players[0])->with('position')->get();
        return response()->json(['player_info'=>$player_info, 'fixture_position' => $fixture_position,'team' => $team]);
    }

    public function fixture_stat(Request $request)
    {
        // return response()->json($request);
        $match_fixture = Match_fixture::find($request->match_fixture_id);
		$competition_id = $match_fixture->competition_id;
        $dateTimeObject1 = date_create($match_fixture->startdate_time);
        $dateTimeObject2 = now();
        $difference = date_diff($dateTimeObject1, $dateTimeObject2);

      // $minutes = $difference->days * 24 * 60;
        // $minutes += $difference->h * 60;
        // $minutes += $difference->i;
        // $stat_record_time = $minutes;
        $stat_record_time = $difference->i.':' . $difference->s;


        $fixture_stat = new Match_fixture_stat();
        $fixture_stat->match_fixture_id = $request->match_fixture_id;
		$fixture_stat->competition_id = $competition_id;
        $fixture_stat->team_id = $request->team_id;
        $fixture_stat->player_id = $request->player_id;
        $fixture_stat->sport_stats_id = $request->stat_id;
        $fixture_stat->stat_time_record = $stat_record_time;
        $fixture_stat->save();

        $team = Team::find($request->team_id);
        return response()->json(['fixture_stat' => $fixture_stat , 'team' => $team]);

    }

    public function updateStats(Request $request, $id)
    {
        // covert json string to json in laravel?
        $data = $request->data;
        if (!is_array($data)) {
            $data = json_decode($data);
        }

        foreach ($data as $a) {
            foreach ($a->playerStat as $b) {
                $length = count($b->statData);
                $playerStats = Match_fixture_stat::where('match_fixture_id', $a->matchFixture)->where('competition_id', $a->CompetitionId)->where('team_id', $a->teamId)->where('stat_type', 1)->where('player_id', $a->playerId)->where('sport_stats_id', $b->statId)->where('is_active', 1)->get();
                // echo $length .'-'. count($playerStats);
                if ($length || count($playerStats)) {
                    if ($length == count($playerStats)) {
                        // return "equal";
                        $this->updateMatchStatBasedOnPlayer($playerStats, $b);
                    } else {
                        if ($length > count($playerStats)) {
                            $effectedCount = $length - count($playerStats);
                            for ($i = 0; $i < $effectedCount; $i++) {
                                # code...
                                $newPlayerStat = new Match_fixture_stat();
                                $newPlayerStat->match_fixture_id = $a->matchFixture;
                                $newPlayerStat->competition_id = $a->CompetitionId;
                                $newPlayerStat->team_id = $a->teamId;
                                $newPlayerStat->stat_time = new Carbon();
                                $newPlayerStat->stat_type = 1;
                                $newPlayerStat->player_id = $a->playerId;
                                $newPlayerStat->sport_stats_id = $b->statId;
                                $newPlayerStat->is_active = 1;
                                $newPlayerStat->half_type = $a->halfType;
                                $newPlayerStat->save();
                            }
                            $length = count($b->statData);
                            $playerStats = Match_fixture_stat::where('match_fixture_id', $a->matchFixture)->where('competition_id', $a->CompetitionId)->where('team_id', $a->teamId)->where('stat_type', 1)->where('player_id', $a->playerId)->where('sport_stats_id', $b->statId)->where('is_active', 1)->get();
                            if ($length == count($playerStats)) {
                                $this->updateMatchStatBasedOnPlayer($playerStats, $b);
                            }
                        } else if ($length < count($playerStats)) {
                            $effectedCount = count($playerStats) - $length;
                            // return "less".$effectedCount;
                            $stats = Match_fixture_stat::where('match_fixture_id', $a->matchFixture)->where('competition_id', $a->CompetitionId)->where('team_id', $a->teamId)->where('stat_type', 1)->where('player_id', $a->playerId)->update(['is_active' => 0]);
                            $length = count($b->statData);
                            $playerStats = Match_fixture_stat::where('match_fixture_id', $a->matchFixture)->where('competition_id', $a->CompetitionId)->where('team_id', $a->teamId)->where('stat_type', 1)->where('player_id', $a->playerId)->where('sport_stats_id', $b->statId)->limit($length)->get();
                            if ($length == count($playerStats)) {
                                $this->updateMatchStatBasedOnPlayer($playerStats, $b);
                            }
                        }
                        //
                    }
                }else{
                    $stats = Match_fixture_stat::where('match_fixture_id', $a->matchFixture)->where('competition_id', $a->CompetitionId)->where('team_id', $a->teamId)->where('stat_type', 1)->where('player_id', $a->playerId)->where('sport_stats_id', $b->statId)->update(['is_active'=> 0]);
                }
            }
        }
        $Match_fixture_stat =Match_fixture_stat::where('match_fixture_id',$id)->where(['stat_type'=>1,'is_active'=>1])->get();
        return response()->json(['status' => 200, 'msg' => 'match Stats Updated Successfully', 'request' => $request->all(),'Match_fixture_stat'=>$Match_fixture_stat]);
    }
    public function updateMatchStatBasedOnPlayer($playerStats, $updateData)
    {
        foreach ($playerStats  as $key => $p) {
            if ($updateData->statData[$key]->statValue) {
                $updatePlayerStats = Match_fixture_stat::find($p->id);
                $updatePlayerStats->stat_time = new Carbon();
                $updatePlayerStats->stat_time_record = $updateData->statData[$key]->statValue;
                $updatePlayerStats->is_active = 1;
                $updatePlayerStats->save();
            }
        }
    }
}
