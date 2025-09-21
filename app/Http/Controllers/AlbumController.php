<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.gallery.add-album');
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
        ]);

        $album = new Album();
        $album->name = $request->name;
        $album->serial = $request->serial;

        if($request->hasFile('image')) {
            $album->image = supaUploader($request->file('image'), 'uploads/albums');
            $album->save();
            return redirect()->route('admin.gallery.index')->with('success', 'Album created successfully.');
        }
        
        return redirect()->route('admin.gallery.index')->with('error', 'Error occurred.');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album)
    {
        $album = Album::find($album->id);
        return view('pages.gallery.add-album', compact('album'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Album $album)
    {
        $request->validate([
           'name' => 'required',
           'serial' => 'required|integer',
           'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:9048',
        ]);

        $album = Album::findOrFail($album->id);

        if($request->hasFile('image')){
            $album->image = supaUpdater($album->image,$request->file('image'), 'uploads/albums');
        }

        $album->name = $request->name;
        $album->serial = $request->serial;
        $album->save();

        return redirect()->route('admin.gallery.index')->with('success', 'Album updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album)
    {
        $album = Album::findOrFail($album->id);
        supaDeleter($album->image);
        $album->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Album deleted successfully.');
    }

    public function status(Request $request, $id){
        $album = Album::findOrFail($id);
        $album->status = !$album->status;
        $album->save();
        return redirect()->route('admin.gallery.index')->with('success', 'Album status updated successfully.');
    }

}
