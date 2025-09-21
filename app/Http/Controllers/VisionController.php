<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Vision;
use App\Models\Language;
use Illuminate\Http\Request;

class VisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $lang = Language::where('code', 'bn')->first();
        $vision = Vision::where('lang_id', $lang->id)->first();

        if(!$vision){
            $vision = new vision();
            $vision->lang_id = $lang->id;
        }

        if($request->hasFile('image')) {
            $about = About::findOrFail(1);
            $about->vision_img = supaUploader($request->file('image'),'uploads/vision');
            $about->save();
        }

        $vision->title = $request->title;
        $vision->content = $request->input('content');
        $vision->save();
        return redirect()->route('admin.about.mission.index')->with('success', 'Mission updated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vision $vision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vision $vision)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vision $vision)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $vision->title = $request->title;
        $vision->content = $request->input('content');
        
        if($request->hasFile('image')){
            $about = About::findOrFail(1);
            $about->vision_img = supaUpdater($about->mission_img, $request->file('image'), 'uploads/vision');
        }
        $about->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vision $vision)
    {
        //
    }
}
