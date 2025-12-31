<?php

namespace App\Http\Controllers;

use App\Models\AnnualReport;
use App\Models\Application;
use App\Models\Blog;
use App\Models\Career;
use App\Models\Chairman;
use App\Models\Contact;
use App\Models\Course;
use App\Models\Enquiry;
use App\Models\Faq;
use App\Models\GalleryCategory;
use App\Models\Mission;
use App\Models\Program;
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
use Illuminate\Support\Facades\Http;


class FrontController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status', 'active')->latest()->limit(10)->get();
        $backgrounds = Background::where('status', 'active')->latest()->limit(10)->get();
        $abouts = About::where('status', 'active')->latest()->limit(10)->get();
        $galleries = Gallery::where('status', 'active')->latest()->limit(30)->get();
        $programs = Program::where('status', 'active')
            ->latest()
            ->limit(6)   // 👈 only few on homepage
            ->get();

        return view('front.index', [
            'sliders' => $sliders,
            'backgrounds' => $backgrounds,
            'abouts' => $abouts,
            'galleries' => $galleries,
            'programs' => $programs,
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

    public function career()
    {
        return view('front.career');
    }

    public function storeCareer(Request $request)
    {
        // ✅ Validate reCAPTCHA
        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]
        )->json();

        if (!($response['success'] ?? false)) {
            return back()
                ->withInput()
                ->with('error', 'Please verify that you are not a robot.');
        }

        // ✅ Form validation
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'post' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'file' => 'required|mimes:doc,docx,pdf|max:2048',
            'address' => 'nullable|string',
        ]);

        // ✅ Store resume
        $resumePath = $request->file('file')->store('careers', 'public');

        // ✅ Save to database
        Career::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'post_applied' => $request->post,
            'qualification' => $request->qualification,
            'message' => $request->address,
            'resume' => $resumePath,
        ]);

        return back()->with('success', 'Application submitted successfully');
    }

    public function program()
    {
        $programs = Program::where('status', 'active')
            ->latest()
            ->get();

        return view('front.program', compact('programs'));
    }

    public function showProgram(Program $program)
    {
        abort_if($program->status !== 'active', 404);

        $otherPrograms = Program::where('status', 'active')
            ->where('id', '!=', $program->id)
            ->latest()
            ->get();

        $galleryCategories = $program->galleryCategories()
            ->where('status', 'active')
            ->where('include_in_programmes', true)
            ->with([
                'galleries' => function ($q) {
                    $q->where('status', 'active');
                }
            ])
            ->get();

        return view('front.program-detail', compact(
            'program',
            'otherPrograms',
            'galleryCategories'
        ));
    }

    public function annualReport()
    {
        $reports = AnnualReport::where('status', 'active')
            ->latest()
            ->get();

        return view('front.annual-report', compact('reports'));
    }

    public function gallery()
    {
        $categories = GalleryCategory::where('status', 'active')
            ->with([
                'galleries' => function ($q) {
                    $q->where('status', 'active');
                }
            ])
            ->get();

        return view('front.photo-gallery', compact('categories'));
    }

    public function background()
    {
        $backgrounds = Background::where('status', 'active')
            ->latest()
            ->get();

        return view('front.background', compact('backgrounds'));
    }

    public function blogIndex()
    {
        $blogs = Blog::where('status', 'active')
            ->latest()
            ->paginate(9);

        return view('front.blogs', compact('blogs'));
    }

    public function blogDetail($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $latestBlogs = Blog::where('status', 'active')
            ->where('id', '!=', $blog->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('front.blogs-detail', compact('blog', 'latestBlogs'));
    }

    public function faqIndex()
    {
        $faqs = Faq::where('status', 'active')
            ->orderBy('id', 'asc')
            ->get();

        return view('front.faqs', compact('faqs'));
    }

    public function storeEnquiry(Request $request)
    {
        // ✅ Validate reCAPTCHA
        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]
        )->json();

        if (!($response['success'] ?? false)) {
            return back()
                ->withInput()
                ->with('error', 'Please verify that you are not a robot.');
        }

        $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'country_code' => 'required|string|max:5',
            'mobile' => 'required|string|min:7|max:20',
            'location' => 'required|string|max:100',
            'details' => 'required|string|max:500',
        ]);

        Enquiry::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'country_code' => $request->country_code,
            'mobile' => $request->mobile,
            'location' => $request->location,
            'details' => $request->details,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Thank you! Your enquiry has been submitted successfully.');
    }

}

