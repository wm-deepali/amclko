<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkillDev;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SkillDevController extends Controller
{
    /* ================= LIST ================= */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = SkillDev::latest();

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
                    '<a href="' . route('manage-skill-dev.edit', $r->id) . '" class="btn btn-sm btn-info">Edit</a>
                     <button class="btn btn-sm btn-danger delete" data-id="' . $r->id . '">Delete</button>'
                )
                ->rawColumns(['checkbox', 'image', 'status', 'action'])
                ->make(true);
        }

        return view('admin.skill-development.index');
    }

    /* ================= CREATE ================= */
    public function create()
    {
        return view('admin.skill-development.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'nullable',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'status' => 'active',
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $this->saveImage(
                $request->file('image'),
                'affiliation',
                360,
                290
            );
        }

        SkillDev::create($data);

        return response()->json(['success' => true]);
    }

    /* ================= EDIT ================= */
    public function edit($id)
    {
        $skill = SkillDev::find($id);
        return view('admin.skill-development.edit', compact('skill'));
    }

    public function update(Request $request, $id)
    {
        $skill = SkillDev::find($id);
        $request->validate([
            'title' => 'required',
            'content' => 'nullable',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,block'
        ]);

        $skill->title = $request->title;
        $skill->content = $request->content;
        $skill->status = $request->status;

        if ($request->hasFile('image')) {

            // delete old original + thumb (PHP unlink parity)
            if ($skill->image) {
                Storage::disk('public')->delete([
                    $skill->image,
                    str_replace('affiliation/', 'affiliation/thumb/', $skill->image)
                ]);
            }

            $skill->image = $this->saveImage(
                $request->file('image'),
                'affiliation',
                360,
                290
            );
        }

        $skill->save();

        return response()->json(['success' => true]);
    }

    /* ================= DELETE ================= */
    public function destroy($id)
    {
        $skill = SkillDev::find($id);
        if ($skill->image) {
            Storage::disk('public')->delete([
                $skill->image,
                str_replace('affiliation/', 'affiliation/thumb/', $skill->image)
            ]);
        }

        $skill->delete();

        return response()->json(['success' => true]);
    }

    /* ================= BULK ================= */
    public function bulk(Request $request)
    {
        if ($request->action === 'delete') {
            SkillDev::whereIn('id', $request->ids)->get()->each(function ($s) {
                Storage::disk('public')->delete([
                    $s->image,
                    str_replace('affiliation/', 'affiliation/thumb/', $s->image)
                ]);
                $s->delete();
            });
        } else {
            SkillDev::whereIn('id', $request->ids)
                ->update(['status' => $request->action]);
        }

        return response()->json(['success' => true]);
    }

    /* ================= IMAGE HELPER ================= */
    private function saveImage($file, $dir, $w, $h)
    {
        $ext = $file->getClientOriginalExtension();
        $name = 'affiliation_' . time() . '.' . $ext;

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

