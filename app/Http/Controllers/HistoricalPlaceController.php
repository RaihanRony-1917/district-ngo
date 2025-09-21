<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\HistoricalPlace;
use Illuminate\Support\Facades\Storage;

class HistoricalPlaceController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.region.add-place');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'short_text' => 'required',
            'serial' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:9048',
        ]);

        $place = new HistoricalPlace();
        $place->name = $request->name;
        $place->short_text = $request->short_text;
        $place->serial = $request->serial;
        $place->lang_id = Language::where('code', 'bn')->first()->id;
        if($request->hasFile('image')){
            $place->image = supaUploader($request->file('image'), 'uploads/historical_places');
            $place->save();
        }
        return redirect()->route('admin.dagan.index')->with('success', 'Place added successfully');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HistoricalPlace $historicalPlace)
    {
        dd($historicalPlace->id);
        $item = HistoricalPlace::find($historicalPlace->id);
        return view('pages.region.add-place', compact('item'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HistoricalPlace $place)
    {


        $request->validate([
            'name' => 'required',
            'short_text' => 'required',
            'serial' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:9048',
        ]);

        $place = HistoricalPlace::findOrFail($place->id);
        $place->name = $request->name;
        $place->short_text = $request->short_text;
        $place->serial = $request->serial;
        if($request->hasFile('image')){
            $path = supaUpdater($place->image,$request->file('image'), 'uploads/historical_places');
            $place->image = $path;
        }
        $place->save();
        return redirect()->route('admin.dagan.index')->with('success', 'Place updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HistoricalPlace $place)
    {
        $place = HistoricalPlace::findOrFail($place->id);
        supaDeleter($place->image);
        $place->delete();
        return redirect()->route('admin.dagan.index')->with('success', 'Place deleted successfully');
    }

    public function status($id){
        $place = HistoricalPlace::findOrFail($id);
        $place->status = !$place->status;
        $place->save();

        return redirect()->route('admin.dagan.index')->with('success', 'Status Changed successfully');

    }
}
