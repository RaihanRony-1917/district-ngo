<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
     public function index()
    {
        $activities = Activity::orderBy('serial', 'asc')->paginate(15);
        return view('pages.activity.index', compact('activities'));
    }


    public function create()
    {
        return view('pages.activity.form');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:png,svg|max:9048',
            'icon' => 'required|image|mimes:jpeg,jpg,gif,png,svg|max:9048',
            'serial' => 'required|integer',
        ]);


        $activity = new Activity();
        $activity->title = $request->title;
        $activity->lang_id = 1;
        $activity->short_text = $request->short_text;
        $activity->content = $request->input('content');
        $activity->serial = $request->serial;


        if(!$request->hasFile('icon')) {
            return redirect()->route('admin.activities.index')->with('error', 'Something went wrong.');
        }
        if(!$request->hasFile('image')) {
            return redirect()->route('admin.activities.index')->with('error', 'Something went wrong.');
        }

        // $activity->icon = $request->file('icon')->store('uploads/activity', 'public');
        $activity->icon = supaUploader($request->file('icon'), 'uploads/activity');

        // $activity->image = $request->file('image')->store('uploads/activity', 'public');
        $activity->image = supaUploader($request->file('image'), 'uploads/activity');

        $activity->save(); 
        return redirect()->route('admin.activities.index')->with('success', 'Project created successfully.');


    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        $project = Activity::find($activity->id);
        return view('pages.activity.form', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'image|mimes:jpeg,jpg,gif,png,svg|max:9048',
            'icon' => 'image|mimes:png,,svg|max:9048',
            'content' => 'required',
            'serial' => 'required|integer',
        ]);



        $project = Activity::find($activity->id);
        $project->title = $request->title;
        $project->short_text = $request->short_text;
        $project->content = $request->input('content');
        $project->serial = $request->serial;
        $project->status = $request->status;

        if($request->hasFile('image')) {
            $project->image = supaUpdater($project->image,$request->file('image'), 'uploads/activity/thumbnail');
        }

        if($request->hasFile('icon')) {
            $project->icon = supaUpdater($project->image,$request->file('icon'), 'uploads/activity/icon');;
        }
        $project->save();
        return redirect()->route('admin.activities.index')->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        $project = Activity::findOrFail($activity->id);
        supaDeleter($project->image);
        $project->delete();
        return redirect()->route('admin.activities.index')->with('success', 'Project deleted successfully.');
    }

    public function status($id){
        $project = Activity::find($id);
        $project->status = !$project->status;
        $project->save();
        return redirect()->route('admin.activities.index')->with('success', 'Status updated successfully.');
    }
}
