<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Sport;


use Illuminate\Http\Request;


class SportsController extends Controller
{
    //...........................FOR SPORTS.....................................
    public function index()
    {
        $sports = Sport::all();
        return view('backend.admin.sports.index', compact('sports'));
    }

    public function add()
    {
        return view('backend.admin.sports.create');
    }

    public function  create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'alpha', 'max:255'],
            'description' => ['required', 'string'],
            'icon' => ['required'],


        ]);


        //Move Uploaded File to public folder
        $folder = 'backend/sports/images';
        $image = $_FILES['icon']['name'];
        $request->icon->move(public_path($folder), $image);

        $sport = ([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $image,

        ]);
        Sport::create($sport);

        return redirect('admin-sports')->with('message', 'New Sport added successfully!');
    }


    //for edit sport

    public function edit($id)
    {
        $sport = Sport::find($id);
        if (is_null($sport)) {
            return redirect('admin/sportsystem');
        } else {
            $url = url('/admin/sport/edit') . "/" . $id;
            $data = compact('sport', 'url');
            return view('backend.admin.sports.edit_sports')->with($data);
        }
    }

    //To update Sports

    public function update($id, Request $request)
    {
        $sport = Sport::find($id);

        $request->validate([
            'name' => ['required', 'alpha', 'max:255'],
            'description' => ['required', 'string'],


        ]);

        if (!empty($_FILES['icon']['name'])) {
        //Move Uploaded File to public folder
        $folder = 'admin/sports/images';
        $image = $_FILES['icon']['name'];
        $request->icon->move(public_path($folder), $image);


            $sport->name = $request['name'];
            $sport->description = $request['description'];
            $sport->icon = $image;
        }
        if (empty($_FILES['icon']['name'])) {
            $sport->name = $request['name'];
            $sport->description = $request['description'];
        }

        $sport->save();
        return redirect('admin-sports')->with('message', ' Sport updated successfully!');



    }

    //For Show details of Sports
    public function details($id)
    {
        $sport = Sport::find($id);
        return view('backend.sports.show_sports_detail', compact('sport'));
    }
    //For Change Status
    public function changeSportStatus(Request $request)
    {
        $sport = Sport::find($request->id);
        $sport->is_active = $request->status;
        $sport->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function delete(Sport $sport)
    {
        $sport->delete();

        return back()->with('message', 'Sport Deleted successfully!');

    }






}
