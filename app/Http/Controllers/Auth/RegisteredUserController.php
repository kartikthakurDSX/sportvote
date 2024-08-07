<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Profile_type;
use App\Models\User_profile;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $countries = Country::get();
        $profiletype = Profile_type::get();
        return view('auth.register', compact('countries', 'profiletype'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phonenumber' => ['required'],
            'height' => ['required'],
            'weight' => ['required'],
            'bio' => ['required'],
            'location' => ['required'],
            'nationality' => ['required'],
            'dob' => ['required'],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phonenumber' => $request->phonenumber,
            'height' => $request->height,
            'weight' => $request->weight,
            'bio' => $request->bio,
            'location' => $request->location,
            'nationality' => $request->nationality,
            'dob' => $request->dob,
        ]);
          // $id = $user->id;
          // $userprofiles = new User_profile();
          // $userprofiles->user_id = $id;
          // $userprofiles->profile_type_id = $request->get('profile_type');
          // $userprofiles->save();

        $user->attachRole($request->role_id);
        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
