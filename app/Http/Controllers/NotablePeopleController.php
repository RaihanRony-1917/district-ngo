<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\NotablePeople;
use Illuminate\Support\Facades\Storage;

class NotablePeopleController extends Controller
{


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.region.add-people');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'serial' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:9048',
            'short_text' => 'required',
        ]);

        $people = new NotablePeople();
        $people->name = $request->name;
        $people->short_text = $request->short_text;
        $people->serial = $request->serial;
        $people->lang_id = Language::where('code', 'bn')->first()->id;

        if($request->hasFile('image')){
            $people->image = supaUploader($request->file('image'), 'uploads/notable_people');
            $people->save();
            return redirect()->route('admin.dagan.index')->with('success', 'People created successfully.');
        }
        return redirect()->route('admin.dagan.index')->with('error', 'Something went wrong.');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NotablePeople $person)
    {
        //
        $item = NotablePeople::find($person->id);
        return view('pages.region.add-people', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NotablePeople $person)
    {
        //
         $request->validate([
            'name' => 'required',
            'serial' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:9048',
            'short_text' => 'required',
        ]);

        $people = NotablePeople::findOrFail($person->id);
        if($request->hasFile('image')){
            $people->image = supaUpdater($people->image,$request->file('image'), 'uploads/notable_people');
        }

        $people->name = $request->name;
        $people->short_text = $request->short_text;
        $people->serial = $request->serial;
        $people->save();

         return redirect()->route('admin.dagan.index')->with('success', 'People updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NotablePeople $person)
    {
        $person = NotablePeople::findOrFail($person->id);
        supaDeleter($person->image);
        $person->delete();
        return redirect()->route('admin.dagan.index')->with('success', 'People deleted successfully.');
    }
    public function status($id){
        $item = NotablePeople::find($id);
        $item->status = !$item->status;
        $item->save();
        return redirect()->route('admin.dagan.index')->with('success', 'Status updated successfully.');
    }
}
