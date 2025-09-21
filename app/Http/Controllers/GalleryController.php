<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gallery = Gallery::all();
        $albums = Album::all();
        return view('pages.gallery.index', compact('gallery','albums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $albums = Album::all();
        return view('pages.gallery.form', compact('albums'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:9048',
            'name' => 'required',
            'serial' => 'required|integer',
            'album_id' => 'required|integer|exists:albums,id',
        ]);

        $gallery = new Gallery();
        $gallery->name = $request->name;
        $gallery->serial = $request->serial;
        $gallery->album_id = $request->album_id;

        if($request->hasFile('image')){
            $gallery->image = supaUploader($request->file('image'), 'uploads/gallery');
            $gallery->save();
            return redirect()->route('admin.gallery.index')->with('success', 'Gallery created successfully.');
        }
        return redirect()->route('admin.gallery.index')->with('error', 'Something went wrong.');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        $gallery = Gallery::find($gallery->id);
        $albums = Album::all();
        return view('pages.gallery.form', compact('gallery', 'albums'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
           'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:9048',
           'name' => 'required',
           'serial' => 'required|integer',
           'album_id' => 'required|integer|exists:albums,id',
           'status' => 'required|integer',
        ]);

        $gallery = Gallery::findOrFail($gallery->id);
        if($request->hasFile('image')){
            $gallery->image = supaUpdater($gallery->image,$request->file('image'), 'uploads/gallery');
        }
        $gallery->name = $request->name;
        $gallery->serial = $request->serial;
        $gallery->album_id = $request->album_id;
        $gallery->status = $request->status;
        $gallery->save();
        return redirect()->route('admin.gallery.index')->with('success', 'Gallery updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        $gallery = Gallery::findOrFail($gallery->id);
        supaDeleter($gallery->image);
        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Gallery deleted successfully.');
    }
}
