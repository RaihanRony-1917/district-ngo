<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Committee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MemberRequest;
use Illuminate\Support\Facades\Storage;

class MemberRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $reqs = MemberRequest::where('status', 0)->latest()->paginate(15);
        return view('pages.requests.index', compact('reqs'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function add($id)
    {
        $req = MemberRequest::find($id);
        $committees = Committee::where('status', 1)->get();
        return view('pages.requests.add', compact('req','committees'));
    }
    public function approve(Request $request, $id){
        $req = MemberRequest::find($id);
        $member = new Member();
         $newPublicImagePath = null;

        if ($req->photo && Storage::disk('local')->exists($req->photo)) {

            $fileContents = Storage::disk('local')->get($req->photo);

            $newFileName = Str::random(40) . '.' . pathinfo($req->photo, PATHINFO_EXTENSION);

            $directory = 'uploads/members';
            $newPublicImagePath = $directory . '/' . $newFileName;

            Storage::disk('public')->put($newPublicImagePath, $fileContents);
        }
        $member->name = $req->name;
        $member->email = $req->email;
        $member->phone = $req->phone;
        $member->address = $req->address;
        $member->committee = $request->committee;
        $member->joining_date = now();
        $member->blood_grp = $req->blood_grp;
        $member->role = 'সদস্য';
        $member->serial = 3;
        $member->status = 1;
        $member->image = $newPublicImagePath;

        if ($member->save()) {

            $req->status = 1;
            $req->delete();
        }
        return redirect()->route('admin.requests.index')->with('success', 'Member approved successfully.');

    }
    /**
     * Store a newly created resource in storage.
     */
    public function reject($id)
    {
        //
        $req = MemberRequest::find($id);
        $req->status = 2;
        $req->save();
        return redirect()->route('admin.requests.index')->with('success', 'Member rejected.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MemberRequest $request)
    {
        //
        $req = MemberRequest::find($request->id);
        // dd($req);
        return view('pages.requests.show', compact('req'));
    }


    public function viewFile($id, $type)
    {
        $request = MemberRequest::findOrFail($id);
        $path = null;

        if ($type === 'photo') {
            $path = $request->photo;
        } elseif ($type === 'nid') {
            $path = $request->NID;
        }

        if (!$path || !Storage::disk('local')->exists($path)) {
            abort(404, 'File not found.');
        }

        // Return the file with the correct content type to display it
        return response()->file(Storage::disk('local')->path($path));
    }

    /**
     * Serves a file from local storage as a download.
     */
    public function downloadFile($id, $type)
    {
        $request = MemberRequest::findOrFail($id);
        $path = null;

        if ($type === 'photo') {
            $path = $request->photo;
        } elseif ($type === 'nid') {
            $path = $request->NID;
        }

        if (!$path || !Storage::disk('local')->exists($path)) {
            abort(404, 'File not found.');
        }

        // Return a download response
        return Storage::disk('local')->download($path);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MemberRequest $request)
    {
        //
        $memberRequest = MemberRequest::find($request->id);
        $memberRequest->delete();
        return redirect()->route('admin.requests.index')->with('success', 'Member request deleted successfully.');
    }
}
