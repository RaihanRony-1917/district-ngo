<?php

use App\Http\Services\SupaGPTService;
use Illuminate\Contracts\Cache\Store;
use Supabase\Storage\StorageClient;
use Supabase\Storage\StorageFile;
use Illuminate\Support\Facades\Storage;

    if(!function_exists('howLongAgo')) {
        function howLongAgo($timestamp) {
            return Carbon\Carbon::parse($timestamp)->diffForHumans();
        }
    }


   
    if(!function_exists('supaUploader')) {
        function supaUploader($file, $path){
            if(config('app.supa_on')) 
                return app(SupaGPTService::class)->upload($file, $path);
            return $file->store($path, 'public');
        }
    }

    if(!function_exists('supaUpdater')) {
        function supaUpdater(string $old , $file, string $path ){
           if($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            else if($old && config('app.supa_on')) {
                app(SupaGPTService::class)->update($file, $path, $old);
            }
            return supaUploader($file, $path);
        }    
    }

    if(!function_exists('supaUrl')) {
        function supaUrl($path, $disk = 'public') {
            if(config('app.supa_on')) {
                return app(SupaGPTService::class)->url($path);
            }
            return Storage::disk($disk)->url($path);
        }
    }

    if(!function_exists('supaDeleter')) {
        function supaDeleter($path){
            if($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            else if($path && config('app.supa_on')) {
                app(SupaGPTService::class)->delete($path);
            }
        }
    }