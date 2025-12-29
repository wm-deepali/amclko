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

Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/chairman-message', [FrontController::class, 'chairmanMessage'])->name('chairman.message');
Route::get('/secretary-message', [FrontController::class, 'secretaryMessage'])->name('secretary.message');
Route::get('/about-us', [FrontController::class, 'aboutUs'])->name('about.us');
Route::get('/vision-mission', [FrontController::class, 'visionIndex'])->name('vision.mission');
Route::get('/view-certificate', [FrontController::class, 'viewCertificate'])->name('view.certificate');
Route::get('/application-form', [FrontController::class, 'applicationForm'])->name('application.form');
Route::get('/courses', [FrontController::class, 'courses'])->name('courses');
Route::get('/govt-recognition', [FrontController::class, 'govtRecognition'])->name('govt.recognition');
Route::get('/skill-development', [FrontController::class, 'skillDevelopment'])->name('skill.development');
Route::get('/urdu-academy', [FrontController::class, 'urduAcademy'])->name('urdu.academy');
Route::get('/video-gallery', [FrontController::class, 'videoGallery'])->name('video.gallery');
Route::get('/contact-us', [FrontController::class, 'contactUs'])->name('contact.us');

Route::get('/career', function () {
    return view('front.career');
});

Route::post('/career-submit', [FrontController::class, 'storeCareer'])
    ->name('career.submit');

Route::get('/photo-gallery', function () {
    return view('front.photo-gallery');
})->name('photo.gallery');

Route::get('/computer-course', function () {
    return view('front.computer-course');
})->name('computer.course');

Route::get('/arabic-course', function () {
    return view('front.arabic-course');
})->name('arabic.course');

Route::get('/fashion-course', function () {
    return view('front.fashion-course');
})->name('fashion.course');

Route::get('/urdu-course', function () {
    return view('front.urdu-course');
})->name('urdu.course');

Route::get('/program', function () {
    return view('front.program');
})->name('program');

Route::get('/annual-report', function () {
    return view('front.annual-report');
})->name('annual.report');

Route::get('/background', function () {
    return view('front.background');
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

        Route::resource('manage-courses', CourseController::class);
        Route::post('manage-courses/bulk', [CourseController::class, 'bulk'])->name('manage-courses.bulk');

        Route::resource('galleries', GalleryController::class);
        Route::post('galleries/bulk', [GalleryController::class, 'bulk'])->name('galleries.bulk');

        Route::resource('videos', VideoController::class);
        Route::post('videos/bulk', [VideoController::class, 'bulk'])->name('videos.bulk');

        Route::resource('recognizations', RecognizationController::class);
        Route::post('recognizations/bulk', [RecognizationController::class, 'bulk'])->name('recognizations.bulk');

        Route::resource('skill-dev', SkillDevController::class);
        Route::post('skill-dev/bulk', [SkillDevController::class, 'bulk'])->name('skill-dev.bulk');

        Route::resource('manage-urdu-academy', UrduAcademyController::class);
        Route::post('manage-urdu-academy/bulk', [UrduAcademyController::class, 'bulk'])->name('manage-urdu-academy.bulk');

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
