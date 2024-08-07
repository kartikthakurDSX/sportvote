<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\competition_type;
use App\Models\CompSubType;
use Illuminate\Http\Request;

class CompSubTypeController extends Controller
{
    //
    public function index()
    {
        $compSubtypes = CompSubType::get();
        return view('backend.admin.comp_sub_types.index', compact('compSubtypes'));
    }
    public function add()
    {
        $competitionTypes = competition_type::get();

        return view('backend.admin.comp_sub_types.create', compact('competitionTypes'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'competition_type_id' => ['required'],
            'max_number' => ['required'],
            'min_number' => ['required'],
        ]);

        $minValue = $request['min_number'];
        $maxValue = $request['max_number'];
        $arr = [$minValue, $maxValue];
        $team_number = implode("-", $arr);

        $competitionSubType = ([
            'name' => $request->name,
            'description' => $request->description,
            'competition_type_id' =>  $request->competition_type_id,
            'team_number' => $team_number,

        ]);

        CompSubType::create($competitionSubType);

        return redirect('admin-comp-subtype')->with('message', 'New competition sub-type added successfully!');
    }

    public function edit($id)
    {
        $compTypes = competition_type::all();
        $competitionSubType = CompSubType::find($id);
        $data = compact('compTypes', 'competitionSubType');
        return view('backend.admin.comp_sub_types.edit')->with($data);
    }

    //To Update Comp Subtype
    public function update($id, Request $request)
    {
        $compSubType = CompSubType::find($id);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'competition_type_id' => ['required'],
            'min_number' => ['required', 'numeric'],
            'max_number' => ['required', 'numeric'],
        ]);
        $minValue = $request['min_number'];
        $maxValue = $request['max_number'];
        $arr = [$minValue, $maxValue];
        $team_number = implode("-", $arr);

        $compSubType->name = $request['name'];
        $compSubType->description = $request['description'];
        $compSubType->competition_type_id = $request['competition_type_id'];
        $compSubType->team_number = $team_number;


        $compSubType->save();

        return redirect('admin-comp-subtype')->with('message', ' competition sub-type Updated successfully!');
    }

    //To Delete Competetition SubType
    public function delete(CompSubType $compSubType)
    {
        $compSubType->delete();

        return back()->with('message', 'Competition Sub Type  deleted.');
    }
}
