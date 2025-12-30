<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Background;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class BackgroundController extends Controller
{
    /* ================= LIST ================= */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Background::latest();

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

                    // OLD PHP STYLE: use same name, different folder
                    $thumb = str_replace(
                        'backgrounds/',
                        'backgrounds/thumb/',
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
                        <a href="' . route('manage-backgrounds.edit', $r->id) . '" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger delete" data-id="' . $r->id . '">Delete</button>
                    ';
                })
                ->rawColumns(['checkbox', 'image', 'status', 'action'])
                ->make(true);
        }

        return view('admin.background.index');
    }

    /* ================= CREATE ================= */
    public function create()
    {
        return view('admin.background.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|max:2048',
            'content' => 'nullable'
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'status' => 'active'
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $this->saveImage(
                $request->file('image'),
                'backgrounds',
                258,
                242
            );
        }

        Background::create($data);

        return response()->json(['success' => true]);
    }

    /* ================= EDIT ================= */
    public function edit($id)
    {
        $background = Background::findOrFail($id);
        return view('admin.background.edit', compact('background'));
    }

    public function update(Request $request, $id)
    {
        $background = Background::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'status' => 'required|in:active,block',
            'image' => 'nullable|image|max:2048',
            'content' => 'nullable'
        ]);

        $background->title = $request->title;
        $background->content = $request->content;
        $background->status = $request->status; // ✅ ADDED

        if ($request->hasFile('image')) {

            // delete OLD original + thumb (same as old PHP unlink)
            if ($background->image) {
                Storage::disk('public')->delete([
                    $background->image,
                    str_replace(
                        'backgrounds/',
                        'backgrounds/thumb/',
                        $background->image
                    )
                ]);
            }

            $background->image = $this->saveImage(
                $request->file('image'),
                'backgrounds',
                258,
                242
            );
        }

        $background->save();

        return response()->json(['success' => true]);
    }


    /* ================= DELETE ================= */
    public function destroy($id)
    {
        $background = Background::findOrFail($id);
        if ($background->image) {
            Storage::disk('public')->delete([
                $background->image,
                str_replace(
                    'backgrounds/',
                    'backgrounds/thumb/',
                    $background->image
                )
            ]);
        }

        $background->delete();

        return response()->json(['success' => true]);
    }

    /* ================= BULK ================= */
    public function bulk(Request $request)
    {
        if ($request->action === 'delete') {
            Background::whereIn('id', $request->ids)->get()->each(function ($b) {
                if ($b->image) {
                    Storage::disk('public')->delete([
                        $b->image,
                        str_replace(
                            'backgrounds/',
                            'backgrounds/thumb/',
                            $b->image
                        )
                    ]);
                }
                $b->delete();
            });
        }

        if (in_array($request->action, ['active', 'block'])) {
            Background::whereIn('id', $request->ids)
                ->update(['status' => $request->action]);
        }

        return response()->json(['success' => true]);
    }

    /* ================= IMAGE HANDLER (OLD PHP STYLE) ================= */
    private function saveImage($file, $dir, $w, $h)
    {
        $ext = $file->getClientOriginalExtension();
        $name = 'bg_' . time() . '.' . $ext;

        // 1️⃣ Save ORIGINAL
        $file->storeAs($dir, $name, 'public');

        // 2️⃣ Create THUMB (same filename, different folder)
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

        // ONLY original path stored in DB
        return "{$dir}/{$name}";
    }
}
