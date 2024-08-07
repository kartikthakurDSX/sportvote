<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comp_report_type;
use App\Models\Sport;
use App\Models\Sport_stat;
use Illuminate\Http\Request;

class CompReportTypeController extends Controller
{
    //

    public function index()
    {
        $CompReportTypes = Comp_report_type::get();
        $sportStats = Sport_stat::get();

        return view('backend.admin.Comp_report_types.index', compact('CompReportTypes', 'sportStats'));
    }

    public function add()
    {
        $sportStats = Sport_stat::all();
        $sports = Sport::all();
        return view('backend.admin.Comp_report_types.create', compact('sportStats', 'sports'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sport_id' => ['required'],
            'sport_stats_id' => ['required'],
        ]);
        $arr = $request->sport_stats_id;
        $sportstat = implode(',', $arr);
        $CompReportType = ([
            'name' => $request->name,
            'sport_id' => $request->sport_id,
            'sport_stat_id' => $sportstat,
        ]);

        // dd($CompReportType);
        Comp_report_type::create($CompReportType);
        return redirect('admin-comp-report-type');
    }
    public function edit($id)
    {
        $sportStats = Sport_stat::all();
        $sports = Sport::all();
        $CompReportType = Comp_report_type::find($id);
        return view('backend.admin.Comp_report_types.edit', compact('sports', 'CompReportType', 'sportStats'));
    }

    public function update($id, Request $request)
    {
        $CompReportType = Comp_report_type::find($id);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sport_id' => ['required'],
            'sport_stats_id' => ['required'],
        ]);
        $arr = $request->sport_stats_id;
        $sportstat = implode(',', $arr);

        $CompReportType->name = $request['name'];
        $CompReportType->sport_id = $request['sport_id'];
        $CompReportType->sport_stat_id = $sportstat;

        $CompReportType->save();
        return redirect('admin-comp-report-type');
    }

    //For Delete Comp Report Type
    public function delete($id)
    {
        $CompReportType = Comp_report_type::find($id);

        $CompReportType->delete();

        return back()->with('message', 'compettition report type deleted.');
    }

    public function changeStatus(Request $request)
    {
        $CompReportType = Comp_report_type::find($request->id);
        $CompReportType->is_active = $request->status;
        $CompReportType->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

}
