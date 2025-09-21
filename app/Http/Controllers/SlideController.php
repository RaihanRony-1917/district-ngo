<?php

namespace App\Http\Controllers;

use App\Http\Services\SupaGPTService;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // protected $supa;
    // public function __construct(SupaGPTService $supa){
    //     $this->supa = $supa;
    // }
    public function index()
    {
        $slides = Slide::all();
        return view('pages.slides.index', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.slides.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:9048',
            'caption' => 'required',
            'serial' => 'required|integer'
        ]);

        $slide = new Slide();
        $slide->caption = $request->caption;
        $slide->serial = $request->serial;

        if ($request->hasFile('image')) {
                $slide->image = supaUploader($request->file('image'), 'uploads/slides');
            $slide->save();
        }

        return redirect()->route('admin.dashboard')->with('success', 'Slide created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slide $slide)
    {
        $slide = Slide::find($slide->id);
        return view('pages.slides.form', compact('slide'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:9048',
            'caption' => 'required',
            'serial' => 'required|integer',
            'status' => 'required|integer',
        ]);

        $slide = Slide::findOrFail($id);
        if($request->hasFile('image')){            
            $slide->image = supaUpdater($slide->image, $request->file('image'), 'uploads/slides');
        }
        $slide->caption = $request->caption;
        $slide->serial = $request->serial;
        $slide->status = $request->status;
        $slide->save();

        return redirect()->route('admin.dashboard')->with('success', 'Slide updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $slide = Slide::findOrFail($id);
        supaDeleter($slide->image);
        $slide->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Slide deleted successfully.');
    }

    public function status($id){
        $slide = Slide::findOrFail($id);
        $slide->status = !$slide->status;
        $slide->save();
        return redirect()->route('admin.dashboard')->with('success', 'Slide status updated successfully.');
    }
}
