<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recognization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class RecognizationController extends Controller
{
    /* ================= LIST ================= */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $q = Recognization::latest();

            if ($request->status && $request->status !== 'all') {
                $q->where('status', $request->status);
            }

            return DataTables::of($q)
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
                    '<a href="' . route('manage-recognizations.edit', $r->id) . '" class="btn btn-sm btn-info">Edit</a>
                     <button class="btn btn-sm btn-danger delete" data-id="' . $r->id . '">Delete</button>'
                )
                ->rawColumns(['checkbox', 'image', 'status', 'action'])
                ->make(true);
        }

        return view('admin.recognization.index');
    }

    /* ================= CREATE ================= */
    public function create()
    {
        return view('admin.recognization.create');
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
                'affiliation',
                360,
                290
            );
        }

        Recognization::create($data);

        return response()->json(['success' => true]);
    }

    /* ================= EDIT ================= */
    public function edit($id)
    {
        $recognization = Recognization::findOrFail($id);
        return view('admin.recognization.edit', compact('recognization'));
    }

    public function update(Request $request, $id)
    {
        $recognization = Recognization::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|max:2048',
            'content' => 'nullable',
            'status' => 'required|in:active,block'
        ]);

        $recognization->title = $request->title;
        $recognization->content = $request->content;
        $recognization->status = $request->status;

        if ($request->hasFile('image')) {

            // delete OLD original + thumb (PHP unlink parity)
            if ($recognization->image) {
                Storage::disk('public')->delete([
                    $recognization->image,
                    str_replace('affiliation/', 'affiliation/thumb/', $recognization->image)
                ]);
            }

            $recognization->image = $this->saveImage(
                $request->file('image'),
                'affiliation',
                360,
                290
            );
        }

        $recognization->save();

        return response()->json(['success' => true]);
    }

    /* ================= DELETE ================= */
    public function destroy($id)
    {
         $recognization = Recognization::findOrFail($id);
        if ($recognization->image) {
            Storage::disk('public')->delete([
                $recognization->image,
                str_replace('affiliation/', 'affiliation/thumb/', $recognization->image)
            ]);
        }

        $recognization->delete();

        return response()->json(['success' => true]);
    }

    /* ================= BULK ================= */
    public function bulk(Request $request)
    {
        if ($request->action === 'delete') {
            Recognization::whereIn('id', $request->ids)->get()->each(function ($r) {
                Storage::disk('public')->delete([
                    $r->image,
                    str_replace('affiliation/', 'affiliation/thumb/', $r->image)
                ]);
                $r->delete();
            });
        }

        if (in_array($request->action, ['active', 'block'])) {
            Recognization::whereIn('id', $request->ids)
                ->update(['status' => $request->action]);
        }

        return response()->json(['success' => true]);
    }

    /* ================= IMAGE HANDLER ================= */
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
        imagejpeg($thumb, storage_path("app/public/{$dir}/thumb/{$name}"), 90);

        imagedestroy($src);
        imagedestroy($thumb);

        return "{$dir}/{$name}";
    }
}
