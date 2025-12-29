<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chairman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ChairmanController extends Controller
{
    /* ================= LIST ================= */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Chairman::latest();

            if ($request->status && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addColumn('checkbox', fn($r) =>
                    '<input type="checkbox" class="row_check" value="'.$r->id.'">'
                )
                ->addColumn('status', fn($r) =>
                    $r->status === 'active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Blocked</span>'
                )
                ->addColumn('action', fn($r) =>
                    '
                    <a href="'.route('chairmen.edit',$r->id).'" class="btn btn-sm btn-info">Edit</a>
                    <button class="btn btn-sm btn-danger delete" data-id="'.$r->id.'">Delete</button>
                    '
                )
                ->rawColumns(['checkbox','status','action'])
                ->make(true);
        }

        return view('admin.chairman.index');
    }

    /* ================= CREATE ================= */
    public function create()
    {
        return view('admin.chairman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
            'image'   => 'nullable|image|max:2048'
        ]);

        $data = $request->only('title','content');
        $data['status'] = 'active';

        if ($request->hasFile('image')) {
            $data['image'] = $this->saveImage(
                $request->file('image'),
                'chairman',
                360,
                290
            );
        }

        Chairman::create($data);

        return response()->json(['success'=>true]);
    }

    /* ================= EDIT ================= */
    public function edit(Chairman $chairman)
    {
        return view('admin.chairman.edit', compact('chairman'));
    }

    public function update(Request $request, Chairman $chairman)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
            'status'  => 'required|in:active,block',
            'image'   => 'nullable|image|max:2048'
        ]);

        $chairman->fill($request->only('title','content','status'));

        if ($request->hasFile('image')) {
            if ($chairman->image) {
                Storage::disk('public')->delete([
                    $chairman->image,
                    str_replace('chairman/', 'chairman/thumb/', $chairman->image)
                ]);
            }

            $chairman->image = $this->saveImage(
                $request->file('image'),
                'chairman',
                360,
                290
            );
        }

        $chairman->save();

        return response()->json(['success'=>true]);
    }

    /* ================= DELETE ================= */
    public function destroy(Chairman $chairman)
    {
        if ($chairman->image) {
            Storage::disk('public')->delete([
                $chairman->image,
                str_replace('chairman/', 'chairman/thumb/', $chairman->image)
            ]);
        }

        $chairman->delete();

        return response()->json(['success'=>true]);
    }

    /* ================= BULK ================= */
    public function bulk(Request $request)
    {
        if ($request->action === 'delete') {
            Chairman::whereIn('id',$request->ids)->get()->each(function ($c) {
                if ($c->image) {
                    Storage::disk('public')->delete([
                        $c->image,
                        str_replace('chairman/', 'chairman/thumb/', $c->image)
                    ]);
                }
                $c->delete();
            });
        }

        if (in_array($request->action,['active','block'])) {
            Chairman::whereIn('id',$request->ids)
                ->update(['status'=>$request->action]);
        }

        return response()->json(['success'=>true]);
    }

    /* ================= IMAGE HANDLER ================= */
    private function saveImage($file,$dir,$w,$h)
    {
        $name = 'affiliation_'.time().'.'.$file->getClientOriginalExtension();

        // original
        $file->storeAs($dir,$name,'public');

        // thumb
        $src   = imagecreatefromstring(file_get_contents($file));
        $thumb = imagecreatetruecolor($w,$h);

        imagecopyresampled(
            $thumb,$src,0,0,0,0,$w,$h,
            imagesx($src),imagesy($src)
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
