<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Career;
use App\Models\Chairman;
use App\Models\Contact;
use App\Models\Course;
use App\Models\Mission;
use App\Models\Recognization;
use App\Models\Secretary;
use App\Models\About;
use App\Models\Background;
use App\Models\Gallery;
use App\Models\SkillDev;
use App\Models\Slider;
use App\Models\Certificate;
use App\Models\UrduAcademy;
use App\Models\Video;
use Illuminate\Http\Request;


class FrontController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status', 'active')->latest()->limit(10)->get();
        $backgrounds = Background::where('status', 'active')->latest()->limit(10)->get();
        $abouts = About::where('status', 'active')->latest()->limit(10)->get();
        $galleries = Gallery::where('status', 'active')->latest()->limit(30)->get();

        return view('front.index', [
            'sliders' => $sliders,
            'backgrounds' => $backgrounds,
            'abouts' => $abouts,
            'galleries' => $galleries,
        ]);

    }
    public function chairmanMessage()
    {
        $chairmen = Chairman::where('status', 'active')
            ->latest()
            ->limit(10)
            ->get();

        return view('front.chairman-message', compact('chairmen'));
    }

    public function secretaryMessage()
    {
        $secratries = Secretary::where('status', 'active')
            ->latest()
            ->limit(10)
            ->get();

        return view('front.secretary-message', compact('secratries'));
    }

    public function aboutUs()
    {
        $abouts = About::where('status', 'active')
            ->latest()
            ->limit(10)
            ->get();

        return view('front.about-us', compact('abouts'));
    }

    public function visionIndex()
    {
        $missions = Mission::where('status', 'active')
            ->latest()
            ->limit(10)
            ->get();

        return view('front.vision-mission', compact('missions'));
    }

    public function viewCertificate()
    {
        $certificates = Certificate::where('status', 'active')
            ->latest()
            ->limit(10)
            ->get();

        return view('front.view-certificate', compact('certificates'));
    }

    public function applicationForm()
    {
        $applications = Application::where('status', 'active')
            ->latest()
            ->limit(10)
            ->get();

        return view('front.application-form', compact('applications'));
    }

    public function courses()
    {
        $courses = Course::where('status', 'active')
            ->latest()
            ->limit(10)
            ->get();

        return view('front.courses', compact('courses'));
    }



    public function govtRecognition()
    {
        $recognitionOne = Recognization::where('status', 'active')
            ->where('id', 1)
            ->first();

        $recognitionTwo = Recognization::where('status', 'active')
            ->where('id', 2)
            ->first();

        return view('front.govt-recognition', compact(
            'recognitionOne',
            'recognitionTwo'
        ));
    }



    public function skillDevelopment()
    {
        $skillOne = SkillDev::where('status', 'active')
            ->where('id', 1)
            ->first();

        $skillTwo = SkillDev::where('status', 'active')
            ->where('id', 2)
            ->first();

        return view('front.skill-development', compact(
            'skillOne',
            'skillTwo'
        ));
    }



    public function urduAcademy()
    {
        $urduOne = UrduAcademy::where('status', 'active')
            ->where('id', 1)
            ->first();

        $urduTwo = UrduAcademy::where('status', 'active')
            ->where('id', 2)
            ->first();

        return view('front.urdu-academy', compact(
            'urduOne',
            'urduTwo'
        ));
    }


    public function videoGallery()
    {
        $videos = Video::where('status', 'active')
            ->latest()
            ->limit(30)
            ->get();

        return view('front.video-gallery', compact('videos'));
    }


    public function contactUs()
    {
        $contacts = Contact::where('status', 'active')
            ->latest()
            ->limit(10)
            ->get();

        return view('front.contact-us', compact('contacts'));
    }


   public function storeCareer(Request $request)
    {
        // ✅ Captcha validation
        if (
            $request->captchaResult !=
            ($request->firstNumber + $request->secondNumber)
        ) {
            return back()
                ->withInput()
                ->with('error', 'Captcha incorrect');
        }

        // ✅ Form validation
        $request->validate([
            'name'          => 'required|string|max:255',
            'mobile'        => 'required|string|max:20',
            'email'         => 'nullable|email|max:255',
            'post'          => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'file'          => 'required|mimes:doc,docx,pdf|max:2048',
            'address'       => 'nullable|string',
        ]);

        // ✅ Store resume
        $resumePath = $request->file('file')->store('careers', 'public');

        // ✅ Save to database
        Career::create([
            'name'          => $request->name,
            'mobile'        => $request->mobile,
            'email'         => $request->email,
            'post_applied'  => $request->post,
            'qualification' => $request->qualification,
            'message'       => $request->address,
            'resume'        => $resumePath,
        ]);

        return back()->with('success', 'Application submitted successfully');
    }
}
