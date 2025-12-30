<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    /* ================= LIST ================= */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Faq::latest();

            return DataTables::of($query)
                ->addColumn('status', fn($r) =>
                    $r->status === 'active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Blocked</span>'
                )
                ->addColumn('action', fn($r) => '
                    <a href="'.route('manage-faqs.edit',$r->id).'" class="btn btn-sm btn-info">Edit</a>
                    <button class="btn btn-sm btn-danger delete" data-id="'.$r->id.'">Delete</button>
                ')
                ->rawColumns(['status','action'])
                ->make(true);
        }

        return view('admin.faqs.index');
    }

    /* ================= CREATE ================= */
    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer'   => 'required',
            'status'   => 'required|in:active,block'
        ]);

        Faq::create($request->only('question','answer','status'));

        return response()->json(['success' => true]);
    }

    /* ================= EDIT ================= */
    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $request->validate([
            'question' => 'required|string|max:255',
            'answer'   => 'required',
            'status'   => 'required|in:active,block'
        ]);

        $faq->update($request->only('question','answer','status'));

        return response()->json(['success' => true]);
    }

    /* ================= DELETE ================= */
    public function destroy($id)
    {
        Faq::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
