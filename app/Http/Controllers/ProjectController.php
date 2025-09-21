<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\ProjectCategory;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderBy('created_at', 'desc')->paginate(10, ['*'], 'projects_page');
        $projectCategories= ProjectCategory::orderBy('name')->paginate(10, ['*'], 'categories_page');

        return view('pages.projects.index', compact('projects', 'projectCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projectCategories = ProjectCategory::where('status', 1)->get();
        return view('pages.projects.add-project', compact('projectCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required|exists:project_categories,id',
            'short_text' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:9048',
            'content' => 'required',
            'tags' => 'required'
        ]);
        $tagArray = collect(json_decode($request->tags))
            ->pluck('value')
            ->filter()
            ->toArray();

        $project = new Project();
        $project->title = $request->title;
        $project->category_id = $request->category_id;
        $project->is_featured = $request->has('is_featured');
        $project->short_text = $request->short_text;
        $project->content = $request->input('content');
        $project->tags = $tagArray;

        if($request->hasFile('image')) {
            $project->image = supaUploader($request->file('image'), 'uploads/projects');
            $project->save();
            return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
        }
        return redirect()->route('admin.projects.index')->with('error', 'Something went wrong.');

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $project = Project::find($project->id);
        $projectCategories = ProjectCategory::where('status', 1)->get();
        return view('pages.projects.add-project', compact('project', 'projectCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required|exists:project_categories,id',
            'short_text' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:9048',
            'content' => 'required',
            'tags' => 'required',
            'serial' => 'required|integer',
            'status' => 'required'
        ]);

        $tagArray = collect(json_decode($request->tags))
            ->pluck('value')
            ->filter()
            ->toArray();

        $project = Project::find($project->id);
        $project->title = $request->title;
        $project->category_id = $request->category_id;
        $project->is_featured = $request->has('is_featured');
        $project->short_text = $request->short_text;
        $project->content = $request->input('content');
        $project->tags = $tagArray;
        $project->serial = $request->serial;
        $project->status = $request->status;
        
        if($request->hasFile('image')) {
            
            $project->image = supaUpdater($project->image, $request->file('image'), 'uploads/projects');
            $project->save();
            return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
        }
        $project->save();
        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project = Project::findOrFail($project->id);
        
        supaDeleter($project->image);
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }

    public function status($id){
        $project = Project::find($id);
        $project->status = !$project->status;
        $project->save();
        return redirect()->route('admin.projects.index')->with('success', 'Status updated successfully.');
    }
}
