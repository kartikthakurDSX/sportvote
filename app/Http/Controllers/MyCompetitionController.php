<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competition;
use App\Models\Competition_attendee;
use App\Models\Competition_team_request;
use App\Models\Team_member;
use App\Models\User;
use App\Models\Team;
use App\Models\Member_position;
use App\Models\user_profile;
use App\Models\Match_fixture;
use App\Models\Sport_stat;
use App\Models\Role;
use App\Models\Sport_level;
use App\Models\competition_type;
use Illuminate\Support\Facades\Auth;

class MyCompetitionController extends Controller
{
    
    public function index()
    {

        $my_comp = Competition::where('user_id',Auth::user()->id)->where('comp_type_id','!=', NULL)->with('sport','sport_comp','comptype','compsubtype')->orderby('id', 'DESC')->get();
        $competition_request = Competition_team_request::where('user_id',Auth::user()->id)->with('competition','team')->get();
        // return $my_comp;
        $all_comp = Competition::where('user_id','!=',Auth::user()->id)->with('sport','sport_comp','comptype','compsubtype')->orderby('id', 'DESC')->get();
        return view('frontend.competitions.my_competition',compact('my_comp','competition_request','all_comp'));
    }

  
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        return response()->json($request);
    }

  
  
    public function show($id)
    {
        $competition_teams = Competition_team_request::where('competition_id',$id)->get();
        $competition = Competition::find($id);
        $team_member = Team_member::with('members')->get();
        $user = User::all();
        $accepted_teams = Competition_team_request::where('competition_id',$id)->where('request_status',1)->get();
        $match_fixture = Match_fixture::where('competition_id',$id)->get();
        // return $competition;
        return view('frontend.competitions.view_competition',compact('match_fixture','competition_teams','competition','team_member','user','accepted_teams'));

    }

    public function edit($id)
    {
        //
        $competition = Competition::with('sport','comptype','compsubtype')->find($id);
        // return $competition;
        $admin = User::all();
        $com_type = competition_type::all();
        $sport_level = Sport_level::all();
        $player_stat = Sport_stat::where('stat_type_id',1)->get();
        $team_stat = Sport_stat::where('stat_type_id',2)->get();
        $comp_admin = Member_position::where('member_type',3)->get();
        $user = Role::where('name', 'user')->first()->users()->get();
        $comp_team_request = Competition_team_request::where('competition_id',$id)->get();
        return view('frontend.competitions.edit_comp',compact('competition','comp_team_request','admin','player_stat','team_stat','comp_admin','com_type','sport_level','user'));
    }

  
    public function update(Request $request, $id)
    {
        //
        $competition = Competition::find($id);
        $competition->name = $request->name;
        $competition->description = $request->description;
        $competition->start_datetime = $request->start_datetime;
        $competition->end_datetime = $request->end_datetime;
        $competition->location = $request->location;
        $competition->report_type = $request->report_type;
        $competition->vote_mins = $request->vote_mins;
        $competition->sport_levels_id = $request->sport_level_id;
       
        if ($request->hasFile('comp_logo')) {
            $file = $request->file('comp_logo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $destinationPath = public_path('frontend/logo/');
            $file->move($destinationPath, $filename);
            $competition->comp_logo = $filename;
        }
        if ($request->hasFile('sport_levels_proof')) {
            $file1 = $request->file('sport_levels_proof');
            $extension1 = $file1->getClientOriginalExtension();
            $filename1 = time() . '.' . $extension1;
            $destinationPath1 = public_path('frontend/level_proof/');
            $file1->move($destinationPath1, $filename1);
            $competition->sport_levels_proof = $filename1;
                }
        $competition->save();
        return redirect('competition');
    }

  
    public function destroy($id)
    {
        //
    }

   
    // public function team_players(Request $request)
    // {
    //     $team_players = Team_member::where('team_id',$request->team_id)->get();
    //     $team = Team::find($request->team_id);
    //     $user_profile = user_profile::all();
    //     $user = User::all();
    //     return response()->json(['team_playes' => $team_players, 'user' => $user, 'user_profile' => $user_profile, 'team' => $team]);
    // }

    public function select_players(Request $request)
    {
        $comp_request = Competition_team_request::find($request->comp_req_id);
        $team_members = Team_member::where('team_id',$comp_request->team_id)->where('invitation_status',1)->with('members','member_position')->get();
        return response()->json($team_members);
    }

    public function selected_players(Request $request)
    {
        
        $competition_request = Competition_team_request::find($request->comp);
        $competition_id = $competition_request->competition_id;
        $competition = Competition::find($competition_id);
        if($competition->squad_players_num == $request->squad_player_length)
        {
            $competition_request = Competition_team_request::find($request->comp);
            $competition_request->request_status = 1;
            $competition_request->save();

        $selected = explode(',', $request->selected_players);
        for($x=0; $x < count($selected); $x++)
        {
            $check = Competition_attendee::where('competition_id',$competition_request->competition_id)->where('attendee_id',$selected[$x])->get();
            if($check->isNotEmpty())
            {
                // return response()->json(['attendee_exist' => $check]);
            }
            else
            
            {
                $competition_attendee = new Competition_attendee();
                $competition_attendee->competition_id = $competition_request->competition_id;
                $competition_attendee->team_id = $competition_request->team_id;
                $competition_attendee->attendee_id = $selected[$x];
                $competition_attendee->save();
            }
          
        }
        return response()->json(['competition_id' => $competition->id]);
        }
        else
        {
        return response()->json(['squad'=>$competition->squad_players_num]);
        }
       
    }

    // public function store_match_fixture(Request $request)
    // {
    //     // return response()->json($request);
    //     $check = Match_fixture::where('competition_id',$request->competition_id)->where('teamOne_id',$request->team_id[0])->where('teamTwo_id',$request->team_id[1])->value('id');
    //    $competition = Competition::find($request->competition_id);
    //     if($check)
    //     {
    //         $match_fixture = Match_fixture::find($check);
    //         $match_fixture->teamOne_id = $request->team_id[0];
    //         $match_fixture->teamTwo_id = $request->team_id[1];
    //         $match_fixture->teamOne_position = 1;
    //         $match_fixture->teamTwo_position = 2;
    //         $match_fixture->venue = $request->venue;
    //         $match_fixture->location = $request->location;
    //         $match_fixture->save();
        

    //     }
    //     else
    //     {
    //         $match_fixture = new Match_fixture();
    //         $match_fixture->competition_id = $request->competition_id;
    //         $match_fixture->teamOne_id = $request->team_id[0];
    //         $match_fixture->teamTwo_id = $request->team_id[1];
    //         $match_fixture->teamOne_position = 1;
    //         $match_fixture->teamTwo_position = 2;
    //         $match_fixture->venue = $request->venue;
    //         $match_fixture->location = $request->location;
    //         $match_fixture->save();
           
    //     }
       
    //     return response()->json($match_fixture);
        

    // }
  
}
