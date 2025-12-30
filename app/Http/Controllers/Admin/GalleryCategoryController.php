<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use App\Models\Program;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GalleryCategoryController extends Controller
{
    /* ================= LIST ================= */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(GalleryCategory::latest())
                ->addColumn(
                    'include',
                    fn($r) =>
                    $r->include_in_programmes
                    ? '<span class="badge bg-info">Yes</span>'
                    : '<span class="badge bg-secondary">No</span>'
                )
                ->addColumn(
                    'action',
                    fn($r) =>
                    '
                    <a href="' . route('manage-gallery-categories.edit', $r->id) . '" class="btn btn-sm btn-info">Edit</a>
                    <button class="btn btn-sm btn-danger delete" data-id="' . $r->id . '">Delete</button>
                    '
                )
                ->rawColumns(['include', 'action'])
                ->make(true);
        }

        return view('admin.gallery-categories.index');
    }

    /* ================= CREATE ================= */
    public function create()
    {
        $programs = Program::where('status', 'active')->get();
        return view('admin.gallery-categories.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'include_in_programmes' => 'required|boolean',
            'program_ids' => 'nullable|array',
            'status' => 'required|in:active,block'
        ]);

        $category = GalleryCategory::create(
            $request->only(['title', 'include_in_programmes', 'status'])
        );

        if ($request->include_in_programmes) {
            $category->programmes()
                ->sync($request->program_ids ?? []);
        }

        return response()->json(['success' => true]);
    }

    /* ================= EDIT ================= */
    public function edit($id)
    {
        $category = GalleryCategory::with('programmes')->findOrFail($id);
        $programs = Program::where('status', 'active')->get();

        return view(
            'admin.gallery-categories.edit',
            compact('category', 'programs')
        );
    }

    public function update(Request $request, $id)
    {
        $category = GalleryCategory::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'include_in_programmes' => 'required|boolean',
            'program_ids' => 'nullable|array',
            'status' => 'required|in:active,block'
        ]);

        $category->update(
            $request->only(['title', 'include_in_programmes', 'status'])
        );

        if ($request->include_in_programmes) {
            $category->programmes()
                ->sync($request->program_ids ?? []);
        } else {
            $category->programmes()->detach();
        }

        return response()->json(['success' => true]);
    }

    /* ================= DELETE ================= */
    public function destroy($id)
    {
        GalleryCategory::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
