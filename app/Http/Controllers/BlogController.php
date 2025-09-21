<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{

    public function index(){
        $blogs = Blog::latest()->paginate(10);
        return view('pages.blogs.index', compact('blogs'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.blogs.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'title' => 'required',
           'content' => 'required',
           'tags' => 'required',
           'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:9048',
           'serial' => 'required|integer'
        ]);

        $tagArray = collect(json_decode($request->tags))
            ->pluck('value')
            ->filter()
            ->toArray();

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->content = $request->input('content');
        $blog->serial = $request->serial;
        $blog->tags = $tagArray;


        if($request->hasFile('image')) {
            $blog->image = supaUploader($request->file('image'), 'uploads/blogs');;
            $blog->save();
            return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully.');
        }
        return redirect()->route('admin.blogs.index')->with('error', 'Something went wrong.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        //
        $blog = Blog::find($blog->id);
        return view('pages.blogs.form', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:9048',
            'serial' => 'required|integer',
            'tags' => 'required'

        ]);

        $tagArray = collect(json_decode($request->tags))
            ->pluck('value')
            ->filter()
            ->toArray();

        $blog = Blog::find($blog->id)->first();
        $blog->title = $request->title;
        $blog->content = $request->input('content');
        $blog->serial = $request->serial;
        $blog->tags = $tagArray;


        if($request->hasFile('image')) {
            $blog->image = supaUpdater($album->image,$request->file('image'), 'uploads/blogs');
        }
        $blog->save();
        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog = Blog::findOrFail($blog->id);
         supaDeleter($blog->image);
        $blog->delete();
        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully.');
    }

    public function status($id){
        $blog = Blog::find($id);
        $blog->status = !$blog->status;
        $blog->save();
        return redirect()->route('admin.blogs.index')->with('success', 'Status updated successfully.');
    }
}
