<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Country;
use App\Models\Team;
use App\Models\Competition;
use App\Models\User_profile;
use App\Models\User_fav_follow;
use App\Models\User_friend;
use App\Models\Sport;
use App\Models\Role;
use App\Models\Notification;
use App\Models\Team_member;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class FanController extends Controller
{

    public function index()
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $countries = Country::all();
        $ufavteam = Team::all();
        $competitions = Competition::all();
        $sports = Sport::all();
        $ufplayer = Role::where('name', 'user')->first()->users()->get();

        $users = User::get();
        $ufplayers = User_profile::where('profile_type_id',2)
        ->groupBy('user_id')
        ->pluck('user_id');

        $ufplayers_array = $ufplayers->toArray();

        $user_location = $data->location;
        $user_nationality = $data->nationality;

        $suggested_players = User::where('users.nationality', $user_nationality)
        // ->join('user_profiles','users.id','=','user_profiles.user_id')
        ->whereIn('id', $ufplayers_array )
        ->where('users.location', 'like' , '%'. $user_location .'%')
        ->where('users.id', '!=', $id)
        ->get();
        $suggested_teams = Team::where('is_active', 1)->where('location', 'like' , '%'. $user_location .'%')
        ->get();



        $suggested_comps = Competition::where('is_active', 1)->where('location', 'like' , '%'. $user_location .'%')->where('location', 'like' , '%'. $user_nationality .'%')->get();

        $friend = User_friend::where(function ($query) use ($id) {
            $query->where('user_id', '=', $id)
            ->orWhere('friend_id', '=', $id);
            })->where('request_status',0)->get();
        $friend_request = User_friend::where(function ($query) use ($id) {
            $query->where('user_id', '=', $id);            ;
            })->where('request_status',0)->get();

        $friend_ids = array();
       foreach($friend as $friend_id)
       {
            if($friend_id->user_id == $id)
            {
                $friend_ids[] = $friend_id->friend_id;
            }
            else
            {
                $friend_ids[] = $friend_id->user_id;
            }
       }
       $team_followers = User_fav_follow::Where('is_type', 1)->Where('user_id', $id)->where('Is_follow',1)->get();
       $comp_followers = User_fav_follow::Where('is_type', 2)->Where('user_id', $id)->where('Is_follow',1)->get();
       $comp_followed = User_fav_follow::Where('is_type', 2)->Where('user_id', $id)->where('Is_follow',1)->get();
       $player_followers = User_fav_follow::Where('is_type', 3)->Where('user_id', $id)->where('Is_follow',1)->get();
        //    return $player_followers;


        $comp_follows_ids = User_fav_follow::where('is_type', 2)->where('user_id', Auth::user()->id)->where('Is_follow', 1)->where('is_active', 1)->pluck('type_id');
        $comp_follows_array = $comp_follows_ids->toArray();


        $team_follows_ids = User_fav_follow::Where('is_type', 1)->Where('user_id', $id)->where('Is_follow', 1)->pluck('type_id');

        $team_follows_array = $team_follows_ids->toArray();

        $player_follows_ids = User_fav_follow::Where('is_type', 3)->Where('user_id', $id)->where('Is_follow', 1)->pluck('type_id');

        $player_follows_array = $player_follows_ids->toArray();


        $users = User::get();

        $team_members = Team_member::get();

        $sports = Sport::get();

        $is_fan = User_profile::where('profile_type_id', 2)
        ->groupBy('user_id')
        ->pluck('user_id');

        $fan_array = $is_fan->toArray();

        $ufreferees = User_profile::where('profile_type_id', 3)
        ->groupBy('user_id')
        ->pluck('user_id');

        $ufreferees_array = $ufreferees->toArray();

        $suggested_referees = User::where('users.nationality', $user_nationality)
            // ->join('user_profiles','users.id','=','user_profiles.user_id')
            ->whereIn('id', $ufreferees_array)
            ->where('users.location', 'like', '%' . $user_location . '%')
            ->where('users.id', '!=', $id)
            ->get();



        if (in_array(Auth::user()->id, $fan_array)) {
            return redirect('/');
        } else {



       return view('frontend.fans.create', compact('data','countries', 'team_follows_array','comp_followers','team_followers','friend_ids','player_followers','suggested_players','suggested_teams','suggested_comps', 'friend_request', 'comp_followed', 'comp_follows_array', 'player_follows_array', 'ufplayers_array', 'users', 'team_members', 'sports', 'suggested_referees'));

        }
    }


    public function follow_suggested_player(Request $request)
    {
        $id = $request->id;

        $user_follow = User_fav_follow::where('is_type',3)->where('type_id',$id)->where('user_id',Auth::user()->id)->first();
        if($user_follow)
        {
            $user_follows = User_fav_follow::find($user_follow->id);
            $user_follows->Is_follow = 1;
            $user_follows->save();
        }
        else
        {
            $user_fav_follow = new User_fav_follow();
            $user_fav_follow->user_id = Auth::user()->id;
            $user_fav_follow->is_type = 3;
            $user_fav_follow->type_id = $id;
            $user_fav_follow->Is_fav = 1;
            $user_fav_follow->Is_follow = 1;
            $user_fav_follow->save();

            $notification = Notification::create([
                'notify_module_id' => 5,
                'type_id' => $user_fav_follow->id,
                'sender_id' => Auth::user()->id,
                'reciver_id' => $id,
            ]);
        }
        return response()->json(['status'=>1, 'message'=>'Player is Followed']);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {

            $id = Auth::user()->id;

            if($request->friend)
            {
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

            if($request->fav_player)
            {
                for($x = 0; $x < count($request->fav_player); $x++)
                {
                    $user_profile = User_profile::find($request->fav_player[$x]);
                    $check = User_fav_follow::where('user_id',$id)->where('is_type',3)->where('type_id',$request->fav_player[$x])->value('id');
                    if(!$check)
                    {
                        $user_fav_follow = new User_fav_follow();
                        $user_fav_follow->user_id = $id;
                        $user_fav_follow->is_type = 3;
                        $user_fav_follow->is_fav = 1;
                        $user_fav_follow->is_follow = 1;
                        $user_fav_follow->type_id = $request->fav_player[$x];
                        $user_fav_follow->save();
                        $notification = Notification::create([
                                'notify_module_id' => 5,
                                'type_id' => $user_fav_follow->id,
                                'sender_id' => Auth::user()->id,
                                'reciver_id' => $user_profile->user_id,
                        ]);
                    }
                        else
                        {
                            $user_fav_follow = User_fav_follow::find($check);
                            $user_fav_follow->is_fav = 1;
                            $user_fav_follow->save();
                        }

                }
            }


        if($request->fav_team)
        {
            for($x = 0; $x < count($request->fav_team); $x++)
            {
                $team = Team::find($request->fav_team[$x]);
                $check = User_fav_follow::where('user_id',$id)->where('is_type',1)->where('type_id',$request->fav_team[$x])->value('id');
                if(!$check)
                {
                $user_fav_follow = new User_fav_follow();
                $user_fav_follow->user_id = $id;
                $user_fav_follow->is_type = 1;
                $user_fav_follow->is_fav = 1;
                $user_fav_follow->is_follow = 1;
                $user_fav_follow->type_id = $request->fav_team[$x];
                $user_fav_follow->save();

                $notification = Notification::create([
                    'notify_module_id' => 5,
                    'type_id' => $user_fav_follow->id,
                    'sender_id' => Auth::user()->id,
                    'reciver_id' => $team->user_id,
            ]);
                }
                else
                {
                    $user_fav_follow = User_fav_follow::find($check);
                    $user_fav_follow->is_fav = 1;
                    $user_fav_follow->save();
                }
            }
        }

        if($request->fav_comp)
        {
            for($x = 0; $x < count($request->fav_comp); $x++)
            {
                $competition = Competition::find($request->fav_comp[$x]);
                $check = User_fav_follow::where('user_id',$id)->where('is_type',2)->where('type_id',$request->fav_comp[$x])->value('id');
                if(!$check)
                {
                $user_fav_follow = new User_fav_follow();
                $user_fav_follow->user_id = $id;
                $user_fav_follow->is_type = 2;
                $user_fav_follow->is_fav = 1;
                $user_fav_follow->is_follow = 1;
                $user_fav_follow->type_id = $request->fav_comp[$x];
                $user_fav_follow->save();

                $notification = Notification::create([
                    'notify_module_id' => 5,
                    'type_id' => $user_fav_follow->id,
                    'sender_id' => Auth::user()->id,
                    'reciver_id' => $competition->user_id,
            ]);
                }
                else
                {
                    $user_fav_follow = User_fav_follow::find($check);
                    $user_fav_follow->is_fav = 1;
                    $user_fav_follow->save();
                }

            }
        }


            return redirect('/dashboard');

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

    function crop(Request $request){
        $path = 'frontend/profile_pic';
        $file = $request->file('file');
        $new_image_name = 'UIMG'.date('Ymd').uniqid().'.jpg';
        $upload = $file->move(public_path($path), $new_image_name);

        $profile_pic = User::find(Auth::user()->id);
        $profile_pic->profile_pic = $new_image_name;
        $profile_pic->save();

        if($upload){
            return response()->json(['status'=>1, 'msg'=>'Image has been cropped successfully.', 'name'=>$new_image_name]);
        }else{
              return response()->json(['status'=>0, 'msg'=>'Something went wrong, try again later']);
        }
    }

    public function suggested_player()
    {
        $user = User::find(Auth::user()->id);
        $user_location = $user->location;
        $user_nationality = $user->nationality;

        $suggested_player = User::select('users.id','users.first_name as name','users.last_name as l_name')
        ->join('user_profiles','users.id','=','user_profiles.user_id')
        ->where('users.location', 'like' , '%'. $user_location .'%')
        ->where('users.nationality', 'like' , '%'. $user_nationality .'%')
        ->get();
    }

    public function addfriend(Request $request)
    {
        $id = $request->id;
        $add_friend = new User_friend();
        $add_friend->user_id = Auth::user()->id;
        $add_friend->friend_id = $id;
        $add_friend->request_status = 0;
        $add_friend->save();
        $ufr_id = $add_friend->id;

        $notification = Notification::create([
            'notify_module_id' => 1,
            'type_id' => $ufr_id,
            'sender_id' => Auth::user()->id,
            'reciver_id' => $id,
        ]);
        if($notification){
            return $id;
        }
    }

    public function unfriend(Request $request)
    {
        $id = $request->id;
        $unfriend = User_friend::where('user_id', Auth::user()->id)->where('friend_id', $id)->delete();
        $delete_notification = Notification::where('notify_module_id',1)->where('sender_id', Auth::user()->id)->where('reciver_id',$id)->delete();
    }

    public function unfollow_player(Request $request)
    {
        $id = $request->id;
        $user_follow = User_fav_follow::where('is_type',3)->where('type_id',$id)->where('user_id',Auth::user()->id)->first();
        $user_follows = User_fav_follow::find($user_follow->id);
        $user_follows->Is_follow = 0;
        $user_follows->save();
    }

    public function follow_team(Request $request)
    {
        $id = $request->id;
        $user_follow = User_fav_follow::where('is_type',1)->where('type_id',$id)->where('user_id',Auth::user()->id)->first();
        if($user_follow)
        {
            $user_follows = User_fav_follow::find($user_follow->id);
            $user_follows->Is_follow = 1;
            $user_follows->save();
        }
        else
        {
            $user_fav_follow = new User_fav_follow();
            $user_fav_follow->user_id = Auth::user()->id;
            $user_fav_follow->is_type = 1;
            $user_fav_follow->type_id = $id;
            $user_fav_follow->Is_fav = 1;
            $user_fav_follow->Is_follow = 1;
            $user_fav_follow->save();

            $notification = Notification::create([
                'notify_module_id' => 5,
                'type_id' => $user_fav_follow->id,
                'sender_id' => Auth::user()->id,
                'reciver_id' => $id,
            ]);
        }

    }

    public function unfollow_team(Request $request)
    {
        $id = $request->id;
        $user_follow = User_fav_follow::where('is_type',1)->where('type_id', $id)->where('user_id',Auth::user()->id)->first();

            $user_follows = User_fav_follow::find($user_follow->id);
            $user_follows->Is_follow = 0;
            $user_follows->save();
    }

    public function follow_comps(Request $request)
	{
        $comp_id = $request->id;

		$check_user_fav_follow = User_fav_follow::where('is_type',2)->where('type_id',$comp_id)->where('user_id',Auth::user()->id)->first();
		if(empty($check_user_fav_follow))
		{
			$user_fav_follow = new User_fav_follow();
			$user_fav_follow->user_id = Auth::user()->id;
			$user_fav_follow->is_type = 2;
			$user_fav_follow->type_id = $comp_id;
			$user_fav_follow->Is_follow = 1;
			$user_fav_follow->save();
		}
		else
		{
			$user_fav_follow = User_fav_follow::find($check_user_fav_follow->id);
			$user_fav_follow->Is_follow = 1;
			$user_fav_follow->save();
		}
	}

    public function unfollow_comp(Request $request)
	{
        $comp_id = $request->id;
		$check_user_fav_follow = User_fav_follow::where('is_type', 2)->where('type_id',$comp_id)->where('user_id',Auth::user()->id)->first();
		$user_fav_follow = User_fav_follow::find($check_user_fav_follow->id);
		$user_fav_follow->Is_follow = 0;
		$user_fav_follow->save();
	}

}
