<?php

namespace App\Http\Controllers\Admin;
use App\Models\Role_user;
use App\Models\User;
use App\Models\Team;
use App\Models\Competition;
use App\Models\User_profile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\hasRole;


class AdminLoginController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            // if(Auth::user()->hasRole('superadmin')  == 'superadmin')
            if(Auth::user())
            {
                return redirect('admin-dashboard');
            }
            else
            {
                return view('backend.admin.login');
            }
        }
        else
        {
            return view('backend.admin.login');
        }
    }
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::find(Auth::user()->id);
            Auth::login($user);
            $role_check = Role_user::where('role_id',1)->pluck('user_id');
            $super_admins_id = $role_check->toArray();
            if(in_array(Auth::user()->id, $super_admins_id))
            {
                return redirect('admin-dashboard');
            }
            else
            {
                return redirect('admin-panel');
            }
        }
        else
        {
            return redirect('admin-panel');
        }
    }
    public function dashboard()
    {
        if(Auth::check())
        {
            // if(Auth::user()->hasRole('superadmin')  == 'superadmin')
if(Auth::user())
            {
                $total_teams = Team::where('is_active',1)->get();
                $total_comp = Competition::where('is_active',1)->get();
                $total_players = User_profile::where('profile_type_id',2)->count();
                $total_referee = User_profile::where('profile_type_id',3)->count();
                $total_users = User::count();
                $team_admins = $total_teams->groupBy('user_id');
                $comp_admins = $total_comp->groupBy('user_id');
                return view('backend.dashboard',compact('total_teams','total_comp','total_players','team_admins','comp_admins','total_referee','total_users'));
            }
            else
            {
                return redirect('admin-panel');
            }

        }
        else
        {
            return redirect('admin-panel');
        }

    }
    public function logout()
    {
        Auth::logout();
        return redirect('admin-panel');
    }


}
