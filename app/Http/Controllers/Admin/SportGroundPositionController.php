<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SportGroundPosition;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class SportGroundPositionController extends Controller
{
    //For show index of Sport Ground Position
    public function index()
    {

        $SportGroundMaps = DB::table('sport_ground_maps')->select('id', 'name')->get();
        $SportGroundPositions = SportGroundPosition::all();

        return view('backend.admin.sport_ground_positions.index', compact('SportGroundMaps', 'SportGroundPositions'));
    }

    //For Add Sport Ground Position
    public function add()
    {
        $SportGroundMaps = DB::table('sport_ground_maps')->select('id', 'name')->get();

        return view('backend.admin.sport_ground_positions.create', compact('SportGroundMaps'));
    }
    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'sport_ground_map_id' => ['required'],
            'ground_coordinates' => ['required'],
        ]);

        $SportGroundPosition = ([
            'name' => $request['name'],
            'description' => $request['description'],
            'sport_ground_map_id' => $request['sport_ground_map_id'],
            'ground_coordinates' => $request['ground_coordinates'],
        ]);

        SportGroundPosition::create($SportGroundPosition);

        return redirect('admin-sport-ground-positions')->with('message', 'successfully added');
    }

    //For active inactive
    public function changeStatus(Request $request)
    {
        $SportGroundPosition = SportGroundPosition::find($request->id);
        $SportGroundPosition->is_active = $request->status;
        $SportGroundPosition->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    //For Edit Sport Ground Positions
    public function edit($id)
    {
        $SportGroundPosition = SportGroundPosition::find($id);
        $SportGroundMaps = DB::table('sport_ground_maps')->select('id', 'name')->get();

        return view('backend.admin.sport_ground_positions.edit', compact('SportGroundPosition', 'SportGroundMaps'));
    }

    public function update($id, Request $request)
    {
        $SportGroundPosition = SportGroundPosition::find($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'sport_ground_map_id' => ['required'],
            'ground_coordinates' => ['required'],
        ]);

        $SportGroundPosition->name = $request['name'];
        $SportGroundPosition->description = $request['description'];
        $SportGroundPosition->sport_ground_map_id = $request['sport_ground_map_id'];
        $SportGroundPosition->ground_coordinates = $request['ground_coordinates'];

        $SportGroundPosition->save();

        return redirect('admin-sport-ground-positions')->with('message', 'successfully Updated');
    }

    public function delete(SportGroundPosition $SportGroundPosition)
    {
        $SportGroundPosition->delete();
        return back()->with('message', 'Sport Ground Position deleted');
    }
    //For Showing full details
    public function detail($id)
    {
        $SportGroundPosition = SportGroundPosition::find($id);
        return view('backend.sport_ground_positions.show', compact('SportGroundPosition'));
    }
}
