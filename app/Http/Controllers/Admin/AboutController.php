<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class AboutController extends Controller
{
    /* ================= LIST ================= */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = About::latest();

            if ($request->status && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addColumn('checkbox', fn ($r) =>
                    '<input type="checkbox" class="row_check" value="'.$r->id.'">'
                )
                ->addColumn('image', function ($r) {
                    if (!$r->image) return '';

                    $thumb = str_replace(
                        'abouts/',
                        'abouts/thumb/',
                        $r->image
                    );

                    return '<img src="'.asset('storage/'.$thumb).'" height="60">';
                })
                ->addColumn('status', fn ($r) =>
                    $r->status === 'active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Blocked</span>'
                )
                ->addColumn('action', fn ($r) =>
                    '
                        <a href="'.route('abouts.edit',$r->id).'" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger delete" data-id="'.$r->id.'">Delete</button>
                    '
                )
                ->rawColumns(['checkbox','image','status','action'])
                ->make(true);
        }

        return view('admin.about.index');
    }

    /* ================= CREATE ================= */
    public function create()
    {
        return view('admin.about.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
            'image'   => 'nullable|image|max:2048'
        ]);

        $data = [
            'title'   => $request->title,
            'content' => $request->content,
            'status'  => 'active'
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $this->saveImage(
                $request->file('image'),
                'abouts',
                304,
                221
            );
        }

        About::create($data);

        return response()->json(['success' => true]);
    }

    /* ================= EDIT ================= */
    public function edit(About $about)
    {
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request, About $about)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
            'status'  => 'required|in:active,block',
            'image'   => 'nullable|image|max:2048'
        ]);

        $about->title   = $request->title;
        $about->content = $request->content;
        $about->status  = $request->status; // OLD PHP MATCH

        if ($request->hasFile('image')) {

            if ($about->image) {
                Storage::disk('public')->delete([
                    $about->image,
                    str_replace('abouts/', 'abouts/thumb/', $about->image)
                ]);
            }

            $about->image = $this->saveImage(
                $request->file('image'),
                'abouts',
                304,
                221
            );
        }

        $about->save();

        return response()->json(['success' => true]);
    }

    /* ================= DELETE ================= */
    public function destroy(About $about)
    {
        if ($about->image) {
            Storage::disk('public')->delete([
                $about->image,
                str_replace('abouts/', 'abouts/thumb/', $about->image)
            ]);
        }

        $about->delete();

        return response()->json(['success' => true]);
    }

    /* ================= BULK ================= */
    public function bulk(Request $request)
    {
        if ($request->action === 'delete') {
            About::whereIn('id', $request->ids)->get()->each(function ($a) {
                if ($a->image) {
                    Storage::disk('public')->delete([
                        $a->image,
                        str_replace('abouts/', 'abouts/thumb/', $a->image)
                    ]);
                }
                $a->delete();
            });
        }

        if (in_array($request->action, ['active','block'])) {
            About::whereIn('id', $request->ids)
                ->update(['status' => $request->action]);
        }

        return response()->json(['success' => true]);
    }

    /* ================= IMAGE HANDLER (SAME AS SLIDER) ================= */
    private function saveImage($file, $dir, $w, $h)
    {
        $ext  = $file->getClientOriginalExtension();
        $name = 'about_' . time() . '.' . $ext;

        // SAVE ORIGINAL
        $file->storeAs($dir, $name, 'public');

        // CREATE THUMB (OLD PHP STYLE)
        $src   = imagecreatefromstring(file_get_contents($file));
        $thumb = imagecreatetruecolor($w, $h);

        imagecopyresampled(
            $thumb,
            $src,
            0, 0, 0, 0,
            $w, $h,
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
