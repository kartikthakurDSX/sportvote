<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member_position;
use App\Models\Sport;
use Illuminate\Http\Request;

class MemberPositionController extends Controller
{
    //for Show index of Member position
    public function index()
    {
        $MemberPositions = Member_position::all();
        $sports = Sport::all();
        return view('backend.admin.member_positions.index', compact('MemberPositions', 'sports'));
    }
    //for Add Member position
    public function add()
    {
        $sports = Sport::all();
        return view('backend.admin.member_positions.create', compact( 'sports'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name'=>['required', 'string', 'max:255'],
            'description' => ['required'],
            'sport_id' => ['required'],
            'member_type' => ['required'],
        ]);
        $MemberPosition = ([
            'name'=> $request->name,
            'description'=> $request->description,
            'sport_id'=> $request->sport_id,
            'member_type'=> $request->member_type,
        ]);


        Member_position:: create($MemberPosition);
         return redirect('admin-member-position')->with('message', 'Successfully added');
    }

    //For Active and inactive
    public function changeStatus(Request $request)
    {
        $MemberPosition = Member_position::find($request->id);
        $MemberPosition->is_active = $request->status;
        $MemberPosition->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    //for Edit Member positions
    public function edit($id)
    {
        $MemberPosition = Member_position::find($id);
        $sports = Sport::all();
        return view('backend.admin.member_positions.edit', compact('MemberPosition', 'sports'));
    }

    public function update($id, Request $request)
    {
        $MemberPosition = Member_position::find($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'sport_id' => ['required'],
            'member_type' => ['required'],
        ]);

        $MemberPosition->name = $request['name'];
        $MemberPosition->description = $request['description'];
        $MemberPosition->sport_id = $request['sport_id'];
        $MemberPosition->member_type = $request['member_type'];

        $MemberPosition->save();
        return redirect('admin-member-position')->with('message', 'Updated Successfully');
    }

    //For Delete
    public function delete(Member_position $MemberPosition)
    {
        $MemberPosition->delete();
        return back()->with('message', 'Deleted Successfullly');
    }

    //For Showing Details
    public function detail($id)
    {
          $MemberPosition = Member_position::find($id);
          return view('backend.member_positions.show', compact('MemberPosition'));
    }
}
