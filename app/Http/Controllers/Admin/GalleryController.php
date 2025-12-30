<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class GalleryController extends Controller
{
    /* ================= LIST ================= */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Gallery::with('category')->latest();

            if ($request->status && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addColumn('checkbox', fn ($r) =>
                    '<input type="checkbox" class="row_check" value="'.$r->id.'">'
                )
                ->addColumn('image', fn ($r) =>
                    '<img src="'.asset('storage/'.$r->image).'" height="60">'
                )
                ->addColumn('category', fn ($r) =>
                    $r->category
                        ? '<span class="badge bg-info">'.$r->category->title.'</span>'
                        : '<span class="badge bg-secondary">Uncategorized</span>'
                )
                ->addColumn('status', fn ($r) =>
                    $r->status === 'active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Blocked</span>'
                )
                ->addColumn('action', fn ($r) =>
                    '<a href="'.route('manage-galleries.edit',$r->id).'" class="btn btn-sm btn-info">Edit</a>
                     <button class="btn btn-sm btn-danger delete" data-id="'.$r->id.'">Delete</button>'
                )
                ->rawColumns(['checkbox','image','category','status','action'])
                ->make(true);
        }

        return view('admin.gallery.index');
    }

    /* ================= CREATE ================= */
    public function create()
    {
        $categories = GalleryCategory::where('status','active')->get();
        return view('admin.gallery.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'category_id' => 'required|exists:gallery_categories,id'
        ]);

        $imagePath = $this->saveImageWithThumb(
            $request->file('image'),
            'gallery',
            250,
            171
        );

        Gallery::create([
            'image' => $imagePath,
            'category_id' => $request->category_id,
            'status' => 'active'
        ]);

        return response()->json(['success' => true]);
    }

    /* ================= EDIT ================= */
    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        $categories = GalleryCategory::where('status','active')->get();

        return view('admin.gallery.edit', compact('gallery','categories'));
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,block',
            'category_id' => 'required|exists:gallery_categories,id'
        ]);

        $gallery->status = $request->status;
        $gallery->category_id = $request->category_id;

        if ($request->hasFile('image')) {

            Storage::disk('public')->delete([
                $gallery->image,
                str_replace('gallery/', 'gallery/thumb/', $gallery->image)
            ]);

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
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

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

        if (in_array($request->action, ['active','block'])) {
            Gallery::whereIn('id', $request->ids)
                ->update(['status' => $request->action]);
        }

        return response()->json(['success' => true]);
    }

    /* ================= IMAGE HANDLER ================= */
    private function saveImageWithThumb($file, $dir, $w, $h)
    {
        $name = 'gallery_'.time().'.'.$file->getClientOriginalExtension();

        $file->storeAs($dir, $name, 'public');

        $src   = imagecreatefromstring(file_get_contents($file));
        $thumb = imagecreatetruecolor($w, $h);

        imagecopyresampled(
            $thumb, $src,
            0,0,0,0,
            $w,$h,
            imagesx($src),
            imagesy($src)
        );

        Storage::disk('public')->makeDirectory($dir.'/thumb');

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
