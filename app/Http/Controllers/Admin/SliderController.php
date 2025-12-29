<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends Controller
{
    /* ================= LIST ================= */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Slider::latest();

            if ($request->status && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addColumn('checkbox', function ($r) {
                    return '<input type="checkbox" class="row_check" value="' . $r->id . '">';
                })
                ->addColumn('image', function ($r) {
                    if (!$r->image)
                        return '';

                    // OLD PHP STYLE THUMB PATH
                    $thumb = str_replace(
                        'sliders/',
                        'sliders/thumb/',
                        $r->image
                    );

                    return '<img src="' . asset('storage/' . $thumb) . '" height="60">';
                })
                ->addColumn('status', function ($r) {
                    return $r->status === 'active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Blocked</span>';
                })
                ->addColumn('action', function ($r) {
                    return '
                        <a href="' . route('sliders.edit', $r->id) . '" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger delete" data-id="' . $r->id . '">Delete</button>
                    ';
                })
                ->rawColumns(['checkbox', 'image', 'status', 'action'])
                ->make(true);
        }

        return view('admin.slider.index');
    }

    /* ================= CREATE ================= */
    public function create()
    {
        return view('admin.slider.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|max:2048'
        ]);

        $data = [
            'title' => $request->title,
            'status' => 'active'
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $this->saveImage(
                $request->file('image'),
                'sliders',
                1358,
                574
            );
        }

        Slider::create($data);

        return response()->json(['success' => true]);
    }

    /* ================= EDIT ================= */
    public function edit(Slider $slider)
    {
        return view('admin.slider.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required|in:active,block',
            'image' => 'nullable|image|max:2048'
        ]);

        $slider->title = $request->title;
        $slider->status = $request->status; // ✅ OLD PHP MATCH

        if ($request->hasFile('image')) {

            // DELETE OLD ORIGINAL + THUMB (same as PHP unlink)
            if ($slider->image) {
                Storage::disk('public')->delete([
                    $slider->image,
                    str_replace('sliders/', 'sliders/thumb/', $slider->image)
                ]);
            }

            $slider->image = $this->saveImage(
                $request->file('image'),
                'sliders',
                1358,
                574
            );
        }

        $slider->save();

        return response()->json(['success' => true]);
    }


    /* ================= DELETE ================= */
    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            Storage::disk('public')->delete([
                $slider->image,
                str_replace(
                    'sliders/',
                    'sliders/thumb/',
                    $slider->image
                )
            ]);
        }

        $slider->delete();

        return response()->json(['success' => true]);
    }

    /* ================= BULK ================= */
    public function bulk(Request $request)
    {
        if ($request->action === 'delete') {
            Slider::whereIn('id', $request->ids)->get()->each(function ($s) {
                if ($s->image) {
                    Storage::disk('public')->delete([
                        $s->image,
                        str_replace(
                            'sliders/',
                            'sliders/thumb/',
                            $s->image
                        )
                    ]);
                }
                $s->delete();
            });
        }

        if (in_array($request->action, ['active', 'block'])) {
            Slider::whereIn('id', $request->ids)
                ->update(['status' => $request->action]);
        }

        return response()->json(['success' => true]);
    }

    /* ================= IMAGE HANDLER (OLD PHP MATCH) ================= */
    private function saveImage($file, $dir, $w, $h)
    {
        $ext = $file->getClientOriginalExtension();
        $name = 'slider_' . time() . '.' . $ext;

        // SAVE ORIGINAL
        $file->storeAs($dir, $name, 'public');

        // CREATE THUMB
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

        // ONLY ORIGINAL PATH STORED
        return "{$dir}/{$name}";
    }
}
