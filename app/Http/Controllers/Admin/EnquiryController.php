<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    /**
     * Display a listing of enquiries.
     */
    public function index()
    {
        $enquiries = Enquiry::latest()->paginate(10);

        return view('admin.enquiries.index', compact('enquiries'));
    }

    /**
     * Show a single enquiry (optional – can be extended later).
     */
    public function show($id)
    {
        $enquiry = Enquiry::findOrFail($id);

        return view('admin.enquiries.show', compact('enquiry'));
    }

    /**
     * Delete an enquiry.
     */
    public function destroy($id)
    {
        Enquiry::findOrFail($id)->delete();

        return back()->with('success', 'Enquiry deleted successfully.');
    }
}
