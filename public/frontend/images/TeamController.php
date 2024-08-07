<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sport;
use App\Models\User_profile;
use App\Models\Member_position;
use App\Models\Team;
use App\Models\Team_member;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    
    public function index()
    {
        $players = User::all();
        $sports = Sport::all();
        $admin_position = Member_position::where('member_type','2')->get();
        $player_position = Member_position::where('member_type','1')->get();
        $players = User_profile::where('profile_type_id','2')->with('user')->get();
        return view('frontend.teams.create', compact('players', 'sports', 'admin_position','player_position','players'));
    }

    
    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        $check_team = Team::where('user_id',$request->userid)->where('sport_id',$request->sport_id)->value('id');
        if(empty($check_team))
        {
            $team = Team::create([
                'user_id' => $request->userid,
                'sport_id' => $request->sport_id,
                'name' => $request->name,
            ]);
            $team_id = $team->id;

        }
        else
        {
            $team = Team::find($check_team);
            $team->name = $request->name;
            $team->save();
            $team_id = $team->id;

        }
     
        return response()->json($team_id);
    }

   
    public function show($id)
    {
        //
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

    public function team_members(Request $request)
    {
       
        // return response()->json($request);
        $id = Auth::user()->id;
        for ($x = 0; $x < count($request->memberid); $x++) {
         
            
            $teammember = Team_member::create([
                'user_id' => $request->userid,
                'team_id' => $request->team_id,
                'member_id' => $request->memberid[$x],
                'member_position_id' => $request->memberpositionid,
                'is_active' => 0, 
            ]);    
            
    }
    return response()->json('1');
    }

    public function team_submit(Request $request)
    {
        // return $request->all();
       if($request->team_id)
       {
           $updateF = Team::where('user_id',$request->userid)->where('sport_id',$request->sport_id)->value('id');
           if($updateF)
           {          
            $team = Team::find($updateF);
            $team->name = $request->name;
            $team->location = $request->location;
            $team->description = $request->description;   
            $team->team_color = $request->team_color;
            $team->is_active = 1;
            $team->save();
            return response()->json(1);
           }
       }
       return response()->json('0');
    }

    public function my_teams(Request $request, $id)
    {
        $team_members = Team_member::where('team_id',$id)->where('user_id',Auth::user()->id)->with('team','members','member_position')->get();
        $users = User::all();
        $sport = Sport::all();
      
        return view('frontend.teams.teamlist',compact('team_members','users','sport'));
    }

}
