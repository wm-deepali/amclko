<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class MissionController extends Controller
{
    /* ================= LIST ================= */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Mission::latest();

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
                        <a href="' . route('manage-missions.edit', $r->id) . '" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger delete" data-id="' . $r->id . '">Delete</button>
                    '
                )
                ->rawColumns(['checkbox', 'status', 'action'])
                ->make(true);
        }

        return view('admin.mission.index');
    }

    /* ================= CREATE ================= */
    public function create()
    {
        return view('admin.mission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'status' => 'active'
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $this->saveImage(
                $request->file('image'),
                'missions',
                360,
                290
            );
        }

        Mission::create($data);

        return response()->json(['success' => true]);
    }

    /* ================= EDIT ================= */
    public function edit($id)
    {
        $mission = Mission::findOrFail($id);
        return view('admin.mission.edit', compact('mission'));
    }

    public function update(Request $request, $id)
    {
        $mission = Mission::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'status' => 'required|in:active,block',
            'image' => 'nullable|image|max:2048'
        ]);

        $mission->fill(
            $request->only('title', 'content', 'status')
        );

        if ($request->hasFile('image')) {

            if ($mission->image) {
                Storage::disk('public')->delete([
                    $mission->image,
                    str_replace('missions/', 'missions/thumb/', $mission->image)
                ]);
            }

            $mission->image = $this->saveImage(
                $request->file('image'),
                'missions',
                360,
                290
            );
        }

        $mission->save();

        return response()->json(['success' => true]);
    }

    /* ================= DELETE ================= */
    public function destroy($id)
    {
        $mission = Mission::findOrFail($id);
        if ($mission->image) {
            Storage::disk('public')->delete([
                $mission->image,
                str_replace('missions/', 'missions/thumb/', $mission->image)
            ]);
        }

        $mission->delete();

        return response()->json(['success' => true]);
    }

    /* ================= BULK ================= */
    public function bulk(Request $request)
    {
        if ($request->action === 'delete') {
            Mission::whereIn('id', $request->ids)->get()->each(function ($m) {
                if ($m->image) {
                    Storage::disk('public')->delete([
                        $m->image,
                        str_replace('missions/', 'missions/thumb/', $m->image)
                    ]);
                }
                $m->delete();
            });
        }

        if (in_array($request->action, ['active', 'block'])) {
            Mission::whereIn('id', $request->ids)
                ->update(['status' => $request->action]);
        }

        return response()->json(['success' => true]);
    }

    /* ================= IMAGE HANDLER (OLD PHP MATCH) ================= */
    private function saveImage($file, $dir, $w, $h)
    {
        $name = 'affiliation_' . time() . '.' . $file->getClientOriginalExtension();

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
