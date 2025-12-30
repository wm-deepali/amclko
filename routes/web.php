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
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\AnnualReportController;
use App\Http\Controllers\Admin\GalleryCategoryController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\FaqController;
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
Route::get('/program', [FrontController::class, 'program'])->name('program');
Route::get('/program/{program}', [FrontController::class, 'showProgram'])->name('program.detail');
Route::get('/annual-report', [FrontController::class, 'annualReport'])->name('annual.report');
Route::get('/career', [FrontController::class, 'career'])->name('career');
Route::post('/career-submit', [FrontController::class, 'storeCareer'])->name('career.submit');
Route::get('/photo-gallery', [FrontController::class, 'gallery'])->name('photo.gallery');
Route::get('/background', [FrontController::class, 'background'])->name('background');

Route::get('/blogs', [FrontController::class,'blogIndex'])->name('blogs');
Route::get('/blog/{slug}', [FrontController::class,'blogDetail'])->name('blog.detail');

Route::get('/faqs', [FrontController::class,'faqIndex'])->name('faqs');


//course detail page
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



Route::get('/logout', [HomeController::class, 'logout'])->name('logouts');

/**
 * Auth Routes
 */
Auth::routes(['verify' => false]);
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    // admin panel routes
    Route::middleware(['auth', 'isAdmin'])->group(function () {
        Route::get('admin-login', [HomeController::class, 'index'])->name('dashboard');

        Route::resource('manage-logos', LogoController::class);
        Route::post('manage-logos/bulk', [LogoController::class, 'bulk'])->name('manage-logos.bulk');

        Route::resource('manage-sliders', SliderController::class);
        Route::post('manage-sliders/bulk', [SliderController::class, 'bulk'])->name('manage-sliders.bulk');

        Route::resource('manage-backgrounds', BackgroundController::class);
        Route::post('manage-backgrounds/bulk', [BackgroundController::class, 'bulk'])->name('manage-backgrounds.bulk');

        Route::resource('manage-courses', CourseController::class);
        Route::post('manage-courses/bulk', [CourseController::class, 'bulk'])->name('manage-courses.bulk');

        Route::resource('manage-programs', ProgramController::class)->names('manage-programs');
        Route::post('manage-programs/bulk', [ProgramController::class, 'bulk'])->name('manage-programs.bulk');

        Route::resource('manage-blogs', BlogController::class)->names('manage-blogs');
        Route::resource('manage-faqs', FaqController::class)->names('manage-faqs');

        Route::resource('manage-annual-reports', AnnualReportController::class)->names('manage-annual-reports');
        Route::post('manage-annual-reports/bulk', [AnnualReportController::class, 'bulk'])->name('manage-annual-reports.bulk');

        Route::resource('manage-galleries', GalleryController::class);
        Route::post('manage-galleries/bulk', [GalleryController::class, 'bulk'])->name('manage-galleries.bulk');

        Route::resource('manage-gallery-categories', GalleryCategoryController::class)->names('manage-gallery-categories');

        Route::resource('manage-videos', VideoController::class);
        Route::post('manage-videos/bulk', [VideoController::class, 'bulk'])->name('manage-videos.bulk');

        Route::resource('manage-recognizations', RecognizationController::class);
        Route::post('manage-recognizations/bulk', [RecognizationController::class, 'bulk'])->name('manage-recognizations.bulk');

        Route::resource('manage-skill-dev', SkillDevController::class);
        Route::post('manage-skill-dev/bulk', [SkillDevController::class, 'bulk'])->name('manage-skill-dev.bulk');

        Route::resource('manage-urdu-academy', UrduAcademyController::class);
        Route::post('manage-urdu-academy/bulk', [UrduAcademyController::class, 'bulk'])->name('manage-urdu-academy.bulk');

        Route::resource('manage-abouts', AboutController::class);
        Route::post('manage-abouts/bulk', [AboutController::class, 'bulk'])->name('manage-abouts.bulk');

        Route::resource('manage-chairmen', ChairmanController::class);
        Route::post('manage-chairmen/bulk', [ChairmanController::class, 'bulk'])->name('manage-chairmen.bulk');

        Route::resource('manage-secretaries', SecretaryController::class);
        Route::post('manage-secretaries/bulk', [SecretaryController::class, 'bulk'])->name('manage-secretaries.bulk');

        Route::resource('manage-missions', MissionController::class);
        Route::post('manage-missions/bulk', [MissionController::class, 'bulk'])->name('manage-missions.bulk');

        Route::resource('manage-certificates', CertificateController::class);
        Route::post('manage-certificates/bulk', [CertificateController::class, 'bulk'])->name('manage-certificates.bulk');

        Route::resource('manage-applications', ApplicationController::class);
        Route::post('manage-applications/bulk', [ApplicationController::class, 'bulk'])->name('manage-applications.bulk');

        Route::resource('manage-careers', CareerController::class)->only(['index', 'show', 'destroy'])->names('manage-careers');

        Route::resource('manage-contacts', ContactController::class);
        Route::post('manage-contacts/bulk', [ContactController::class, 'bulk'])->name('manage-contacts.bulk');

        Route::get('change-password', [ChangePasswordController::class, 'edit'])
            ->name('admin.password.edit');
        Route::post('change-password', [ChangePasswordController::class, 'update'])
            ->name('admin.password.update');

        //User Routes
        Route::get('/users/{user}/show', 'UsersController@show')->name('users.show')->middleware('custom.permission:manage_users');

    });

});
