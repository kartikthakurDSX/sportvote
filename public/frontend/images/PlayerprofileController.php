<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Http\Request;
use App\Models\User_profile;
use App\Models\user_sport_cerification;
use App\Models\user_sport_membership;
use App\Models\Sport;
use App\Models\Sport_level;
use App\Models\Profile_type;
use App\Models\Sport_attitude;
use App\Models\Team;
use App\Models\Country;
use App\Models\user_follow;
use App\Models\Role;
use App\Models\User;
use App\Models\user_follow_type;
use App\Models\user_favourite;
use App\Models\user_friend;
use App\Models\team_join;
use App\Models\user_favourite_profile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;




class PlayerprofileController extends Controller
{
    public $successStatus = 200;

    public function index()
    {
        $uprofile = User_profile::get();
        $usportcert = user_sport_cerification::get();
        $sports = Sport::get();
        $usportmem = user_sport_membership::get();
        $id = Auth::user()->id;
        // $comps = Competition::where('user_id', $id)->get();
        $comps = Competition::all();
        $friend = user_friend::where('user_id',$id)->with('User')->get();
        // $friend = user_friend::where('friend_id',$id)->with('User')->get();
        return view('dashboard',compact('comps','friend','r_friend'));
    }

    public function autocompletesearch(Request $request)
    {
        $query = $request->get('query');
        $filterResult = Team::where('name', 'LIKE', '%' . $query . '%')->get();
        return response()->json($filterResult);
    }


    public function create()
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $countries = Country::all();
        $sports = Sport::all();
        $usportlevel = Sport_level::all();
        $usportattitude = Sport_attitude::all();
        $ufplayers = Role::where('name', 'user')->first()->users()->get();
        $ufavteam = Team::all();
        $competitions = Competition::all();

        return view('frontend.playerprofiles.create',compact('data','competitions','countries','sports','usportlevel','usportattitude','ufplayers','ufavteam'));
       
       
       
