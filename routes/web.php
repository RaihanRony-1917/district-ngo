<?php

use App\Models\Mission;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\VisionController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\MemberRequestController;
use App\Http\Controllers\NotablePeopleController;
use App\Http\Controllers\HistoricalPlaceController;
use App\Http\Controllers\ProjectCategoryController;
use App\Http\Services\ImgBBService;
use App\Http\Controllers\SupabaseTestController;

Route::get('/login', [AuthController::class, 'tryLogin'])->name('trylogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Route::get('/maker', [AuthController::class, 'register']);

Route::get('/', [SlideController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/supabase-test', function () {
    $disk = Storage::disk('supabase');

    // Make a tiny test file
    $path = 'test-uploads/hello-' . time() . '.txt';
    $disk->put($path, 'Hello from Laravel + Supabase S3!');

    return [
        'path' => $path,
        'url'  => $disk->url($path), // might be null if your disk isn’t public
    ];
});
Route::middleware(['auth', 'auth.session'])->prefix('/admin')->name('admin.')->group( function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/', [SlideController::class, 'index'])->name('dashboard');
    Route::resource('slides', SlideController::class)->except(['index']);
    Route::patch('slides/status/{id}', [SlideController::class, 'status'])->name('slides.toggle');

    Route::resource('projects', ProjectController::class);
    Route::patch('projects/status/{id}', [ProjectController::class, 'status'])->name('projects.toggle');

    Route::resource('project-categories', ProjectCategoryController::class)->except(['index', 'show']);
    Route::patch('project-categories/status/{id}', [ProjectCategoryController::class, 'status'])->name('project-categories.toggle');

    Route::resource('members', MemberController::class)->except(['show']);
    Route::patch('members/status/{id}', [MemberController::class, 'status'])->name('members.toggle');

    Route::resource('committee', CommitteeController::class)->except(['index','show']);
    Route::patch('committee/status/{id}', [CommitteeController::class, 'status'])->name('committee.toggle');

    Route::resource('activities', ActivityController::class)->except(['show']);
    Route::patch('activities/status/{id}', [ActivityController::class, 'status'])->name('activities.toggle');

    Route::resource('gallery', GalleryController::class)->except(['show', 'edit', 'update']);

    Route::resource('requests', MemberRequestController::class);
    Route::patch('requests/approve/{id}', [MemberRequestController::class, 'approve'])->name('requests.approve');
    Route::get('requests/add/{id}', [MemberRequestController::class, 'add'])->name('requests.add');
    Route::patch('requests/reject/{id}', [MemberRequestController::class, 'reject'])->name('requests.reject');

    Route::get('/admin/requests/{id}/file/view/{type}', [MemberRequestController::class, 'viewFile'])->name('requests.file.view');
    Route::get('/admin/requests/{id}/file/download/{type}', [MemberRequestController::class, 'downloadFile'])->name('requests.file.download');

        Route::prefix('about')->as('about.')->group(function () {

            Route::get('/', [MissionController::class, 'index'])->name('mission.index');
            Route::post('/mission', [MissionController::class, 'store'])->name('mission.store');
            Route::post('/lang-mission', [MissionController::class, 'mission'])->name('lang.mission');
            Route::post('/mission-img', [AboutController::class, 'mission'])->name('mission.img.store');


            Route::get('/vision', [VisionController::class, 'index'])->name('vision');
            Route::post('/vision', [VisionController::class, 'store'])->name('vision.store');
            Route::post('/lang-vision', [VisionController::class, 'vision'])->name('lang.vision');
            Route::post('/vision-img', [AboutController::class, 'vision'])->name('vision.img.store');


            Route::get('/quote', [QuoteController::class, 'preview'])->name('quote');
            Route::post('/quote', [QuoteController::class, 'store'])->name('quote.store');
            Route::post('/person-quote', [QuoteController::class, 'person'])->name('person.quote');
            Route::post('/person-img', [AboutController::class, 'person'])->name('img.quote');
            Route::post('/person-img-upload', [AboutController::class, 'quote'])->name('img.quote.store');
        });


        Route::resource('gallery', GalleryController::class)->except(['show']);
        Route::resource('albums', AlbumController::class)->except(['index', 'show']);
        Route::post('/album/status/{id}', [AlbumController::class, 'status'])->name('albums.toggle');

        Route::resource('blogs', BlogController::class)->except(['show']);
        Route::post('blogs', [BlogController::class, 'store'])->name('blogs.store');
        Route::patch('blogs/status/{id}', [BlogController::class, 'status'])->name('blogs.toggle');


        Route::prefix('dagan')->as('dagan.')->group(function () {
            Route::get('/', [RegionController::class, 'index'])->name('index');
            Route::post('/store', [RegionController::class, 'store'])->name('store');

            Route::get('/edit/place/{id}', [RegionController::class, 'editPlace'])->name('edit.place');


            Route::resource('places', HistoricalPlaceController::class)->except(['index','show']);
            Route::resource('people', NotablePeopleController::class)->except(['index','show']);


            Route::post('places/status/{id}',[ HistoricalPlaceController::class, 'status'])->name('places.toggle');
            Route::post('people/status/{id}',[ NotablePeopleController::class, 'status'])->name('people.toggle');

        });


        route::get('settings', [SettingController::class, 'index'])->name('settings');
        route::post('settings', [SettingController::class, 'update'])->name('settings.update');
});
