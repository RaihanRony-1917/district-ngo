<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Committee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::orderBy('serial')->paginate(1, ['*'], 'members_page');
        $committees = Committee::orderBy('serial')->paginate(10, ['*'], 'committees_page');
        return view('pages.members.index', compact('members', 'committees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $committees = Committee::where('status', 1)->get();
        return view('pages.members.form', compact('committees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required',
           'email' => 'email',
           "phone" => "required",
        //    "address" => "required",
        //    "committee" => "required",
           "joining_date" => "date",
           "blood_group" => "required",
           "role" => "required",
            "serial" => "required|integer",
            "status" => "integer",
            "image" => "required|image|mimes:jpeg,png,jpg,gif,avif,svg|max:9048",
        ]);
        $member = new Member();


        $member->name = $request->name;
        $member->email = $request->email;
        $member->phone = $request->phone;
        $member->address = $request->address;
        $member->committee = $request->committee;
        $member->joining_date = $request->joining_date;
        $member->blood_grp = $request->blood_group;
        $member->role = $request->role;
        $member->serial = $request->serial;

        if($request->hasFile('image')) {
            $member->image = supaUploader($request->file('image'), 'uploads/members');
            $member->save();
            return redirect()->route('admin.members.index')->with('success', 'Member created successfully.');
        }
        return redirect()->route('admin.members.index')->with('error', 'Something went wrong.');

    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        $member = Member::find($member->id);
        $committees = Committee::where('status', 1)->get();

        return view('pages.members.form', compact('member', 'committees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        // dd($request->all());
        $request->validate([
           'name' => 'required',
           'email' => 'email',
           "phone" => "required",
        //    "address" => "required",
           "committee" => "required",
           "joining_date" => "date",
           "blood_group" => "required",
           "role" => "required",
            "serial" => "required|integer",
            "status" => "required|integer",
            "image" => "image|mimes:jpeg,png,jpg,gif,avif,svg|max:9048",
        ]);

        $member = Member::findOrFail($member->id);
        if($request->hasFile('image')){
            $member->image = supaUpdater($member->image,$request->file('image'), 'uploads/members');
        }
         $member->name = $request->name;
        $member->email = $request->email;
        $member->phone = $request->phone;
        $member->address = $request->address;

        $member->committee = $request->committee;
        $member->joining_date = $request->input('joining_date');
        $member->blood_grp = $request->blood_group;
        $member->role = $request->role;
        $member->serial = $request->serial;
        $member->status = $request->status;
        $member->save();
        return redirect()->route('admin.members.index')->with('success', 'Member created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member = Member::findOrFail($member->id);
        supaDeleter($member->image);
        $member->delete();
        return redirect()->route('admin.members.index')->with('success', 'Member deleted successfully.');
    }

    public function status($id) {
        $member = Member::find($id);
        $member->status = !$member->status;

        $member->save();
        return redirect()->route('admin.members.index')->with('success', 'Member status updated successfully.');
    }
}
