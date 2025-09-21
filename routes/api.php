<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InfoController;
use App\Http\Controllers\Api\DaganController;
use Illuminate\Console\View\Components\Info;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['prefix' => 'v1'], function () {
    Route::get('index/bn', [InfoController::class, 'index']);
    Route::get('slides/bn', [InfoController::class, 'slides']);
    Route::get('featured-projects/bn', [InfoController::class, 'featuredProjects']);
    Route::get('all-settings/bn', [InfoController::class, 'allSettings']);


    Route::get('about/bn', [DaganController::class, 'index']);
    Route::get('gallery/bn', [InfoController::class, 'gallery']);
    Route::get('projects/bn', [InfoController::class, 'projects']);
    Route::get('blogs/bn', [InfoController::class, 'blogs']);
    Route::get('members/bn', [InfoController::class, 'members']);
    Route::get('donation/bn', [InfoController::class, 'donation']);

    Route::get('activities/bn', [InfoController::class, 'activities']);

    Route::get('project/{id}/bn', [InfoController::class, 'project']);
    Route::get('blog/{id}/bn', [InfoController::class, 'blog']);
    Route::get('activity/{id}/bn', [InfoController::class, 'activity']);

    Route::post('request/bn', [InfoController::class, 'memberRequest']);

});
