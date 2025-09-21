<?php

namespace App\Http\Controllers\Api;

use App\Models\Vision;
use App\Models\Mission;
use App\Models\Setting;
use App\Models\Education;
use App\Models\ExtraSetting;
use Illuminate\Http\Request;
use App\Models\NotablePeople;
use App\Models\HistoricalPlace;
use App\Http\Controllers\Controller;

class DaganController extends Controller
{
    public function index(){
        // return 'dagan bhuiyan';
        $data = [
            'mission' => Mission::find(1),
            'vision' => Vision::find(1),
            "edu" => Education::find(1),
            "historical_places" => HistoricalPlace::where('status', 1)->orderBy('serial', 'asc')->get(),
            "notable_people" => NotablePeople::where('status', 1)->orderBy('serial', 'asc')->get(),
           
        ];


        $allModels = collect();
        $allModels->push($data['mission'], $data['vision'], $data['edu']);
        $allModels = $allModels->merge($data['historical_places'])
                            ->merge($data['notable_people']);

        $latestUpdate = $allModels->whereNotNull('updated_at')->max('updated_at');

        return [
          
            'mission' => Mission::find(1),
            'vision' => Vision::find(1),
            "edu" => Education::find(1),
            "historical_places" => HistoricalPlace::where('status', 1)->orderBy('serial', 'asc')->get(),
            "notable_people" => NotablePeople::where('status', 1)->orderBy('serial', 'asc')->get(),
            'latest_update' => $latestUpdate
        ];
    }
}
