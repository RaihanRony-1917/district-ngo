<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use Illuminate\Http\Request;

class CommitteeController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.members.add-committee');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'serial' => 'required|integer'
        ]);

        $committee = new Committee();
        $committee->name = $request->name;
        $committee->serial = $request->serial;
        $committee->save();

        return redirect()->route('admin.members.index')->with('success', 'Committee added successfully');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Committee $committee)
    {
        $committee = Committee::findOrFail($committee->id);
        return view('pages.members.add-committee', compact('committee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Committee $committee)
    {
        //
         $request->validate([
            'name' => 'required',
            'serial' => 'required|integer',
            'status' => 'required'
        ]);

        $committee = Committee::findOrFail($committee->id);
        $committee->name = $request->name;
        $committee->serial = $request->serial;
        $committee->status = $request->status;
        $committee->save();

        return redirect()->route('admin.members.index')->with('success', 'Committee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Committee $committee)
    {
        $committee = Committee::findOrFail($committee->id);
        $committee->delete();

        return redirect()->route('admin.members.index')->with('success', 'Committee deleted successfully');
    }

    public function status($id)
    {
        $committee = Committee::findOrFail($id);
        $committee->status = !$committee->status;
        $committee->save();
        return redirect()->route('admin.members.index')->with('success', 'Status updated successfully');
    }
}
