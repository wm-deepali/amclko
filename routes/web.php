<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\BackgroundController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\RecognizationController;
use App\Http\Controllers\Admin\SkillDevController;
use App\Http\Controllers\Admin\UrduAcademyController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ChairmanController;
use App\Http\Controllers\Admin\SecretaryController;
use App\Http\Controllers\Admin\MissionController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('clear-cache', function () {
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    return '<h1>Clear Config cleared</h1>';
});

Route::get('/', function () {
    return view('front.index', []);
});

Route::get('/logout', [HomeController::class, 'logout'])->name('logouts');

/**
 * Auth Routes
 */
Auth::routes(['verify' => false]);
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    // admin panel routes
    Route::middleware(['auth', 'isAdmin'])->group(function () {
        Route::get('admin-login', [HomeController::class, 'index'])->name('dashboard');

        Route::resource('logos', LogoController::class);
        Route::post('logos-bulk', [LogoController::class, 'bulk'])->name('logos.bulk');

        Route::resource('sliders', SliderController::class);
        Route::post('sliders/bulk', [SliderController::class, 'bulk'])->name('sliders.bulk');

        Route::resource('backgrounds', BackgroundController::class);
        Route::post('backgrounds/bulk', [BackgroundController::class, 'bulk'])->name('backgrounds.bulk');

        Route::resource('courses', CourseController::class);
        Route::post('courses/bulk', [CourseController::class, 'bulk'])->name('courses.bulk');

        Route::resource('galleries', GalleryController::class);
        Route::post('galleries/bulk', [GalleryController::class, 'bulk'])->name('galleries.bulk');

        Route::resource('videos', VideoController::class);
        Route::post('videos/bulk', [VideoController::class, 'bulk'])->name('videos.bulk');

        Route::resource('recognizations', RecognizationController::class);
        Route::post('recognizations/bulk', [RecognizationController::class, 'bulk'])->name('recognizations.bulk');

        Route::resource('skill-dev', SkillDevController::class);
        Route::post('skill-dev/bulk', [SkillDevController::class, 'bulk'])->name('skill-dev.bulk');

        Route::resource('urdu-academy', UrduAcademyController::class);
        Route::post('urdu-academy/bulk', [UrduAcademyController::class, 'bulk'])->name('urdu-academy.bulk');

        Route::resource('abouts', AboutController::class);
        Route::post('abouts/bulk', [AboutController::class, 'bulk'])->name('abouts.bulk');

        Route::resource('chairmen', ChairmanController::class);
        Route::post('chairmen/bulk', [ChairmanController::class, 'bulk'])->name('chairmen.bulk');

        Route::resource('secretaries', SecretaryController::class);
        Route::post('secretaries/bulk', [SecretaryController::class, 'bulk'])->name('secretaries.bulk');

        Route::resource('missions', MissionController::class);
        Route::post('missions/bulk', [MissionController::class, 'bulk'])->name('missions.bulk');

        Route::resource('certificates', CertificateController::class);
        Route::post('certificates/bulk', [CertificateController::class, 'bulk'])->name('certificates.bulk');

        Route::resource('applications', ApplicationController::class);
        Route::post('applications/bulk', [ApplicationController::class, 'bulk'])->name('applications.bulk');

        Route::resource('contacts', ContactController::class);
        Route::post('contacts/bulk', [ContactController::class, 'bulk'])->name('contacts.bulk');

        Route::get('change-password', [ChangePasswordController::class, 'edit'])
            ->name('admin.password.edit');
        Route::post('change-password', [ChangePasswordController::class, 'update'])
            ->name('admin.password.update');

        //User Routes
        Route::get('/users/{user}/show', 'UsersController@show')->name('users.show')->middleware('custom.permission:manage_users');

    });

});
