<?php

namespace App\Http\Controllers;

use App\Models\Comp_member;
use App\Models\Competition_team_request;
use App\Models\Team_member;
use App\Models\User_fav_follow;
use Illuminate\Http\Request;
use App\Models\User;
// use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
use App\Models\User_profile;
use App\Models\Country;
use App\Models\Team;
use App\Models\Competition;
use App\Models\Competition_attendee;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class HomePageController extends Controller
{
    public function home()
    {
        if (Auth::user()) {
            return redirect('dashboard');
        } else {
            $country = Country::all();
            $competitions = Competition::where('comp_start', 1)->take(10)->latest()->get();
            $first_competition = Competition::where('comp_type_id', 3)->where('comp_start', 1)->take(10)->latest()->first();
            return view('frontend.home', compact('country', 'competitions', 'first_competition'));
        }
    }
    
    public function testzoho()
    {
        return view('frontend.zoho');
        //  return "test zoho";
    }


    public function SaveUserMail(Request $request)
    {

        $exists_email = User::where('email', $request->email)->get();

        if ($exists_email->isEmpty()) {
            $user = User::create([
                'email' => $request->get('email'),
                'check_popup' => 1,
                'access_token' => random_int(100000, 999999),
            ]);

            $user->attachRole('3');
            event(new Registered($user));
            $id = $user->id;
            $otp = $user->access_token;

            $this->email($request->email, "From Sportvote Team", $otp);

            return response()->json($id);
        } else {
            return response()->json('0');
        }
    }


    public function updateverification(Request $request)
    {

        $user = User::where('access_token', $request->verification_code)->where('email', $request->useremail)->first();
        if ($user) {
            Auth::login($user);


            $password = 'demo@1234';
            $user = User::find($request->userid);
            $user->password = Hash::make($password);
            $user->access_token = '0';
            $user->check_popup = 2;
            $user->save();
            return response()->json('1');
        } else {
            return response()->json('0');
        }
    }



    public function userlogin(Request $request)
    {

        return $request;
        $user = User::where('access_token', $request->otp)->where('email', $request->uemail)->first();
        if ($user) {

            Auth::login($user);
            $userId = Auth::user()->id;


            if ($user->check_popup == 1) {
                $user = User::find($userId);
                $user->check_popup = 2;
                $user->access_token = Null;
                $user->save();
            } else {
                $user = User::find($userId);
                $user->access_token = Null;
                $user->save();
            }

            $popup = User::where('id', $userId)->value('check_popup');

            // return response()->json('1');
            if ($popup == 4) {
                return response()->json(['popup' => 'popup_4', 'userid' => $userId]);
            } else if ($popup == 1) {
                return response()->json(['popup' => 'popup_1', 'userid' => $userId]);
            } else if ($popup == 2) {
                return response()->json(['popup' => 'popup_2', 'userid' => $userId]);
            } else if ($popup == 3) {
                return response()->json(['popup' => 'popup_3', 'userid' => $userId]);
            }
        } else {
            // Password not match
            return response()->json('0');
        }
    }


    public function userloginpass(Request $request)
    {
        if (auth()->attempt(array('email' => $request->uemail, 'password' => $request->pswrd), true)) {
            $userId = Auth::user()->id;
            $popup = User::where('id', $userId)->value('check_popup');
            $useracess = User::find($userId);
            $useracess->access_token = NULL;
            $useracess->save();
            if ($useracess->check_popup == 1) {
                $useracess = User::find($userId);
                $useracess->check_popup = 2;
                $useracess->save();
            }
            if ($popup == 4) {
                return response()->json(['popup' => 'popup_4', 'userid' => $userId]);
            } else if ($popup == 1) {
                return response()->json(['popup' => 'popup_1', 'userid' => $userId]);
            } else if ($popup == 2) {
                return response()->json(['popup' => 'popup_2', 'userid' => $userId]);
            } else if ($popup == 3) {
                return response()->json(['popup' => 'popup_3', 'userid' => $userId]);
            }
        } else {
            return response()->json(0);
        }
    }





    public function updatProfile(Request $request)
    {

        $request->validate(['bio' => 'required']);
        if ($request->f_name && $request->l_name && $request->dob && $request->p_location && $request->nation && $request->bio) {
            $user = User::find($request->userid);
            $user->first_name = $request->f_name;
            $user->last_name = $request->l_name;
            $user->dob = $request->dob;
            $user->location = $request->p_location;
            // $user->height = $request->height;
            // $user->weight = $request->Weight;
            $user->nationality = $request->nation;
            $user->bio = $request->bio;
            $user->check_popup = 3;
            $user->is_termcondition = $request->termsofuse;
            $user->save();
            return response()->json('1');
        } else {
            return response()->json('0');
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }






    public function create_login_otp(Request $request)
    {
        $userid = User::where('email', $request->uemail)->value('id');
        $usert = User::find($userid);
        if ($usert) {
            $otp = $usert->access_token = random_int(100000, 999999);
            $usert->save();


            $this->email($request->uemail, "From Sportvote Team", $otp);

            // $data["email"] = $request->uemail;
            // $data["title"] = "From Sportvote Team";
            // $data["body"] = $otp;

            // Mail::send('frontend.emails.visitor_email', $data, function ($message) use ($data) {
            // $message->to($data["email"], $data["email"])
            // ->subject($data["body"]);
            // });

            return response()->json($userid);
        } else {
            return response()->json('0');
        }
    }


    public function userProfile(Request $request)
    {
        $user = User::find($request->userid);
        $user->check_popup = 4;
        $user->save();
        /*  if($request->selectedValue == 3)
         {
             $user_rank = user_rank::create([
                'user_id' => $request->userid,
                'rank_id' => 1,
             ]);
         }

         if($request->selectedValue == 5)
         {
             $user_rank = user_rank::create([
                'user_id' => $request->userid,
                'rank_id' => 2,
             ]);
         } */

        return response()->json('1');
    }


    public function checkUserprofile()
    {
        $playerprofile = user_profile::where('user_id', Auth::user()->id)->where('profile_type_id', 2)->get('id');

        // return response()->json($userrank->count());
        if ($playerprofile->count() != 0) {
            return response()->json(1);
        }
        if ($playerprofile->count() == 0) {
            return response()->json(0);
        }
    }

    public function checkrefreeprofile()
    {
        $playerprofile = user_profile::where('user_id', Auth::user()->id)->where('profile_type_id', 3)->get('id');

        // return response()->json($userrank->count());
        if ($playerprofile->count() != 0) {
            return response()->json(1);
        }
        if ($playerprofile->count() == 0) {
            return response()->json(0);
        }
    }

    public function check_email_login(Request $request)
    {
        $check = User::where('email', $request->evalue)->first();
        if ($check) {
            return response()->json(1);
        } else {
            return response()->json(0);
        }

        // return response()->json($check);

    }
    public function create_password(Request $request)
    {

        // return response()->json($request);

        if ($request->password == $request->password_confirmation) {
            $user = User::find($request->userid);
            $user->password = Hash::make($request->password);
            $user->access_token = Null;
            $user->check_popup = 3;
            $user->save();
            return response()->json('1');
        } else {
            return response()->json('2');
        }
    }

    public function checkteamMenus()
    {
        $participatedteams = Team_member::where('member_id', Auth::user()->id)->where('invitation_status', 1)->with('team')->get();
        $my_team = Team::where('user_id', Auth::user()->id)->with('sport_team')->get();
        $team_follows = User_fav_follow::where('is_type', 1)->where('user_id', Auth::user()->id)->where('Is_follow', 1)->where('is_active', 1)->with('team', 'user', 'team.sport')->get();
        if ($participatedteams->count() == 0) {
            $participatedteams_count = 0;
        } else {
            $participatedteams_count = 1;
        }
        if ($my_team->count() == 0) {
            $myteams_count = 0;
        } else {

            $myteams_count = 1;
        }
        if ($team_follows->count() == 0) {
            $team_follows_count = 0;
        } else {

            $team_follows_count = 1;
        }
        return response()->json(['participatedteams' => $participatedteams_count, 'myteams' => $myteams_count, 'team_follows' => $team_follows_count]);
    }

    public function checkCompetitionMenus()
    {
        $user_id = Auth::user()->id;
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
        // return $user_participateComp_ids;
        $user_participateComp_data = Competition::whereIn('id', $user_participateComp_ids)->where('is_active', 1)->with('comp_fixture')->orderby('id', 'DESC')->get();

        $competition_request = Competition_team_request::where('user_id', Auth::user()->id)->with('competition', 'team')->latest()->get();

        $my_comp = Competition::where('user_id', Auth::user()->id)->where('comp_type_id', '!=', NULL)->where('is_active', '!=', 2)->with('sport', 'sport_comp', 'comptype', 'compsubtype')->orderby('id', 'DESC')->get();
        $my_draft_comp = Competition::where('user_id', Auth::user()->id)->where('is_active', 0)->with('sport')->latest()->get();

        $comp_follows_ids = User_fav_follow::where('is_type', 2)->where('user_id', Auth::user()->id)->where('Is_follow', 1)->where('is_active', 1)->pluck('type_id');
        $comp_follows_array = $comp_follows_ids->toArray();
        $comp_follow = Competition::whereIn('id', $comp_follows_array)->with('sport', 'sport_comp', 'comptype', 'compsubtype')->orderby('id', 'DESC')->get();
        if ($user_participateComp_data->count() == 0) {
            $competition_request_count = 0;
        } else {
            $competition_request_count = 1;
        }
        if ($my_comp->count() == 0 && $my_draft_comp->count() == 0) {
            $my_comp_count = 0;
        } else {

            $my_comp_count = 1;
        }
        if ($comp_follow->count() == 0) {
            $comp_follows_count = 0;
        } else {

            $comp_follows_count = 1;
        }
        return response()->json(['participatedcomp' => $competition_request_count, 'mycomps' => $my_comp_count, 'comp_follows' => $comp_follows_count]);
    }

    public function vanish_otp(Request $request)
    {
        if ($request->user_id) {
            $user = User::find($request->user_id);
            $user->access_token = NULL;
            $user->save();
        }
        if ($request->uemail) {
            $user = User::where('email', $request->uemail)->first();
            $users = User::find($user->id);
            $users->access_token = NULL;
            $users->save();
        }
    }

    public function search(Request $request)
    {
        $key = $request->key;
        if ($key) {
            if (true) {

                $userSearch = User::with('userProfile')->orWhere('first_name', 'like', '%' . $key . '%')->orWhere('last_name', 'like', '%' . $key . '%')->get();
                $teamSearch = Team::orWhere('name', 'like', '%' . $key . '%')->where('is_active', 1)->get();
                $competitionSearch = Competition::orWhere('name', 'like', '%' . $key . '%')->where('is_active', 1)->get();
            } else {
                $userSearch = User::with('userProfile')->orWhere('location', 'like', '' . $key . '%')->orWhere('nationality', 'like', '' . $key . '%')->get();
                $teamSearch = Team::orWhere('team_address', 'like', '%' . $key . '%')->where('is_active', 1)->get();
                $competitionSearch = Competition::orWhere('location', 'like', '%' . $key . '%')->where('is_active', 1)->get();
            }
            if (count($competitionSearch) > 0 || count($teamSearch) > 0 || count($userSearch) > 0) {
                $searchResult = array();
                $datatransfer1 = $datatransfer2 = $datatransfer3 = array();

                if (count($userSearch) > 0) {
                    foreach ($userSearch as $u) {
                        if ($u->userProfile) {
                            $datatransfer1['id'] = $u->id;
                            $datatransfer1['name'] = $u->first_name . ' ' . $u->last_name;
                            if ($u->profile_pic != '' && $u->profile_pic) {
                                $datatransfer1['profile'] = asset('/frontend/profile_pic/' . $u->profile_pic);
                            } else {
                                $datatransfer1['profile'] = asset('/frontend/profile_pic/default_profile_pic.png');
                            }
                            if ($u->userProfile->profile_type_id == 2) {
                                $datatransfer1['type'] = 'Player';
                                $datatransfer1['typeId'] = 1;
                                $datatransfer1['url'] = route('player_profile.show', $u->id);
                            }
                            if ($u->userProfile->profile_type_id == 3) {
                                $datatransfer1['type'] = 'Referee';
                                $datatransfer1['typeId'] = 1;
                                $datatransfer1['url'] = route('player_profile.show', $u->id);
                            }

                            array_push($searchResult, $datatransfer1);
                        }
                    }
                }

                if (count($teamSearch) > 0) {
                    foreach ($teamSearch as $t) {
                        $datatransfer2['id'] = $t->id;
                        $datatransfer2['name'] = $t->name;
                        if ($t->team_logo != '' && $t->team_logo) {
                            $datatransfer2['profile'] = asset('/frontend/logo/' . $t->team_logo);
                        } else {
                            $datatransfer2['profile'] = asset('/frontend/logo/default-team-logo.png');
                        }
                        $datatransfer2['type'] = 'Team';
                        $datatransfer2['typeId'] = 2;
                        $datatransfer2['url'] = route('team.show', $t->id);

                        array_push($searchResult, $datatransfer2);
                    }
                }

                if (count($competitionSearch) > 0) {
                    foreach ($competitionSearch as $c) {
                        $datatransfer3['id'] = $c->id;
                        $datatransfer3['name'] = $c->name;

                        $datatransfer3['profile'] = asset('/frontend/logo/competitions-icon-128.png');

                        if ($c->comp_logo != '' && $c->comp_logo) {
                            $datatransfer3['profile'] = asset('/frontend/logo/' . $c->comp_logo);
                        }
                        $datatransfer3['type'] = 'Competition';
                        $datatransfer3['typeId'] = 3;
                        $datatransfer3['url'] = route('competition.show', $c->id);

                        array_push($searchResult, $datatransfer3);
                    }
                }
                if (count($searchResult) > 0) {
                    return response()->json(['status' => 200, 'result' => $searchResult, 'message' => 'Your search found ' . count($searchResult) . ' recoards']);
                } else {
                    return response()->json(['status' => 201, 'message' => 'No Search Found']);
                }
            } else {
                return response()->json(['status' => 201, 'message' => 'No Search Found']);
            }
        } else {
            return response()->json(['status' => 404, 'message' => 'Please enter a value to be search.']);
        }
    }
}
