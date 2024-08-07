<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\competition_type;
use Illuminate\Http\Request;

class CompTypeController extends Controller
{
    //For showing competition type table

    public function index()
    {
        $competitions = competition_type::all();
        return view('backend.admin.Comp_types.index', compact('competitions'));
    }

    //For show add competition type
    public function add()
    {
        return view('backend.admin.Comp_types.create');
    }

    //To add competition type
    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon' => ['image'],
        ]);


        //Move Uploaded File to public folder
        $folder = 'backend/competition_types/images';
        $image = $_FILES['icon']['name'];
        $request->icon->move(public_path($folder), $image);

        $competitionType = ([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $image,

        ]);


        competition_type::create($competitionType);

        return redirect('admin-comp-type')->with('message', 'New competition type added successfully!');
    }

    //To show Edit competition type
    public function edit($id)
    {
        $competitionTypes = competition_type::find($id);
        if (is_null($competitionTypes)) {
            return redirect('admin-comp-type');
        } else {

            $data = compact('competitionTypes');
            return view('backend.admin.Comp_types.edit')->with($data);
        }
    }

    //To update competition type

    public function update($id, Request $request)
    {
        $competitionTypes = competition_type::find($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],

        ]);
        if (!empty($_FILES['icon']['name'])) {
            //Move Uploaded File to public folder
            $folder = 'backend/competition_types/images';
            $image = $_FILES['icon']['name'];
            $request->icon->move(public_path($folder), $image);

            $competitionTypes->name = $request['name'];
            $competitionTypes->description = $request['description'];
            $competitionTypes->icon = $image;
        }

        if (empty($_FILES['icon']['name'])) {
            $competitionTypes->name = $request['name'];
            $competitionTypes->description = $request['description'];
        }

        $competitionTypes->save();

        return redirect('admin-comp-type')->with('message', 'Successfullly updated');
    }

    //To delete Competition type

    public function delete(competition_type $module)
    {
        $module->delete();

        return back()->with('message', 'Competition type  deleted.');
    }


    // For change status
    public function changeStatus(Request $request)
    {
        $sport = competition_type::find($request->id);
        $sport->is_active = $request->status;
        $sport->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    //for Show details of Competition Type
    public function detail($id)
    {
        $CompType = competition_type::find($id);
        return view('backend.Competition_types.show', compact('CompType'));
    }
}
