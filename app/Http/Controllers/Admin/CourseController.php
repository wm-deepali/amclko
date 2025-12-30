<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class CourseController extends Controller
{
    /* ===============================
     |  LIST
     =============================== */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Course::latest();

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
                    'image',
                    fn($r) =>
                    $r->image
                    ? '<img src="' . asset('storage/' . $r->image) . '" height="60">'
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
                    '<a href="' . route('manage-courses.edit', $r->id) . '" class="btn btn-sm btn-info">Edit</a>
                     <button class="btn btn-sm btn-danger delete" data-id="' . $r->id . '">Delete</button>'
                )
                ->rawColumns(['checkbox', 'image', 'status', 'action'])
                ->make(true);
        }

        return view('admin.courses.index');
    }

    /* ===============================
     |  CREATE
     =============================== */
    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'url' => 'nullable',
            'content' => 'nullable',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = [
            'title' => $request->title,
            'url' => $request->url,
            'content' => $request->content,
            'status' => 'active'
        ];

        if ($request->hasFile('image')) {
            $filename = $this->saveCourseImage($request->file('image'));
            $data['image'] = 'courses/' . $filename;
        }

        Course::create($data);

        return response()->json(['success' => true]);
    }

    /* ===============================
     |  EDIT
     =============================== */
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'url' => 'nullable',
            'content' => 'nullable',
            'status' => 'required|in:active,block',
            'image' => 'nullable|image|max:2048'
        ]);

        $course->title = $request->title;
        $course->url = $request->url;
        $course->content = $request->content;
        $course->status = $request->status; // ✅ OLD PHP MATCH

        if ($request->hasFile('image')) {

            // delete old original + thumb
            Storage::disk('public')->delete([
                $course->image,
                str_replace('courses/', 'courses/thumb/', $course->image)
            ]);

            $filename = $this->saveCourseImage($request->file('image'));
            $course->image = 'courses/' . $filename;
        }

        $course->save();

        return response()->json(['success' => true]);
    }


    /* ===============================
     |  DELETE
     =============================== */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        if ($course->image) {
            Storage::disk('public')->delete([
                $course->image,
                str_replace('courses/', 'courses/thumb/', $course->image)
            ]);
        }

        $course->delete();

        return response()->json(['success' => true]);
    }

    /* ===============================
     |  BULK ACTIONS
     =============================== */
    public function bulk(Request $request)
    {
        if ($request->action === 'delete') {
            Course::whereIn('id', $request->ids)->get()->each(function ($course) {
                Storage::disk('public')->delete([
                    $course->image,
                    str_replace('courses/', 'courses/thumb/', $course->image)
                ]);
                $course->delete();
            });
        } else {
            Course::whereIn('id', $request->ids)
                ->update(['status' => $request->action]);
        }

        return response()->json(['success' => true]);
    }

    /* ===============================
     |  IMAGE HANDLER (OLD PHP STYLE)
     |  Size: 140 × 154
     =============================== */
    private function saveCourseImage($file)
    {
        $ext = $file->getClientOriginalExtension();
        $name = 'courses_' . now()->format('YmdHis') . '.' . $ext;

        // save original
        $file->storeAs('courses', $name, 'public');

        // create thumb
        $src = imagecreatefromstring(file_get_contents($file));
        $thumb = imagecreatetruecolor(140, 154);

        imagecopyresampled(
            $thumb,
            $src,
            0,
            0,
            0,
            0,
            140,
            154,
            imagesx($src),
            imagesy($src)
        );

        Storage::disk('public')->makeDirectory('courses/thumb');

        imagejpeg(
            $thumb,
            storage_path("app/public/courses/thumb/{$name}"),
            90
        );

        imagedestroy($src);
        imagedestroy($thumb);

        return $name;
    }
}
