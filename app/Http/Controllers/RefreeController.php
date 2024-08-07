<?php

namespace App\Http\Controllers;

use App\Models\Comp_member;
use App\Models\Competition;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\User_profile;
use App\Models\user_sport_cerification;
use App\Models\user_sport_membership;
use App\Models\Sport;
use App\Models\Sport_level;
use App\Models\Sport_attitude;
use App\Models\Team;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use App\Models\User_friend;
use App\Models\Team_member;
use App\Models\User_fav_follow;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RefreeController extends Controller
{

    public function index()
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $countries = Country::all();
        $sports = Sport::all();
        $usportlevel = Sport_level::all();
        $usportattitude = Sport_attitude::all();
        $ufplayer = Role::where('name', 'user')->first()->users()->get();
        $ufplayers = User_profile::where('profile_type_id',2)->with('user')->get();
        $ufavteam = Team::all();
        $competitions = Competition::all();
        $sport_level = Sport_level::all();

        $is_referee = User_profile::where('profile_type_id', 3)
        ->groupBy('user_id')
        ->pluck('user_id');

        $referee_array = $is_referee->toArray();

        if(in_array(Auth::user()->id, $referee_array))
        {
            return redirect('/');
        }
        else
        {
        return view('frontend.refrees.create',compact('sport_level','ufplayer','data','competitions','countries','sports','usportlevel','usportattitude','ufplayers','ufavteam'));
        }
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'profile_pic' => ['image'],
            // 'sport' => ['required'],
            // 'first_name' => ['required'],
            // 'last_name' => ['required'],
            // 'dob' => ['required'],
            // 'bio' => ['required'],
            // 'nationality' => ['required'],
            // 'location' => ['required'],
            // 'Preferred_position' => ['required'],
            // 'sport_level' => ['required'],
            // 'pref_position' => ['required'],
            // 'cover_letter' => ['required'],
        ]);

        //if validation fails
        if($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)->withInput();
        }

        // if($request->get('accept_comp_invite'))
        // {
        //     $accept_comp_invite = implode(",", $request->get('accept_comp_invite'));
        // }
        // else
        // {
        //     $accept_comp_invite = " ";
        // }

        // if($request->get('accept_user_invite'))
        // {
        //     $accept_user_invite = implode(",", $request->get('accept_user_invite'));
        // }
        // else
        // {
        //     $accept_user_invite = " ";
        // }

        $userprofiles = new User_profile([
        'user_id' => auth::user()->id,
        'sport_id' => $request->get('sport'),
        'sport_level_id' => $request->get('sport_level'),
        'profile_type_id' => 3,
        'accept_team_invite' => $request->get('accept_comp_invite'),
        'accept_user_invite' => $request->get('accept_user_invite'),
    ]);
    if ($request->hasFile('level_proof')) {
        $file = $request->file('level_proof');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $destinationPath = public_path('/frontend/certificate/');
        $file->move($destinationPath, $filename);
        $userprofiles->level_proof = $filename;
    }
    $userprofiles->save();

    $id = Auth::user()->id;
    $users = User::find($id);
    $users->first_name = $request->first_name;
    $users->last_name = $request->last_name;
    $users->dob = $request->dob;
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
        for ($x = 0; $x < count($request->certname); $x++) {
        if($request->certname[$x])
        {
            $usersport_certification = new user_sport_cerification();
            $usersport_certification->user_id = $id;
            $usersport_certification->sport_id = $request->sport;
            $usersport_certification->name = $request->certname[$x];
            $usersport_certification->description = $request->certdescription[$x];

            if($request->certificate){
                $file = $request->certificate[$x];
                if ($file->isValid()) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $destinationPath = public_path('/frontend/certificate/');
                    $file->move($destinationPath, $filename);
                    $usersport_certification->certificate = $filename;
                }
            }
            $usersport_certification->save();

        }
    }

    }

    if($request->name)
    {
        // user sport membership
        for ($x = 0; $x < count($request->name); $x++) {
            if($request->name[$x])
            {
                $usersport_membership = new user_sport_membership();
                $usersport_membership->user_id = $id;
                $usersport_membership->sport_id = $request->sport;
                $usersport_membership->name = $request->name[$x];
                $usersport_membership->description = $request->description[$x];
                if($request->logo){
                    $file = $request->logo[$x];
                    if ($file->isValid()) {
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $destinationPath = public_path('/frontend/logo/');
                        $file->move($destinationPath, $filename);
                        $usersport_membership->logo = $filename;
                    }
                }
                $usersport_membership->save();
            }

        }
    }

    // add more
    if($request->search)
    {
        for ($x = 0; $x < count($request->search); $x++) {
            if($request->search[$x] != 0)
            {
                $action_user_id = Competition::find($request->search[$x]);
                $check_team = Comp_member::where('member_id',$id)->where('comp_id',$request->search[$x])->get();
                if($check_team->isEmpty())
                {
                    $compjoins = new Comp_member();
                    $compjoins->user_id = $action_user_id->user_id;
                    $compjoins->comp_id = $request->search[$x];
                    $compjoins->member_id = $id;
                    $compjoins->member_position_id = 6;
                    $compjoins->alt_member_position_id1 = $request->altposition1[$x];
                    $compjoins->alt_member_position_id2 = $request->altposition2[$x];
                    $compjoins->reason = $request->cover_letter[$x];
                    $compjoins->save();
                    $compjoin_id = $compjoins->id;

                    // store data in notification table
                    $notification = Notification::create([
                        'notify_module_id' => 11,
                        'type_id' => $compjoin_id,
                        'sender_id' => Auth::user()->id,
                        'reciver_id' => $action_user_id->user_id,
                    ]);
                }
            }
        }
    }
    //
    return redirect('dashboard');
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
}
