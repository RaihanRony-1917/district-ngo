<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Blog;
use App\Models\User;
use App\Models\Slide;
use App\Models\Member;
use App\Models\Gallery;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Activity;
use App\Models\Donation;
use App\Models\Committee;
use App\Models\ExtraSetting;
use Illuminate\Http\Request;
use App\Models\MemberRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Notifications\RequestNotification;

class InfoController extends Controller
{

    public function index(){
        return [
            'slides' => Slide::where('status', 1)->get(),
            'featured_projects' => Project::where('is_featured', true)->get(),
            'blogs' => Blog::where('status', 1)->orderBy('updated_at', 'desc')->limit(3)->get(),
            'settings' => Setting::first(),
            'extra' => ExtraSetting::first()
        ];
    }
    public function slides(){
        return [
            'slides' => Slide::where('status', 1)->get(),
        ];
    }

    public function featuredProjects(){
        return [
            'featured_projects' => Project::where('is_featured', true)->get(),
        ];
    }
    public function allSettings(){
        return [
            'settings' => Setting::first(),
            'extra' => ExtraSetting::first()
        ];
    }
    public function activities(){
        return [
            'activities' => Activity::where('status', 1)->orderBy('serial', 'asc')->get(),
        ];
    }

    public function gallery(){
        return [
            'gallery' => Gallery::where('status', 1)->orderBy('serial', 'asc')->get(),
           
        ];
    }

    public function projects(){
        return [
            'projects' => Project::where('status', 1)->orderBy('serial', 'asc')->get(),
            
        ];
    }
    public function project($id){
        return [
            'project' => Project::find($id),
           
        ];
    }
    public function blog($id){
        return [
            'blog' => Blog::find($id),
        
        ];
    }
    public function activity($id){
        return [
            'activity' => Activity::find($id),
 
        ];
    }

    public function blogs(){
        return [
            'blogs' => Blog::where('status', 1)->orderBy('serial', 'asc')->get(),
          
        ];
    }
    public function members(){
        return [
            'committees' => Committee::all(),
            'members' => Member::where('status', 1)->orderBy('serial', 'asc')->get(),
          
        ];
    }

    public function donation(){
        return [
            
            'donation' => Donation::first()
        ];
    }

    public function memberRequest(Request $request){
       $validator = Validator::make($request->all(), [
            'name' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'phone' => 'required',
            'profession' => 'required',
            'address' => 'required',
            'bloodGroup' => 'required',
            // 'NID' => 'required',
            // 'photo' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

       try{
            $rq = new MemberRequest;
            $rq->name = $request->name;
            $rq->father_name = $request->father_name;
            $rq->mother_name = $request->mother_name;
            $rq->phone = $request->phone;
            $rq->profession = $request->profession;
            $rq->blood_grp = $request->bloodGroup;
            $rq->address = $request->address;

            if(!$request->file('NID')){
                return response()->json(['error' => 'NID is required']);
            }
            if(!$request->hasFile('photo')){
            return response()->json(['error' => 'photo is required']);
            }

            $path = $request->file('NID')->store('private/member_requests/NID', 'local');
            $rq->NID = $path;

            $path = $request->file('photo')->store('private/member_requests/photo', 'local');
            $rq->photo = $path;
            $rq->save();

            $user = User::first();
            $user->notify(new RequestNotification($rq));

            return response()->json($rq);

       }
       catch(Exception $e){
            return response()->json([
                'status'  => false,
                'message' => 'An error occurred while sending the message.',
                'error'   => $e->getMessage(),
            ], $e->getCode() > 0 ? $e->getCode() : 500);
       }

    }
}
