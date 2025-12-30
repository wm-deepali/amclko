<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ApplicationController extends Controller
{
    /* ================= LIST ================= */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Application::latest();

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
                    '<img src="' . asset('storage/' . $r->image) . '" height="60">'
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
                    '<a href="' . route('manage-applications.edit', $r->id) . '" class="btn btn-sm btn-info">Edit</a>
                     <button class="btn btn-sm btn-danger delete" data-id="' . $r->id . '">Delete</button>'
                )
                ->rawColumns(['checkbox', 'image', 'status', 'action'])
                ->make(true);
        }

        return view('admin.applications.index');
    }

    /* ================= CREATE ================= */
    public function create()
    {
        return view('admin.applications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|max:4096'
        ]);

        $data = $request->only('title');
        $data['status'] = 'active';

        if ($request->hasFile('image')) {
            $data['image'] = $this->saveImage(
                $request->file('image'),
                'applications',
                900,
                1080
            );
        }

        Application::create($data);

        return response()->json(['success' => true]);
    }

    /* ================= EDIT ================= */
    public function edit($id)
    {
        $application = Application::findOrFail($id);
        return view('admin.applications.edit', compact('application'));
    }

    public function update(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'status' => 'required|in:active,block',
            'image' => 'nullable|image|max:4096'
        ]);

        $application->fill($request->only('title', 'status'));

        if ($request->hasFile('image')) {
            if ($application->image) {
                Storage::disk('public')->delete([
                    $application->image,
                    str_replace('applications/', 'applications/thumb/', $application->image)
                ]);
            }

            $application->image = $this->saveImage(
                $request->file('image'),
                'applications',
                900,
                1080
            );
        }

        $application->save();

        return response()->json(['success' => true]);
    }

    /* ================= DELETE ================= */
    public function destroy($id)
    {
        $application = Application::findOrFail($id);
        if ($application->image) {
            Storage::disk('public')->delete([
                $application->image,
                str_replace('applications/', 'applications/thumb/', $application->image)
            ]);
        }

        $application->delete();

        return response()->json(['success' => true]);
    }

    /* ================= BULK ================= */
    public function bulk(Request $request)
    {
        if ($request->action === 'delete') {
            Application::whereIn('id', $request->ids)->get()->each(function ($a) {
                if ($a->image) {
                    Storage::disk('public')->delete([
                        $a->image,
                        str_replace('applications/', 'applications/thumb/', $a->image)
                    ]);
                }
                $a->delete();
            });
        }

        if (in_array($request->action, ['active', 'block'])) {
            Application::whereIn('id', $request->ids)
                ->update(['status' => $request->action]);
        }

        return response()->json(['success' => true]);
    }

    /* ================= IMAGE HANDLER ================= */
    private function saveImage($file, $dir, $w, $h)
    {
        $name = 'application_' . time() . '.' . $file->getClientOriginalExtension();

        // original
        $file->storeAs($dir, $name, 'public');

        // thumb
        $src = imagecreatefromstring(file_get_contents($file));
        $thumb = imagecreatetruecolor($w, $h);

        imagecopyresampled(
            $thumb,
            $src,
            0,
            0,
            0,
            0,
            $w,
            $h,
            imagesx($src),
            imagesy($src)
        );

        Storage::disk('public')->makeDirectory($dir . '/thumb');

        imagejpeg(
            $thumb,
            storage_path("app/public/{$dir}/thumb/{$name}"),
            90
        );

        imagedestroy($src);
        imagedestroy($thumb);

        return "{$dir}/{$name}";
    }
}
