<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Member;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function person(Request $request)
    {
        //

        $person = Member::where('role', $request->person)->first();

        $quotes = Quote::where('person', $request->person)->first();
        return response()->json(['image'=>asset('storage/'.$person->image), 'person'=>$quotes]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string',
            'quote' => 'required|string',
        ]);
        $lang_id = Language::where('id', $request->lang_id)->first()->id;
        $quote = Quote::where('lang_id',$lang_id )
                ->where('person', $request->person_id)->first();
        if(!$quote){
            $quote = new Quote();
            $quote->lang_id = $lang_id;
            $quote->person = $request->person_id;
        }

        $quote->title = $request->title;
        $quote->quote = $request->quote;
        $quote->save();
        return redirect()->route('admin.about.mission.index')->with('success', 'Quote created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quote $quote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quote $quote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quote $quote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote)
    {
        //
    }
}
