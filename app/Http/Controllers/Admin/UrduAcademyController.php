<?php

// app/Http/Controllers/Admin/UrduAcademyController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UrduAcademy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class UrduAcademyController extends Controller
{
    /* ================= LIST ================= */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = UrduAcademy::latest();

            if ($request->status && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addColumn('checkbox', fn($r) =>
                    '<input type="checkbox" class="row_check" value="'.$r->id.'">'
                )
                ->addColumn('image', fn($r) =>
                    $r->image
                        ? '<img src="'.asset('storage/'.str_replace(
                            'affiliation/',
                            'affiliation/thumb/',
                            $r->image
                        )).'" height="60">'
                        : ''
                )
                ->addColumn('status', fn($r) =>
                    $r->status === 'active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Blocked</span>'
                )
                ->addColumn('action', fn($r) =>
                    '<a href="'.route('urdu-academy.edit',$r).'" class="btn btn-sm btn-info">Edit</a>
                     <button class="btn btn-sm btn-danger delete" data-id="'.$r->id.'">Delete</button>'
                )
                ->rawColumns(['checkbox','image','status','action'])
                ->make(true);
        }

        return view('admin.urdu-academy.index');
    }

    /* ================= CREATE ================= */
    public function create()
    {
        return view('admin.urdu-academy.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'nullable',
            'image'   => 'nullable|image|max:2048',
        ]);

        $academy = UrduAcademy::create([
            'title'   => $request->title,
            'content' => $request->content,
            'status'  => 'active',
        ]);

        if ($request->hasFile('image')) {
            $academy->image = $this->saveImage(
                $request->file('image'),
                'affiliation',
                360,
                290
            );
            $academy->save();
        }

        return response()->json(['success'=>true]);
    }

    /* ================= EDIT ================= */
    public function edit(UrduAcademy $urdu_academy)
    {
        return view('admin.urdu-academy.edit', [
            'academy' => $urdu_academy
        ]);
    }

    public function update(Request $request, UrduAcademy $urdu_academy)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'nullable',
            'image'   => 'nullable|image|max:2048',
            'status'  => 'required|in:active,block'
        ]);

        $urdu_academy->update([
            'title'   => $request->title,
            'content' => $request->content,
            'status'  => $request->status,
        ]);

        if ($request->hasFile('image')) {

            Storage::disk('public')->delete([
                $urdu_academy->image,
                str_replace('affiliation/', 'affiliation/thumb/', $urdu_academy->image)
            ]);

            $urdu_academy->image = $this->saveImage(
                $request->file('image'),
                'affiliation',
                360,
                290
            );
            $urdu_academy->save();
        }

        return response()->json(['success'=>true]);
    }

    /* ================= DELETE ================= */
    public function destroy(UrduAcademy $urdu_academy)
    {
        Storage::disk('public')->delete([
            $urdu_academy->image,
            str_replace('affiliation/', 'affiliation/thumb/', $urdu_academy->image)
        ]);

        $urdu_academy->delete();

        return response()->json(['success'=>true]);
    }

    /* ================= BULK ================= */
    public function bulk(Request $request)
    {
        if ($request->action === 'delete') {
            UrduAcademy::whereIn('id',$request->ids)->get()->each(function ($r) {
                Storage::disk('public')->delete([
                    $r->image,
                    str_replace('affiliation/', 'affiliation/thumb/', $r->image)
                ]);
                $r->delete();
            });
        } else {
            UrduAcademy::whereIn('id',$request->ids)
                ->update(['status'=>$request->action]);
        }

        return response()->json(['success'=>true]);
    }

    /* ================= IMAGE HANDLER ================= */
    private function saveImage($file,$dir,$w,$h)
    {
        $name = 'affiliation_'.time().'.'.$file->getClientOriginalExtension();

        $file->storeAs($dir,$name,'public');

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
