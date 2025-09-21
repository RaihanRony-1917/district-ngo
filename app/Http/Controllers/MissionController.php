<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Mission;
use App\Models\Language;
use App\Models\Vision;
use Illuminate\Http\Request;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $langs = Language::all();
        $about = About::find(1);
        $ln = Language::where('code', 'bn')->first();
        $mission = Mission::where('lang_id', $ln->id)->first();
        $vision = Vision::where('lang_id', $ln->id)->first();
        return view('pages.about.index', compact('langs', 'about', 'mission', 'vision'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $lang = Language::where('code', 'bn')->first();
        $mission = Mission::where('lang_id', $lang->id)->first();

        if(!$mission){
            $mission = new Mission();
            $mission->lang_id = $lang->id;
        }

        
        if($request->hasFile('image')) {
            $about = About::findOrFail(1);
            $about->mission_img = supaUploader($request->file('image'),'uploads/mission');
            $about->save();
        }

        $mission->title = $request->title;
        $mission->content = $request->input('content');
        $mission->save();
        return redirect()->route('admin.about.mission.index')->with('success', 'Mission updated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mission $mission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mission $mission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mission $mission)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $mission->title = $request->title;
        $mission->content = $request->input('content');
        
        if($request->hasFile('image')){
            $about = About::findOrFail(1);
            $about->mission_img = supaUpdater($about->mission_img, $request->file('image'), 'uploads/mission');
        }
        $about->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mission $mission)
    {
        //
    }
}
