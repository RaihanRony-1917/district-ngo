<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;
use App\Models\NotablePeople;
use App\Models\HistoricalPlace;

class RegionController extends Controller
{
    //
    public function index()
    {

        $edu = Education::firstOrNew();

        $historicals = HistoricalPlace::orderBy('serial')->paginate(5, ['*'], 'places_page');
        $notables = NotablePeople::orderBy('serial')->paginate(5, ['*'], 'people_page');
        return view('pages.region.index', compact('edu', 'historicals', 'notables'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'school' => 'required|integer',
            'college' => 'required|integer',
            'madrasha' => 'required|integer',
            'pass_rate' => 'required|numeric'
        ]);

        Education::whereId(1)->update([
            'school' => $request->school,
            'college' => $request->college,
            'madrasha' => $request->madrasha,
            'pass_rate' => $request->pass_rate
        ]);

        return redirect()->route('admin.dagan.index')->with('success', 'Education updated successfully.');
    }

    public function editPlace($id){
        $item = HistoricalPlace::findOrFail($id);
        return view('pages.region.add-place', compact('item'));
    }
}
