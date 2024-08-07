<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sport;
use App\Models\Sport_level;
use Illuminate\Http\Request;

class SportLevelController extends Controller
{
    //To Show index of Sport level

    public function index()
    {
        $sportlevels = Sport_level::all();

        $sports = Sport::all();

        // $sports = Sport_level::find()->SportvoteSport;

        return view('backend.admin.sports_levels.index', compact('sportlevels', 'sports'));
    }

    //To add Sport Level
    public function add()
    {
        $sports = Sport::all();
        return view('backend.admin.sports_levels.create', compact('sports'));
    }

    //TO ADD SPORT LEVEL
    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $sportlevel = ([
            'name' => $request->name,
            'description' => $request->description,
            'sport_id' => $request->sport_id,
        ]);

        Sport_level::create($sportlevel);
        return redirect('admin-sport-levels')->with('message', 'Sport Level successfully added');
    }

    //TO SHOW EDIT LEVEL PAGE
    public function edit($id)
    {
        $sportslevel = Sport_level::find($id);

        $sports = Sport::all();

        if (is_null($sportslevel)) {
            return redirect('admin-sport-levels');
        } else {


            return view('backend.admin.sports_levels.edit', compact('sportslevel', 'sports'));
        }
    }

    //TO UPDATE SPORT LEVEL
    public function update($id, Request $request)
    {
        $sport = Sport_level::find($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'sport_id' =>['required'],


        ]);


        $sport->name = $request['name'];
        $sport->description = $request['description'];
        $sport->sport_id = $request['sport_id'];



        $sport->save();
        return redirect('admin-sport-levels')->with('message', ' Sport level updated successfully!');
    }

    //To delete Sport-level

    public function delete(Sport_level $sport)
    {
        $sport->delete();

        return back()->with('message', 'Sport-level deleted.');
    }
    //To change status.....

    public function changeSportLevelStatus(Request $request)
    {
        $sport = Sport_level::find($request->id);
        $sport->is_active = $request->status;
        $sport->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    //For showing details of sport level
    public function detail($id)
    {
        $SportLevel = Sport_level::find($id);
        return view('backend.sports_levels.show', compact('SportLevel'));
    }

}
