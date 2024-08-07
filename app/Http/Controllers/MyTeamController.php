<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\User;
use App\Models\Sport_level;
use App\Models\Sport_stat;
use App\Models\Team_member;
use App\Models\Member_position;
use App\Models\User_profile;
use App\Models\StatDecisionMaker;
use App\Models\User_fav_follow;
use PhpParser\Node\Expr\FuncCall;

class MyTeamController extends Controller
{
    public function index()
    {
        $my_team = Team::where('user_id', Auth::user()->id)->with('sport_team')->get();
        $all_teams = Team::where('is_active', 1)->with('sport_team')->get();
        return view('frontend.teams.my_team', compact('my_team', 'all_teams'));
    }

    public function following_teams()
    {
        $team_follows = User_fav_follow::where('is_type', 1)->where('user_id', Auth::user()->id)->where('Is_follow', 1)->where('is_active', 1)->with('team', 'user', 'team.sport')->get();
        // return $team_follows;
        return view('frontend.teams.following_teams', compact('team_follows'));
    }

    public function mycreatedTeam()
    {
        $my_team = Team::where('user_id', Auth::user()->id)->with('sport_team')->get();
        return view('frontend.teams.mycreatedteams', compact('my_team'));
    }
    // public function allTeams()
    // {
    //     $all_teams = Team::where('is_active', 1)->with('sport_team')->get();
    //     return view('frontend.teams.all_teams', compact('all_teams'));
    // }
    public function allTeams()
    {
        $all_teams = Team::where('is_active', 1)
            ->with('sport_team')
            ->orderBy('id', 'desc') // Replace 'column_name' with the actual column name
            ->get();
        //return $all_teams;
        return view('frontend.teams.all_teams', compact('all_teams'));
    }

    public function participatedIn()
    {
        $teams = Team_member::where('member_id', Auth::user()->id)->where('invitation_status', 1)->with('team')->get();
        return view('frontend.teams.participated_teams', compact('teams'));
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
        $team = Team::find($id);
        $team_members = Team_member::where('team_id', $id)->with('team', 'members', 'member_position')->get();
        //    return $team_members;
        $member_position = Member_position::where('sport_id', 1)->get();
        return view('frontend.teams.teamlist', compact('team_members', 'team', 'member_position'));
    }
    public function edit($id)
    {
        $team = Team::find($id);
        $admin = User::all();
        $admin_position = Member_position::where('member_type', '2')->get();
        $player_position = Member_position::where('member_type', '1')->get();
        $players = User_profile::where('profile_type_id', 2)->with('username')->get();
        $sport_level = Sport_level::all();
        $sport_stat = Sport_stat::where('stat_type_id', 1)->get();
        return view('frontend.teams.edit_team', compact('team', 'admin_position', 'player_position', 'sport_level', 'sport_stat', 'admin', 'players'));
    }
    public function update(Request $request, $id)
    {
        // return $request;
        $team = Team::find($id);
        $team->name = $request->name;
        $team->location = $request->location;
        $team->homeGround = $request->homeGround;
        $team->homeGround_location = $request->homeGround_location;
        $team->accept_player_invite = $request->accept_player_invite;
        $team->accept_comp_invite = $request->accept_comp_invite;
        $team->description = $request->description;
        $team->team_color = $request->team_color;
        $team->sport_level_id = $request->sport_level_id;

        if ($request->hasFile('team_logo')) {
            $file = $request->file('team_logo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $destinationPath = public_path('frontend/logo/');
            $file->move($destinationPath, $filename);
            $team->team_logo = $filename;
        }
        if ($request->hasFile('sport_levels_proof')) {
            $file1 = $request->file('sport_levels_proof');
            $extension1 = $file1->getClientOriginalExtension();
            $filename1 = time() . '.' . $extension1;
            $destinationPath1 = public_path('frontend/level_proof/');
            $file1->move($destinationPath1, $filename1);
            $team->sport_levels_proof = $filename1;
        }

        $team->save();
        if ($request->stat_id != NULL) {
            $x = 1;
            for ($i = 0; $i < count($request->stat_id); $i++) {
                if ($request->stat_id[$i] != NULL) {
                    $stat_decision_maker = new StatDecisionMaker();
                    $stat_decision_maker->decision_stat_for = 1;
                    $stat_decision_maker->type_id = $request->team_id;
                    $stat_decision_maker->stat_id = $request->stat_id[$i];
                    $stat_decision_maker->stat_order = $x++;
                    $stat_decision_maker->save();
                }
            }
        }

        return redirect('my_team');
    }
    public function destroy($id)
    {
        //
    }
    public function player_info(Request $request)
    {
        $player_info = User::find($request->id);
        $team_member = Team_member::where('team_id', $request->team_id)->where('member_id', $request->id)->with('member_positions')->get();
        return response()->json(['player_info' => $player_info, 'team_member' => $team_member]);
    }

    public function player_jersey_number(Request $request)
    {
        $team_member_id = Team_member::where('team_id', $request->team_id)->where('member_id', $request->player_id)->value('id');
        $check = Team_member::where('team_id', $request->team_id)->where('jersey_number', $request->j_num)->get();
        if ($check->isNotEmpty()) {
            return response()->json('0');
        } else {
            $team_member = Team_member::find($team_member_id);
            $team_member->jersey_number = $request->j_num;
            $team_member->save();
            return response()->json('1');
        }
    }
}
