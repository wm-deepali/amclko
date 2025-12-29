<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CertificateController extends Controller
{
    /* ================= LIST ================= */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Certificate::latest();

            if ($request->status && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addColumn('checkbox', fn($r) =>
                    '<input type="checkbox" class="row_check" value="'.$r->id.'">'
                )
                ->addColumn('image', fn($r) =>
                    '<img src="'.asset('storage/'.str_replace(
                        'certificates/',
                        'certificates/thumb/',
                        $r->image
                    )).'" height="60">'
                )
                ->addColumn('status', fn($r) =>
                    $r->status === 'active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Blocked</span>'
                )
                ->addColumn('action', fn($r) =>
                    '
                        <a href="'.route('certificates.edit',$r->id).'" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger delete" data-id="'.$r->id.'">Delete</button>
                    '
                )
                ->rawColumns(['checkbox','image','status','action'])
                ->make(true);
        }

        return view('admin.certificates.index');
    }

    /* ================= CREATE ================= */
    public function create()
    {
        return view('admin.certificates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);

        $image = $this->saveImage(
            $request->file('image'),
            'certificates',
            270,
            200
        );

        Certificate::create([
            'image'  => $image,
            'status' => 'active'
        ]);

        return response()->json(['success'=>true]);
    }

    /* ================= EDIT ================= */
    public function edit(Certificate $certificate)
    {
        return view('admin.certificates.edit', compact('certificate'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $request->validate([
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {

            Storage::disk('public')->delete([
                $certificate->image,
                str_replace(
                    'certificates/',
                    'certificates/thumb/',
                    $certificate->image
                )
            ]);

            $certificate->image = $this->saveImage(
                $request->file('image'),
                'certificates',
                270,
                200
            );
        }

        $certificate->save();

        return response()->json(['success'=>true]);
    }

    /* ================= DELETE ================= */
    public function destroy(Certificate $certificate)
    {
        Storage::disk('public')->delete([
            $certificate->image,
            str_replace(
                'certificates/',
                'certificates/thumb/',
                $certificate->image
            )
        ]);

        $certificate->delete();

        return response()->json(['success'=>true]);
    }

    /* ================= BULK ================= */
    public function bulk(Request $request)
    {
        if ($request->action === 'delete') {
            Certificate::whereIn('id',$request->ids)->get()->each(function ($c) {
                Storage::disk('public')->delete([
                    $c->image,
                    str_replace(
                        'certificates/',
                        'certificates/thumb/',
                        $c->image
                    )
                ]);
                $c->delete();
            });
        }

        if (in_array($request->action,['active','block'])) {
            Certificate::whereIn('id',$request->ids)
                ->update(['status'=>$request->action]);
        }

        return response()->json(['success'=>true]);
    }

    /* ================= IMAGE HANDLER ================= */
    private function saveImage($file,$dir,$w,$h)
    {
        $name = 'gallery_'.time().'.'.$file->getClientOriginalExtension();

        // original
        $file->storeAs($dir,$name,'public');

        // thumb (same as PHP)
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

