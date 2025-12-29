<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class GalleryController extends Controller
{
    /* ================= LIST ================= */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Gallery::latest();

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
                    '<a href="' . route('galleries.edit', $r->id) . '" class="btn btn-sm btn-info">Edit</a>
                     <button class="btn btn-sm btn-danger delete" data-id="' . $r->id . '">Delete</button>'
                )
                ->rawColumns(['checkbox', 'image', 'status', 'action'])
                ->make(true);
        }

        return view('admin.gallery.index');
    }

    /* ================= CREATE ================= */
    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);

        $imagePath = $this->saveImageWithThumb(
            $request->file('image'),
            'gallery',
            250,
            171
        );

        Gallery::create([
            'image' => $imagePath,
            'status' => 'active'
        ]);

        return response()->json(['success' => true]);
    }

    /* ================= EDIT ================= */
    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,block'
        ]);

        // update status (OLD PHP equivalent)
        $gallery->status = $request->status;

        if ($request->hasFile('image')) {

            // delete old image + thumb (same as unlink)
            Storage::disk('public')->delete([
                $gallery->image,
                str_replace('gallery/', 'gallery/thumb/', $gallery->image)
            ]);

            // save new image + thumb
            $gallery->image = $this->saveImageWithThumb(
                $request->file('image'),
                'gallery',
                250,
                171
            );
        }

        $gallery->save();

        return response()->json(['success' => true]);
    }


    /* ================= DELETE ================= */
    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')->delete([
            $gallery->image,
            str_replace('gallery/', 'gallery/thumb/', $gallery->image)
        ]);

        $gallery->delete();

        return response()->json(['success' => true]);
    }

    /* ================= BULK ================= */
    public function bulk(Request $request)
    {
        if ($request->action === 'delete') {
            Gallery::whereIn('id', $request->ids)->get()->each(function ($g) {
                Storage::disk('public')->delete([
                    $g->image,
                    str_replace('gallery/', 'gallery/thumb/', $g->image)
                ]);
                $g->delete();
            });
        }

        if (in_array($request->action, ['active', 'block'])) {
            Gallery::whereIn('id', $request->ids)
                ->update(['status' => $request->action]);
        }

        return response()->json(['success' => true]);
    }

    /* ================= IMAGE HANDLER ================= */
    private function saveImageWithThumb($file, $dir, $w, $h)
    {
        $ext = $file->getClientOriginalExtension();
        $name = 'gallery_' . time() . '.' . $ext;

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
