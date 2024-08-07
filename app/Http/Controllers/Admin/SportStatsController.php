<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Sport;
use App\Models\Sport_stat;
use Illuminate\Http\Request;

class SportStatsController extends Controller
{
    //To Show  Sport stats table
    public function index()
    {
        $sportStats = Sport_stat::all();
        $sports = Sport::all();
        return view('backend.admin.sport_stats.index', compact('sportStats', 'sports'));
    }
    //To Show Add Sport stats form
    public function add()
    {
        $sports = Sport::all();
        return view('backend.admin.sport_stats.create', compact('sports'));
    }
    //To create new Sport Stat
    public function Create(Request $request)
    {


        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'sport_id' => ['required'],
            'stat_type' => ['required'],
            'is_calc' => ['required'],
            'must_track' => ['required'],
        ]);

        $sportStat = ([
            'name' => $request->name,
            'description' => $request->description,
            'sport_id' => $request->sport_id,
            'stat_type' => $request->stat_type,
            'is_calculated' => $request->is_calc,
            'calc_type' => $request->calc_type,
            'must_track' => $request->must_track,
        ]);

        Sport_stat::create($sportStat);
        return redirect('admin.sport-stats')->with('message', 'Sport Stat Successfully Added!');
    }
    //For show Edit form for Sport stats
    public function edit($id)
    {
        $sports = Sport::all();
        $sportStat = Sport_stat::find($id);

        return view('backend.admin.sport_stats.edit', compact('sports', 'sportStat'));
    }

    //for update Sport Stats
    public function update($id, Request $request)
    {


        $sportStat = Sport_stat::find($id);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'sport_id' => ['required'],
            'stat_type' => ['required'],
            'is_calc' => ['required'],
            'must_track' => ['required'],
        ]);


        $sportStat->name = $request['name'];
        $sportStat->description = $request['description'];
        $sportStat->sport_id = $request['sport_id'];
        $sportStat->stat_type = $request['stat_type'];
        $sportStat->is_calculated = $request['is_calc'];
        $sportStat->must_track = $request['must_track'];
        $sportStat->calc_type = $request['calc_type'];

        $sportStat->save();
        return redirect('admin.sport-stats')->with('message', 'Sport Stat Successfully Updated!');
    }
    public function delete(Sport_stat $sportStat)
    {
        $sportStat->delete();

        return back()->with('message', 'Sport-level deleted.');
    }

    //To active inactive status
    // public function inactive($id)
    // {
    //     $sportStat = Sport_stat::find($id);
    //     $sportStat->is_active = 0;
    //     $sportStat->save();

    //     return redirect('admin/sport-stats');
    // }
    // public function active($id)
    // {
    //     $sportStat= Sport_stat::find($id);
    //     $sportStat->is_active = 1;
    //     $sportStat->save();

    //     return redirect('admin/sport-stats');
    // }
    public function changeStatus(Request $request)
    {
        $sportStat = Sport_stat::find($request->id);
        $sportStat->is_active = $request->status;
        $sportStat->save();

        return response()->json(['success' => 'Status change successfully.']);
    }
    //To showing detail

    public function detail($id)
    {
        $sportStat = Sport_stat::find($id);
        return view('backend.sport stats.show', compact('sportStat'));
    }
}