        // $usportcert = user_sport_cerification::get();
        // $usportmem = user_sport_membership::get();
        // $uprofiletype = Profile_type::get();
        // $ufavcomp = Competition::get();
        // return view('frontend.playerprofiles.create', compact('uplayers','id', 'sports', 'usportcert', 'usportmem', 'usportlevel', 'uprofiletype', 'usportattitude', 'ufplayers', 'ufavcomp', 'ufavteam', 'data', 'countries', 'competitions'));
    }

    public function store(Request $request)
    {
        // return $request->all();

        $validator = Validator::make($request->all(), [
            'certificate' => 'mimes:png,jpg,jpeg,gif|max:2048',
            'sport_level_id' => ['required'],
            'sport_id' => ['required'],
            'sport_attitude_id' => ['required'],

        ]);

        $userprofiles = new User_profile([
            'profile_desc' => $request->get('profile_desc'),
            'user_id' => auth::user()->id,
            'sport_id' => $request->get('sport'),
            'sport_level_id' => $request->get('sport_level'),
            'sport_attitude_id' => $request->get('sport_attitude'),
            'profile_type_id' => 2,
        ]);
        $userprofiles->save();
        $id = Auth::user()->id;
        $users = User::find($request->id);
        $users->first_name = $request->first_name;
        $users->last_name = $request->last_name;
        $users->bio = $request->bio;
        $users->height = $request->height;
        $users->weight = $request->weight;
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

        //   user sport certification
        if($request->certname)
        {
        $usersport_certification = new user_sport_cerification();
        $usersport_certification->user_id = $id;
        $usersport_certification->sport_id = $request['sport'];
        $usersport_certification->name = $request['certname'];
        $usersport_certification->description = $request['certdescription'];
        if ($request->hasFile('certificate')) {
            $file = $request->file('certificate');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $destinationPath = public_path('/frontend/certificate/');
            $file->move($destinationPath, $filename);
            $usersport_certification->certificate = $filename;
        }
        $usersport_certification->save();
    }

    if($request->name)
    {
        // user sport membership
        $usersport_membership = new user_sport_membership();
        $usersport_membership->user_id = $id;
        $usersport_membership->sport_id = $request['sport'];
        $usersport_membership->name = $request['name'];
        $usersport_membership->description = $request['description'];
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $destinationPath = public_path('/frontend/logo/');
            $file->move($destinationPath, $filename);
            $usersport_membership->logo = $filename;
        }
        $usersport_membership->save();
    }
        // add more
        if($request->search)
        {
        
        for ($x = 0; $x < count($request->search); $x++) {
            if($request->search[$x] != 0)
        {
            $check_team = team_join::where('user_id',$id)->where('team_id',$request->search[$x])->get();
            if($check_team->isEmpty())
            {
            $teamjoins = new team_join();
            $teamjoins->user_id = $id;
            $teamjoins->team_id = $request->search[$x];
            $teamjoins->reason = $request->reason[$x];
            $teamjoins->save();
            }
        }
    }
    }
        if($request->friend)
        {
        $friendcount = count($request->friend);
        for ($y = 0; $y < $friendcount; $y++) {
            $ufr = new user_friend();
            $ufr->user_id = $id;
            $ufr->friend_id = $request->friend[$y];
            $ufr->save();
        }
    }
        //
        if($request->fav_player)
        {
        $favusercount = count($request->fav_player);
        for ($i = 0; $i < $favusercount; $i++) {
            $ufp = new user_favourite_profile();
            $ufp->user_id = $id;
            $ufp->fav_user_id = $request->fav_player[$i];
            $ufp->user_type = 2;
            $ufp->save();
            $uflo = new user_follow();
            $uflo->user_id = $id;
            $uflo->follow_user_id = $request->fav_player[$i];
            $uflo->follow_user_type = 2;
            $uflo->save();
        }
    }
        // follow user count
        if($request->fav_player)
        {
        $followusercount = count($request->fav_player);
        for ($l = 0; $l < $followusercount; $l++) {
            $checkfollowdata = user_follow::where(['user_id' => $id, 'follow_user_id' => $request->fav_player[$l]])->first();
            //    echo $follow_user_id[$l];

            if (empty($checkfollowdata)) {
                $ufl = new user_follow();
                $ufl->user_id = $id;
                $ufl->follow_user_id = $request->fav_player[$l];
                $ufl->follow_user_type = 2;
                $ufl->save();
            } else {

                $updateuserfollow = user_follow::where(['user_id' => $id, 'follow_user_id' => $request->fav_player[$l]])->update(['follow_status' => 1]);
            }
        }
    }
        // Select Favourite Team
        if($request->fav_team)
{
        $favteamcount = count($request->fav_team);
        for ($j = 0; $j < $favteamcount; $j++) {
            $uft = new user_favourite();
            $uft->user_id = $id;
            $uft->type_id = $request->fav_team[$j];
            $uft->fav_type = 1;
            $uft->save();
            $uflot =  new user_follow_type();
            $uflot->user_id = $id;
            $uflot->follow_user_type_id = $request->fav_team[$j];
            $uflot->profile_type_id = 1;
            $uflot->save();
        }
    }
        // team count
        if($request->fav_team)
        {
        $followteamcount = count($request->fav_team);
        for ($m = 0; $m < $followteamcount; $m++) {
            $checkfollowteamdata = user_follow_type::where(['user_id' => $id, 'follow_user_type_id' => $request->fav_team[$m]])->first();
            if (empty($checkfollowteamdata)) {
                $uflteam = new user_follow_type();
                $uflteam->user_id = $id;
                $uflteam->follow_user_type_id = $$request->fav_team[$m];
                $uflteam->profile_type_id = 1;
                $uflteam->save();
            } else {

                $updateuserfollowtype = user_follow_type::where(['user_id' => $id, 'follow_user_type_id' => $request->fav_team[$m]])->update(['follow_status' => 1]);
            }
        }
    }
        // competition
        if($request->fav_comp)
        {
        $favcompcount = count($request->fav_comp);
        for ($k = 0; $k < $favcompcount; $k++) {
            // echo $favcomp_id[$k];
            // echo "<br/>";
            $ufc = new user_favourite();
            $ufc->user_id = $id;
            $ufc->type_id = $request->fav_comp[$k];
            $ufc->fav_type = 2;
            $ufc->save();
            $ufloc = new user_follow_type();
            $ufloc->user_id = $id;
            $ufloc->follow_user_type_id = $request->fav_comp[$k];
            $ufloc->profile_type_id = 2;
            $ufloc->save();
        }
    
        $followcompcount = count($request->fav_comp);
        for ($n = 0; $n < $followcompcount; $n++) {
            $checkfollowcompdata = user_follow_type::where(['user_id' => $id, 'follow_user_type_id' => $request->fav_comp[$n]])->first();
            // echo   $follow_comp_id[$n];
            //   echo "<br/>";
            if (empty($checkfollowcompdata)) {
                $uflcomp = new user_follow_type();
                $uflcomp->user_id = $id;
                $uflcomp->follow_user_type_id = $request->fav_comp[$n];
                $uflcomp->profile_type_id = 2;
                $uflcomp->save();
            } else {

                $updatemembership = user_follow_type::where(['user_id' => $id, 'follow_user_type_id' => $request->fav_comp[$n]])->update(['follow_status' => 1]);
            }
        }
    }
        return redirect('/dashboard');
    }
}
