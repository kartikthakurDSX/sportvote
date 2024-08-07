<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sport_attitude;
use Illuminate\Http\Request;

class Sport_attitudeController extends Controller
{
    public function index()
    {
        $sports = Sport_attitude::all();
        return view('backend.admin.Sport_attitudes.index', compact('sports'));
    }

    //For show add-sports-attitude form

    public function add()
    {
        return view('backend.admin.Sport_attitudes.create');
    }

    //For add Sports-attitude
    public function create(Sport_attitude $sportAttitude, Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);




        $sportAttitude->name = $request['name'];
        $sportAttitude->description = $request['description'];

        $sportAttitude->save();
        return redirect('admin-sport-attitude')->with('message', 'Sport Attitude Added Successfully!');
    }

    //To delete Sport-Attitude

    public function delete(Sport_attitude $sport)
    {
        $sport->delete();

        return back()->with('message', 'Sport-Attitude deleted.');
    }

    //For sports Attitude edit form show

    public function edit($id)
    {
        $sport = Sport_attitude::find($id);
        return view('backend.admin.Sport_attitudes.edit', compact('sport'));
    }

    //For update Sport Attitude

    public function update($id, Request $request)
    {
        $sport = Sport_attitude::find($id);

        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        $sport->name = $request['name'];
        $sport->description = $request['description'];

        $sport->save();

        return redirect('admin-sport-attitude')->with('message', 'Sport Attitude updated successfully');
    }

    //For Change status fo sport Attitude
    public function changeStatus(Request $request)
    {
        $sport = Sport_attitude::find($request->id);
        $sport->is_active = $request->status;
        $sport->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    //For showing Detail of sport Attitude
    public function detail($id)
    {
        $sport= Sport_attitude::find($id);
        return view('', compact('SportAttitude'));
    }
}
