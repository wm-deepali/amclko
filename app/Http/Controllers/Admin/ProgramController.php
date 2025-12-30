<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProgramController extends Controller
{
    /* ================= LIST ================= */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Program::latest();

            if ($request->status && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addColumn(
                    'checkbox',
                    fn($r) =>
                    '<input type="checkbox" class="row_check" value="' . $r->id . '">'
                )
                ->addColumn(
                    'thumbnail',
                    fn($r) =>
                    $r->thumbnail
                    ? '<img src="' . asset('storage/' .
                        $r->thumbnail) . '" height="60">'
                    : ''
                )
                ->addColumn(
                    'status',
                    fn($r) =>
                    $r->status === 'active'
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Blocked</span>'
                )
                ->addColumn(
                    'action',
                    fn($r) =>
                    '
                    <a href="' . route('manage-programs.edit', $r->id) . '" class="btn btn-sm btn-info">Edit</a>
                    <button class="btn btn-sm btn-danger delete" data-id="' . $r->id . '">Delete</button>
                    '
                )
                ->rawColumns(['checkbox', 'thumbnail', 'status', 'action'])
                ->make(true);
        }

        return view('admin.programs.index');
    }

    /* ================= CREATE ================= */
    public function create()
    {
        return view('admin.programs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'short_description' => 'required',
            'detail_content' => 'required',
            'thumbnail' => 'required|image|max:2048',
            'banner' => 'required|image|max:4096',
        ]);

        $data = $request->only([
            'title',
            'short_description',
            'detail_content',
        ]);

        $data['status'] = 'active';

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('programs/thumbnail', 'public');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')
                ->store('programs/banner', 'public');
        }

        Program::create($data);

        return response()->json(['success' => true]);
    }


    /* ================= EDIT ================= */
    public function edit($id)
    {
        $program = Program::findOrFail($id);
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'short_description' => 'required',
            'detail_content' => 'required',
            'status' => 'required|in:active,block',
            'thumbnail' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:4096',
        ]);

        $program->fill($request->only([
            'title',
            'short_description',
            'detail_content',
            'status'
        ]));

        if ($request->hasFile('thumbnail')) {
            Storage::disk('public')->delete($program->thumbnail);

            $program->thumbnail = $request->file('thumbnail')
                ->store('programs/thumbnail', 'public');
        }

        if ($request->hasFile('banner')) {
            Storage::disk('public')->delete($program->banner);

            $program->banner = $request->file('banner')
                ->store('programs/banner', 'public');
        }

        $program->save();

        return response()->json(['success' => true]);
    }


    /* ================= DELETE ================= */
    public function destroy($id)
    {
        $program = Program::findOrFail($id);

        Storage::disk('public')->delete([
            $program->thumbnail,
            str_replace('programs/', 'programs/thumb/', $program->thumbnail),
            $program->banner
        ]);

        $program->delete();

        return response()->json(['success' => true]);
    }

    /* ================= BULK ================= */
    public function bulk(Request $request)
    {
        if ($request->action === 'delete') {
            Program::whereIn('id', $request->ids)->delete();
        }

        if (in_array($request->action, ['active', 'block'])) {
            Program::whereIn('id', $request->ids)
                ->update(['status' => $request->action]);
        }

        return response()->json(['success' => true]);
    }

}
