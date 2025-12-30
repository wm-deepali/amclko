<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Secretary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SecretaryController extends Controller
{
    /* ================= LIST ================= */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Secretary::latest();

            if ($request->status && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addColumn('checkbox', fn ($r) =>
                    '<input type="checkbox" class="row_check" value="'.$r->id.'">'
                )
                ->addColumn('status', fn ($r) =>
                    $r->status === 'active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Blocked</span>'
                )
                ->addColumn('action', fn ($r) =>
                    '
                        <a href="'.route('manage-secretaries.edit',$r->id).'" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger delete" data-id="'.$r->id.'">Delete</button>
                    '
                )
                ->rawColumns(['checkbox','status','action'])
                ->make(true);
        }

        return view('admin.secretary.index');
    }

    /* ================= CREATE ================= */
    public function create()
    {
        return view('admin.secretary.create');
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
                'secretaries',
                360,
                290
            );
        }

        Secretary::create($data);

        return response()->json(['success' => true]);
    }

    /* ================= EDIT ================= */
    public function edit($id)
    {
        $secretary = Secretary::findOrFail($id);
        return view('admin.secretary.edit', compact('secretary'));
    }

    public function update(Request $request, $id)
    {
        $secretary = Secretary::findOrFail($id);
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
            'status'  => 'required|in:active,block',
            'image'   => 'nullable|image|max:2048'
        ]);

        $secretary->update(
            $request->only('title','content','status')
        );

        if ($request->hasFile('image')) {

            if ($secretary->image) {
                Storage::disk('public')->delete([
                    $secretary->image,
                    str_replace('secretaries/', 'secretaries/thumb/', $secretary->image)
                ]);
            }

            $secretary->image = $this->saveImage(
                $request->file('image'),
                'secretaries',
                360,
                290
            );

            $secretary->save();
        }

        return response()->json(['success' => true]);
    }

    /* ================= DELETE ================= */
    public function destroy($id)
    {
        $secretary = Secretary::findOrFail($id);
        if ($secretary->image) {
            Storage::disk('public')->delete([
                $secretary->image,
                str_replace('secretaries/', 'secretaries/thumb/', $secretary->image)
            ]);
        }

        $secretary->delete();

        return response()->json(['success' => true]);
    }

    /* ================= BULK ================= */
    public function bulk(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,active,block',
            'ids'    => 'required|array'
        ]);

        if ($request->action === 'delete') {
            Secretary::whereIn('id', $request->ids)->get()->each(function ($s) {
                if ($s->image) {
                    Storage::disk('public')->delete([
                        $s->image,
                        str_replace('secretaries/', 'secretaries/thumb/', $s->image)
                    ]);
                }
                $s->delete();
            });
        }

        if (in_array($request->action, ['active','block'])) {
            Secretary::whereIn('id', $request->ids)
                ->update(['status' => $request->action]);
        }

        return response()->json(['success' => true]);
    }

    /* ================= IMAGE HANDLER ================= */
    private function saveImage($file, $dir, $w, $h)
    {
        $name = 'secretary_' . time() . '.' . $file->getClientOriginalExtension();

        // original
        $file->storeAs($dir, $name, 'public');

        // thumb
        $src   = imagecreatefromstring(file_get_contents($file));
        $thumb = imagecreatetruecolor($w, $h);

        imagecopyresampled(
            $thumb, $src, 0, 0, 0, 0,
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
