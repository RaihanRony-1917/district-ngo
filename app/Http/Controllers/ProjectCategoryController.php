<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectCategory;
use Illuminate\Support\Facades\Storage;

class ProjectCategoryController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.projects.add-category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'short_text' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:9048',
        ]);

        $projectCategory = new ProjectCategory();
        $projectCategory->name = $request->name;
        $projectCategory->short_text = $request->short_text;
        
        if($request->hasFile('image')) {
            $projectCategory->image = supaUploader($request->file('image'), 'uploads/project_categories');
            $projectCategory->save();
            return redirect()->route('admin.projects.index')->with('success', 'Project category created successfully.');
        }
        return redirect()->route('admin.projects.index')->with('error', 'Something went wrong.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectCategory $projectCategory)
    {
        $category = ProjectCategory::find($projectCategory->id);
        return view('pages.projects.add-category', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectCategory $projectCategory)
    {
        $request->validate([
            'name' => 'required',
            'short_text' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:9048',
            'status' => 'required'
        ]);

        $projectCategory = ProjectCategory::find($projectCategory->id);
        $projectCategory->name = $request->name;
        $projectCategory->short_text = $request->short_text;
        $projectCategory->status = $request->status;
        
        if($request->hasFile('image')) {
            $projectCategory->image = supaUpdater($projectCategory->image, $request->file('image'), 'uploads/project_categories');
        }
        $projectCategory->save();
        return redirect()->route('admin.projects.index')->with('success', 'Project category updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectCategory $projectCategory)
    {
        $projectCategory = ProjectCategory::find($projectCategory->id);
        
        supaDeleter($projectCategory->image);
        $projectCategory->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project category deleted successfully.');
    }

    public function status($id){
        $projectCategory = ProjectCategory::find($id);
        $projectCategory->status = !$projectCategory->status;
        $projectCategory->save();
        return redirect()->route('admin.projects.index')->with('success', 'Status updated successfully.');
    }
}
