<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sport;
use App\Models\SportGroundMap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SportGroundMapController extends Controller
{
    //To show index of SportGround Map
    public function index()
    {
        $sports = Sport::all();
        $SportGroundMaps = DB::table('sport_ground_maps')->get();

        return view('backend.admin.Sport_Ground_Map.index', compact('sports', 'SportGroundMaps'));
    }

    //To  add Sport Ground maps
    public function add()
    {
        $sports = Sport::all();
        return view('backend.admin.Sport_Ground_Map.create', compact('sports'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'sport_id' => ['required'],
            'number_of_positions' => ['required', 'numeric'],
        ]);

        $SportGroundMap = ([
            'name' => $request->name,
            'description' => $request->description,
            'sports_id' => $request->sport_id,
            'number_of_positions' => $request->number_of_positions,
        ]);

        SportGroundMap::create($SportGroundMap);
        return redirect('admin-sport-ground-map')->with('message', 'Sport Ground map created!');
    }

    //To change Status

    public function changeStatus(Request $request)
    {
        $SportGroundMap = SportGroundMap::find($request->id);
        $SportGroundMap->is_active = $request->status;
        $SportGroundMap->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    //To Edit Sport Ground Map

    public function edit($id)
    {
        $SportGroundMap = SportGroundMap::find($id);
        $sports = Sport::all();

        return view('backend.admin.Sport_Ground_Map.edit', compact('SportGroundMap', 'sports'));
    }

    public function update($id, Request $request)
    {
        $SportGroundMap = SportGroundMap::find($id);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'sport_id' => ['required'],
            'number_of_positions' => ['required', 'numeric'],
        ]);

        $SportGroundMap->name = $request['name'];
        $SportGroundMap->description = $request['description'];
        $SportGroundMap->sports_id = $request['sport_id'];
        $SportGroundMap->number_of_positions = $request['number_of_positions'];

        $SportGroundMap->save();
        return redirect('admin-sport-ground-map')->with('message', 'Sport Ground map updated!');

    }

    public function delete(SportGroundMap $SportGroundMap)
    {
        $SportGroundMap->delete();
        return back()->with('message', 'Sport Ground map deleted');
    }

    //For Showing full details
    public function detail($id)
    {
        $SportGroundMap = SportGroundMap::find($id);
        return view('backend.admin.Sport_Ground_Map.show', compact('SportGroundMap'));
    }
}
