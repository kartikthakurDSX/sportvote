<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sport;
use App\Models\User_profile;
use App\Models\Member_position;
use App\Models\Team;
use App\Models\Team_member;
use App\Models\Notification;
use App\Models\Member_permission;
use App\Models\Sport_level;
use App\Models\Match_fixture_stat;
use App\Models\Sport_stat;
use App\Models\Competition_attendee;
use App\Models\Match_fixture;
use App\Models\Trophy_cabinet;
use App\Models\StatDecisionMaker;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User_fav_follow;
use App\Models\Country;
use Carbon\Carbon;

class TeamController extends Controller
{
    
    public function index()
    {
		$my_team = Team::where('user_id',Auth::user()->id)->with('sport_team')->get();
        $all_teams = Team::where('is_active',1)->with('sport_team')->get();
        return view('frontend.teams.my_team',compact('my_team','all_teams'));
		
    }

    
    public function create()
    {
        $admin = User::all();
        $sports = Sport::all();
        $admin_position = Member_position::where('member_type','2')->get();
        $player_position = Member_position::where('member_type','1')->get();
        $players = User_profile::where('profile_type_id',2)->with('username')->get();
        $sport_level = Sport_level::all();
        $sport_stat = Sport_stat::where('stat_type_id',1)->get();
		$countries = Country::get();
        return view('frontend.teams.create', compact('sport_stat','sports','sport_level', 'admin_position','player_position','players','admin','countries'));
    }

  
    public function store(Request $request)
    {
        //return response()->json($request);
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'sport_id'  =>    ['required'],
         
        ]);

        //if validation fails
        if($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)->withInput();
        }
		
        if($request->team_id)
        { 
			$update_team = Team::find($request->team_id);
			$update_team->name = $request->name;
			$update_team->location = $request->location;
			$update_team->homeGround = $request->homGround;
			$update_team->homeGround_location = $request->homGround_location;
			$update_team->description = $request->description;
			$update_team->team_color = $request->team_color;
			$update_team->country_id = $request->team_country;
			$update_team->is_active = 1;
			$update_team->save();
			$team_id = $update_team->id;
			return response()->json($team_id);
		}
		else
		{
			$team = new Team();
			$team->user_id = Auth::user()->id;
			$team->sport_id = $request->sport_id;
			$team->name = $request->name; 
			$team->location = $request->location;			
			$team->is_active = 0; 
			$team->save();
			
			$team_id = $team->id;
			return response()->json($team_id);
		}
       
    }

   
    public function show($id)
    {
        //
        $team = Team::find($id);
        $team_owner = User::find($team->user_id);
		$player_positions = Member_position::where('member_type',1)->get();
        $follower = User_fav_follow::where('is_type',1)->where('type_id',$id)->get();
        // $team_member = Team_member::where('team_id',$id)->where('invitation_status',1)->get();
		 $trophy_cabinets = Trophy_cabinet::where('type', 2)->where('type_id', $team->id)->where('is_active', 1)->get();
       $team_admins = Team_member::where('team_id',$id)->where('member_position_id',4)->where('invitation_status',1)->pluck('member_id');
       $admins = $team_admins->toArray();
       $admin_name = User::whereIn('id', $admins)->get();
	   $sport_stat = Sport_stat::where('stat_type_id',1)->where('is_active',1)->get();
       $fixtures = Match_fixture::where('teamOne_id',$id)->Orwhere('teamTwo_id',$id)->with('competition','teamOne','teamTwo')->get();
		
       $f_fixtures_date = Match_fixture::where('teamOne_id',$id)->Orwhere('teamTwo_id',$id)->with('competition','teamOne','teamTwo')->first();
       $l_fixtures_date = Match_fixture::where('teamOne_id',$id)->Orwhere('teamTwo_id',$id)->with('competition','teamOne','teamTwo')->latest()->first();
       if(!empty($f_fixtures_date))
       {
       	$first_fixtures_year = date('Y', strtotime($f_fixtures_date->fixture_date));
       }
       else
       {
       	$first_fixtures_year ="";
       }
        if(!empty($l_fixtures_date))
       {
       	$lastest_fixture_year = date('Y', strtotime($l_fixtures_date->fixture_date));
       }
       else
       {
       	$lastest_fixture_year ="";
       }
       if(!empty($f_fixtures_date))
       {
       $first_fixtures_month = date('M', strtotime($f_fixtures_date->fixture_date));
       }
       else
       {
       $first_fixtures_month ="";
       }
        if(!empty($l_fixtures_date))
       {
       $lastest_fixture_month = date('M', strtotime($l_fixtures_date->fixture_date));
       }
       else
       {
       $lastest_fixture_month = "";
       }
       
       $month_array = array("JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC");
       
     
	$team_members = Team_member::where('team_id',$id)->where('member_position_id','!=',4)->where('invitation_status',1)->where('is_active',1)->with('members')->get();
	   
	   $collection = Match_fixture_stat::groupBy('player_id')
        ->where('team_id',$id)
		->where('sport_stats_id',1)
        ->where('sport_stats_id',1)
        ->selectRaw('count(*) as total, player_id')
        ->get();
		   $top_goal_player = $collection->toArray();
			
			if(!(empty($top_goal_player)))
			{
				$top_player = max($top_goal_player);
			}
			else
			{
				$top_player = "";
			}
			
		$match_fixture_stats = Competition_attendee::where('team_id', $id)->with('competition')->get();
		$match_fixture_competition = $match_fixture_stats->groupBy('Competition_id');
		
		$stat_graphic = Competition_attendee::where('team_id', $id)->with('competition')->first();
		$return_extra = 0;
		if(!empty($stat_graphic))
		{
			$return_extra = 1;
			
			$goals = Match_fixture_stat::where('competition_id',$stat_graphic->Competition_id)->where('team_id',$team->id)->where('sport_stats_id',1)->where('is_active',1)->get();
			$team_id = $team->id;
			$against_team = Match_fixture::where(function ($query) use ($team_id) {
				$query->where('teamOne_id', '=', $team_id)
				->orWhere('teamTwo_id', '=', $team_id);
				})->where('competition_id',$stat_graphic->Competition_id)->get();
				$played = 0;
				$lost = 0;
				$draw = 0 ;
				$won = 0;
				$againts_goals = 0;
				$a_team_ids = array();
			foreach($against_team as $a_team)
			{
				if($a_team->teamOne_id == $team->id)
				{
					// $a_team_ids[] = $a_team->teamTwo_id;
					$goal_a = Match_fixture_stat::where('competition_id',$stat_graphic->Competition_id)->where('team_id',$a_team->teamTwo_id)->where('match_fixture_id',$a_team->id)->where('sport_stats_id',1)->where('is_active',1)->count();
					$againts_goals = $againts_goals + $goal_a;
				}
				else
				{
					// $a_team_ids[] = $a_team->teamOne_id;
					$goal_a = Match_fixture_stat::where('competition_id',$stat_graphic->Competition_id)->where('team_id',$a_team->teamOne_id)->where('match_fixture_id',$a_team->id)->where('sport_stats_id',1)->where('is_active',1)->count();
					$againts_goals = $againts_goals + $goal_a;
				}
				if($a_team->winner_team_id != NULL)
				{
					$played++;
					if($a_team->winner_team_id == 0)
					{
						$draw++;
					}
					else
					{
						if($a_team->winner_team_id == $team->id)
						{
							$won++;
						}
						else
						{
							$lost++;
						}
					}
					
				}
			}
			$goal_d = count($goals) - $againts_goals;
			
			
			$yellow_card = Match_fixture_stat::where('competition_id',$stat_graphic->Competition_id)->where('team_id',$team->id)->where('sport_stats_id',2)->where('is_active',1)->get();			
			$red_card = Match_fixture_stat::where('competition_id',$stat_graphic->Competition_id)->where('team_id',$team->id)->where('sport_stats_id',3)->where('is_active',1)->get();
		
		}
        //	return $match_fixture_competition;
		
		// $address1 = $team->location;
		// 	$address = urlencode($address1);
			 
			
		// 	$url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyAQTGWbf8Xa1tCjD0M1WBpD6IDtOJj6KWQ";

		
		// 	$resp_json = file_get_contents($url);
			 
			
		// 	$resp = json_decode($resp_json, true);
			
		// 	if($resp['status']=='OK')
		// 	{
				
		// 		$country = isset($resp['results'][0]['address_components']['3']['long_name']) ? $resp['results'][0]['address_components']['3']['long_name'] : "2";
				

				
		// 		if($country)
		// 		{
					
		// 			$data_arr = array();            

		// 			array_push(
		// 			$data_arr,
		// 			$country
		// 			);
		// 			// echo $data_arr[0];
		// 		}
		// 		else
		// 		{
		// 			$country = "";
		// 		}
		// 	}
		// 	else{
		// 		$country = "";
				
		// 	}
			
		//	echo $country;
			//die();
			if($team->country_id != NULL)
			{
				$team_country_id = $team->country_id;
			}
			else
			{
				$team_country_id = 99;
			}
			$team_country = Country::find($team_country_id);
			$country = $team_country->name;
			$national_player = 0;
			$national_player_per = 0;
			$foreign_player = 0;
			$foreign_player_per =0;
			$player_age = array();
			foreach($team_members as $players)
			{ 
				if($players->members->nationality == $country)
				{
					$national_player++;
				}
				else
				{
					$foreign_player++;
				}
			}
			if($team_members->count() > 0)
			{
				$national_player_per = $national_player / $team_members->count() * 100;	
				$foreign_player_per = $foreign_player / $team_members->count() * 100;
			}
			if($return_extra == 1)
			{
				return view('frontend.teams.view',compact('month_array','first_fixtures_month','lastest_fixture_month','team','team_owner','follower','admins','admin_name','team_members','top_player','fixtures','first_fixtures_year','lastest_fixture_year','match_fixture_competition','national_player','foreign_player','national_player_per','foreign_player_per','goals','againts_goals','goal_d','yellow_card','red_card','against_team','won','lost','played','draw','trophy_cabinets','player_positions','sport_stat'));
			}
			else
			{
				return view('frontend.teams.view',compact('month_array','first_fixtures_month','lastest_fixture_month','team','team_owner','follower','admins','admin_name','team_members','top_player','fixtures','first_fixtures_year','lastest_fixture_year','match_fixture_competition','national_player','foreign_player','national_player_per','foreign_player_per','trophy_cabinets','player_positions','sport_stat'));
			}
    }
	public function team_stats(Request $request)
	{
		$goals = Match_fixture_stat::where('competition_id',$request->comp_id)->where('team_id',$request->team_id)->where('sport_stats_id',1)->where('is_active',1)->get();
		$total_goal = str_pad(count($goals),2,"0",STR_PAD_LEFT);
			$team_id = $request->team_id;
			$against_team = Match_fixture::where(function ($query) use ($team_id) {
				$query->where('teamOne_id', '=', $team_id)
				->orWhere('teamTwo_id', '=', $team_id);
				})->where('competition_id',$request->comp_id)->get();
	
				$played = 0;
				$draw = 0;
				$won = 0;
				$lost = 0;
				$goal_a = 0;
				$a_team_ids = array();
			foreach($against_team as $a_team)
			{
				if($a_team->teamOne_id == $request->team_id)
				{
					// $a_team_ids[] = $a_team->teamTwo_id;
					$againts_goals = Match_fixture_stat::where('competition_id',$request->comp_id)->where('team_id',$a_team->teamTwo_id)->where('match_fixture_id',$a_team->id)->where('sport_stats_id',1)->where('is_active',1)->count();
					$goal_a = $goal_a + $againts_goals;
				}
				else
				{
					// $a_team_ids[] = $a_team->teamOne_id;
					$againts_goals = Match_fixture_stat::where('competition_id',$request->comp_id)->where('team_id',$a_team->teamOne_id)->where('match_fixture_id',$a_team->id)->where('sport_stats_id',1)->where('is_active',1)->count();
					$goal_a = $goal_a + $againts_goals;
				}
				if($a_team->winner_team_id != NULL || $a_team->winner_team_id == 0)
				{
						$played++;
					if($a_team->winner_team_id == 0)
					{
						$draw++;
					}
					else
					{
						if($a_team->winner_team_id == $request->team_id)
						{
							$won++;
						}
						else
						{
							$lost++;
						}
					}
					
				}
				}
			$a_goal = str_pad($goal_a,2,"0",STR_PAD_LEFT);
			$goal_d = count($goals) - $goal_a;
			
			
			$yellow_cards = Match_fixture_stat::where('competition_id',$request->comp_id)->where('team_id',$request->team_id)->where('sport_stats_id',2)->where('is_active',1)->get();	
			$yellow_card = $yellow_cards->count();
			$red_cards = Match_fixture_stat::where('competition_id',$request->comp_id)->where('team_id',$request->team_id)->where('sport_stats_id',3)->where('is_active',1)->get();
			$red_card = $red_cards->count();
				
		return response()->json(['total_goal' => $total_goal, 'played' => $played, 'goal_d' => $goal_d, 'yellow_card' => $yellow_card , 'red_card'=> $red_card,'won' => $won,  'lost' => $lost,'draw' => $draw ,'a_goal' => $a_goal,'against_team' => $against_team]);
		//$allinput = $request->comp_id.'---'.$request->team_id;
		//return response()->json(['total_goal' => $allinput]);
	}
  
	public function send_invitation_team_admins(Request $request)
	{
		 for ($x = 0; $x < count($request->admins_ids); $x++)
		 {
			 $check_team_member = Team_member::where('team_id',$request->team_id)->where('member_id',$request->admins_ids[$x])->where('member_position_id',4)->first();
			 if(!empty($check_team_member))
			 {
				 if($check_team_member->invitation_status == 1)
				 {
					return response()->json(1);
				 }
				 else
				 {
					 $update_request = Team_member::find($check_team_member->id);
					 $update_request->invitation_status = 0;
					 $update_request->action_user = Auth::user()->id;
					 $update_request->save();
				 }
			 }
			 else
			 {
				 if($request->admins_ids[$x] != Auth::user()->id)
				 {
					 $send_request =  new Team_member();
					 $send_request->action_user = Auth::user()->id;
					 $send_request->team_id = $request->team_id;
					 $send_request->member_id = $request->admins_ids[$x];
					 $send_request->member_position_id = 4;
					 $send_request->invitation_status = 0;
					 $send_request->save();
					 
					$notification = Notification::create([
                    'notify_module_id' => 2,
                    'type_id' => $send_request->id,
                    'sender_id' => Auth::user()->id,
                    'reciver_id' =>  $request->admins_ids[$x],
                    ]);
				 }
				 
			 }
			 
		 }
		return response()->json();
	}
	public function send_invitation_team_player(Request $request)
	{
		 for ($x = 0; $x < count($request->admins_ids); $x++)
		 {
			 $check_team_member = Team_member::where('team_id',$request->team_id)->where('member_id',$request->admins_ids[$x])->where('member_position_id',$request->position_id)->first();
			 if(!empty($check_team_member))
			 {
				 if($check_team_member->invitation_status == 1)
				 {
					return response()->json(1);
				 }
				 else
				 {
					 $update_request = Team_member::find($check_team_member->id);
					 $update_request->invitation_status = 0;
					 $update_request->action_user = Auth::user()->id;
					 $update_request->save();
					 
					 $notification = Notification::create([
                    'notify_module_id' => 2,
                    'type_id' => $update_request->id,
                    'sender_id' => Auth::user()->id,
                    'reciver_id' =>  $request->admins_ids[$x],
                    ]);
				 }
			 }
			 else
			 {
				 if($request->admins_ids[$x] != Auth::user()->id)
				 {
					 $send_request =  new Team_member();
					 $send_request->action_user = Auth::user()->id;
					 $send_request->team_id = $request->team_id;
					 $send_request->member_id = $request->admins_ids[$x];
					 $send_request->member_position_id = $request->position_id;
					 $send_request->invitation_status = 0;
					 $send_request->save();
					 
					$notification = Notification::create([
                    'notify_module_id' => 2,
                    'type_id' => $send_request->id,
                    'sender_id' => Auth::user()->id,
                    'reciver_id' =>  $request->admins_ids[$x],
                    ]);
				 }
				 
			 }
			 
		 }
		return response()->json();
	}
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        return response()->json($request);
        //
    }

   
    public function destroy($id)
    {
        //
    }

    public function team_members(Request $request)
    {

        // return response()->json($request);
        $memberpositionid = Member_position::find($request->memberpositionid);
        
       
        for ($x = 0; $x < count($request->memberid); $x++) {
            if($request->memberid[$x] == Auth::user()->id)
            {
                $invitation_status = '1';
            }
            else
            {
                $invitation_status = '0';
            }
          
         
            if($memberpositionid->member_type == 2)
            {
                $checkmember = Team_member::where('team_id',$request->team_id)->where('member_id',$request->memberid[$x])->where('member_position_id',$request->memberposiionid)->first();
            }
            else
            {
                $checkmember = Team_member::where('team_id',$request->team_id)->where('member_id', $request->memberid[$x])->first();
            }
          
           if(empty($checkmember))
           {
             
                $teammember = Team_member::create([
                    'action_user' => Auth::user()->id,
                    'action_type' => 0,
                    'team_id' => $request->team_id,
                    'member_id' => $request->memberid[$x],
                    'member_position_id' => $request->memberpositionid,
                    'invitation_status' =>  $invitation_status, 
                ]);    
                $team_member_id = $teammember->id;
				
				$notification = Notification::create([
                'notify_module_id' => 2,
                'type_id' => $team_member_id,
                'sender_id' => Auth::user()->id,
                'reciver_id' =>  $request->memberid[$x],
             ]);
            
           } 
           else
           {
               if($checkmember->invitation_status == 3)
               {
                $teammember = Team_member::find($checkmember->id);
                $teammember->invitation_status = 0;
                $teammember->save();
               }
               else
               {
                return response()->json('0');
               }
               
           }
           
        }
        $team_member = Team_member::where('team_id',$request->team_id)->with('team','member_position','members')->get();
		$team_members_response = Team_member::where('team_id',$request->team_id)->where('invitation_status','!=',3)->with('member_position','members')->get();
        $admin_list = array();
			foreach($team_members_response as $tm_mem)
			{
				if($tm_mem->member_position->member_type == 2)
				{
					if($tm_mem->invitation_status == 0)
					{
						$div_class= "pending-list";
						$span_class = "<span class=' pending-icon'></span>";
					}
					else
					{
						$div_class= "";
						$span_class = "";
					}
					$admin_list[] = '<li class="'.$div_class.'"><i class="icon-angle-double-right"></i>'.$tm_mem->members->first_name.' '.$tm_mem->members->last_name.''.$span_class.'<br>
						<span>('.$tm_mem->member_position->name.')</span>
						<a style="cursor:pointer" class="btn btn-cross">×</a></li>';
				}
			}
			$players_list = array();
			foreach($team_members_response as $tm_mem)
			{
				if($tm_mem->member_position->member_type == 1)
				{
					if($tm_mem->invitation_status == 0)
					{
						$div_class= "pending-list";
						$span_class = "<span class=' pending-icon'></span>";
					}
					else
					{
						$div_class= "";
						$span_class = "";
					}
					$players_list[] = '<li class="'.$div_class.'"><i class="icon-angle-double-right"></i>'.$tm_mem->members->first_name.' '.$tm_mem->members->last_name.' '.$span_class.'<br>
						<span>('.$tm_mem->member_position->name.')</span>
						<a style="cursor:pointer" class="btn btn-cross">×</a></li>';
				}
			}
		return response()->json(['admin_list'=> $admin_list, 'players_list' => $players_list]); 

    }

    public function my_teams(Request $request, $id)
    {
        $team_members = Team_member::where('team_id',$id)->where('user_id',Auth::user()->id)->with('team','members','member_position')->get();
        $users = User::all();
        $sport = Sport::all();
      
        return view('frontend.teams.teamlist',compact('team_members','users','sport'));
    }

    public function remove_member(Request $request)
    {
        $team_member_id = Team_member::where('team_id',$request->team_id)->where('member_id',$request->noti_id)->value('id');
        $remove = Team_member::find($team_member_id);
        $remove->delete();
        $remove_notification = Notification::where('type_id',$team_member_id)->where('notify_module_id',2)->value('id');
        $remove_noti = Notification::find($remove_notification);
        $remove_noti->delete();
        return response()->json('1');
    }
	public function team_logo_crop(Request $request)
	{
		$path = 'frontend/logo';
		$file = $request->file('team_logo');
		$new_image_name = 'UIMG'.date('Ymd').uniqid().'.jpg';
		$upload = $file->move(public_path($path), $new_image_name);

		// return response()->json($request);
		$team_logos = Team::where('user_id',Auth::user()->id)->latest()->first();
		// return response()->json($comp_logos->id);
		$team_logo = Team::find($team_logos->id);
		$team_logo->team_logo = $new_image_name;
		$team_logo->save();
		$teams_logo = $team_logo->team_logo;

		if($upload){
			return response()->json(['status'=>1, 'msg'=>$teams_logo, 'element'=>$teams_logo]);
		}else{
			  return response()->json(['status'=>0, 'msg'=>'Something went wrong, try again later']);
		}
	}

    public function edit_teamlogo(Request $request,$teamlogo_id)
    {
        $path = 'frontend/logo';
		$file = $request->file('team_logo');
		$new_image_name = 'UIMG'.date('Ymd').uniqid().'.jpg'; 
		$upload = $file->move(public_path($path), $new_image_name);
        $teamlogo = Team::find($teamlogo_id);
        $teamlogo->team_logo = $new_image_name;
		$teamlogo->save();
        if($upload)
        {
                return response()->json(['status'=>1, 'msg'=>$teamlogo, 'element'=>$teamlogo]);
        }else{
            return response()->json(['status'=>0, 'msg'=>'Something went wrong, try again later']);
        }
    }
	public function edit_teambanner(Request $request,$team_id)
    {
        $path = 'frontend/images/team_banner';
		$file = $request->file('team_banner');
		$new_image_name = 'UIMG'.date('Ymd').uniqid().'.jpg'; 
		$upload = $file->move(public_path($path), $new_image_name);
        $team_banner = Team::find($team_id);
        $team_banner->team_banner = $new_image_name;
		$team_banner->save();
        if($upload)
        {
                return response()->json(['status'=>1, 'msg'=>$team_banner, 'element'=>$team_banner]);
        }else{
            return response()->json(['status'=>0, 'msg'=>'Something went wrong, try again later']);
        }
    }
	public function adddetail(Request $request)
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
        $addtrophy_cabinet->type = 2;
        $addtrophy_cabinet->type_id = $request->team_id;
        $addtrophy_cabinet->title = $request->title;
        $addtrophy_cabinet->year = $year;
        $addtrophy_cabinet->team = $request->team;
        $addtrophy_cabinet->comp = $request->competition;
        $addtrophy_cabinet->trophy_image = $trophy_image;
        $addtrophy_cabinet->save();
        if($addtrophy_cabinet){
            return back();
        }
        
    }
	public function editcabinet($id)
    {
        $editcabinet = Trophy_cabinet::find($id);
        $select = explode(',',$editcabinet->year);
        return response()->json(['editcabinet'=>$editcabinet, 'select'=> $select]);
    }
	
	 public function delete($id)
    {
        $deletecabinet = Trophy_cabinet::find($id)->delete();
        return redirect()->back();
      
    }
	public function autosearch_player($id, Request $request)
	{
		$team_members = Team_member::where('team_id',$id)->where('invitation_status','!=',3)->pluck('member_id');
		$member_ids = $team_members->toarray();
		
		$admin = [];
        // if($request->has('q')){
            // $search = $request->q;
			
            // $admin =User::select("id", "first_name as name" ,"last_name as l_name")
            		// ->where('first_name', 'LIKE', "$search%")
            		// ->get();
        // }

        if($request->has('q')){
            $search = $request->q;
            $admin = User::select('users.id','users.first_name as name','users.last_name as l_name')
            ->join('user_profiles','users.id','=','user_profiles.user_id')
            ->where('users.first_name', 'like' , "$search%")
			->whereNotIn('users.id',$member_ids)
            ->get();
        }
		

        return response()->json($admin);
	}
   public function most_stat_player(Request $request)
   {
	  $stat_detail = Sport_stat::find($request->stat_id);
	  $stat_name = $stat_detail->name;
	   $collection = Match_fixture_stat::groupBy('player_id')
        ->where('team_id',$request->team_id)
		->where('sport_stats_id',$request->stat_id)
        ->selectRaw('count(*) as total, player_id')
        ->get();
		   $top_stat_player = $collection->toArray();
			if(!empty($top_stat_player))
			{
				
				
				$top_player = max($top_stat_player);
				
				if(!empty($top_player))
				{
					$top_stat_player = User::find($top_player['player_id']);
					$most_stat_team_member = Team_member::where('member_id',$top_stat_player->id)->where('team_id',$request->team_id)->where('is_active',1)->first();
					$most_stat_jersey_number = str_pad($most_stat_team_member->jersey_number,2,'0',STR_PAD_LEFT);
					$most_stat_player_age = Carbon::parse($top_stat_player->dob)->age;
					return response()->json(['stat_name' => $stat_name, 'most_stat_jersey_number' => $most_stat_jersey_number,'top_stat_player' => $top_stat_player, 'most_stat_player_age' =>$most_stat_player_age]);
				}
				else
				{
					return response()->json(['top_player_data'=>0, 'stat_name' => $stat_name ]);
				}
			}
			else
			{
				return response()->json(['top_player_data'=>0, 'stat_name' => $stat_name ]);
			}
		 	
   }
   public function save_team_contact(Request $request)
   {
	   $team_info = Team::find($request->team_id);
	   $team_info->team_email = $request->team_email;
	   $team_info->team_phone_number = $request->team_phonenumber;
	   $team_info->team_address = $request->team_address;
	   $team_info->save();
		return response()->json($request);
   }

}
