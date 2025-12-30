<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    /* ================= LIST ================= */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Blog::latest();

            return DataTables::of($query)
                ->addColumn(
                    'thumbnail',
                    fn($r) =>
                    $r->thumbnail
                    ? '<img src="' . asset('storage/' . $r->thumbnail) . '" height="50">'
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
                    <a href="' . route('manage-blogs.edit', $r->id) . '" class="btn btn-sm btn-info">Edit</a>
                    <button class="btn btn-sm btn-danger delete" data-id="' . $r->id . '">Delete</button>
                    '
                )
                ->rawColumns(['thumbnail', 'status', 'action'])
                ->make(true);
        }

        return view('admin.blogs.index');
    }

    /* ================= CREATE ================= */
    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:4096',
            'content' => 'required'
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'status' => 'active'
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('blogs/thumb', 'public');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')
                ->store('blogs/banner', 'public');
        }

        Blog::create($data);

        return response()->json(['success' => true]);
    }

    /* ================= EDIT ================= */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:4096',
            'content' => 'required',
            'status' => 'required|in:active,block'
        ]);

        $blog->fill([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'status' => $request->status
        ]);

        if ($request->hasFile('thumbnail')) {

            // ✅ delete only if exists
            if ($blog->thumbnail && Storage::disk('public')->exists($blog->thumbnail)) {
                Storage::disk('public')->delete($blog->thumbnail);
            }

            $blog->thumbnail = $request->file('thumbnail')
                ->store('blogs/thumb', 'public');
        }

        if ($request->hasFile('banner')) {

            // ✅ delete only if exists
            if ($blog->banner && Storage::disk('public')->exists($blog->banner)) {
                Storage::disk('public')->delete($blog->banner);
            }

            $blog->banner = $request->file('banner')
                ->store('blogs/banner', 'public');
        }


        $blog->save();

        return response()->json(['success' => true]);
    }

    /* ================= DELETE ================= */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        Storage::disk('public')->delete([
            $blog->thumbnail,
            $blog->banner
        ]);

        $blog->delete();

        return response()->json(['success' => true]);
    }
}
