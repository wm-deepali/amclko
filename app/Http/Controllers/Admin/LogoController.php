<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class LogoController extends Controller
{
    /* ===============================
     |  LIST (DATATABLE)
     =============================== */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $logos = Logo::latest();

            if ($request->status && $request->status !== 'all') {
                $logos->where('status', $request->status);
            }

            return DataTables::of($logos)
                ->addColumn(
                    'checkbox',
                    fn($row) =>
                    '<input type="checkbox" class="row_check" value="' . $row->id . '">'
                )
                ->addColumn(
                    'image',
                    fn($row) =>
                    '<img src="' . asset('storage/' . $row->image) . '" height="60">'
                )
                ->addColumn(
                    'status',
                    fn($row) =>
                    $row->status === 'active'
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Blocked</span>'
                )
                ->addColumn(
                    'action',
                    fn($row) =>
                    '<a href="' . route('logos.edit', $row->id) . '" class="btn btn-sm btn-info">Edit</a>
                     <button class="btn btn-sm btn-danger delete" data-id="' . $row->id . '">Delete</button>'
                )
                ->rawColumns(['checkbox', 'image', 'status', 'action'])
                ->make(true);
        }

        return view('admin.logo.index');
    }

    /* ===============================
     |  CREATE
     =============================== */
    public function create()
    {
        return view('admin.logo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|max:2048'
        ]);

        $filename = $this->saveLogoImage($request->file('image'));

        Logo::create([
            'title' => $request->title,
            'image' => 'logos/' . $filename,
            'status' => 'active'
        ]);

        return response()->json(['success' => true]);
    }

    /* ===============================
     |  EDIT
     =============================== */
    public function edit(Logo $logo)
    {
        return view('admin.logo.edit', compact('logo'));
    }

    public function update(Request $request, Logo $logo)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required|in:active,block',
            'image' => 'nullable|image|max:2048'
        ]);

        $logo->title = $request->title;
        $logo->status = $request->status; // ✅ OLD PHP MATCH

        if ($request->hasFile('image')) {

            // delete old original + thumb (same as PHP unlink)
            Storage::disk('public')->delete([
                $logo->image,
                str_replace('logos/', 'logos/thumb/', $logo->image)
            ]);

            $filename = $this->saveLogoImage($request->file('image'));
            $logo->image = 'logos/' . $filename;
        }

        $logo->save();

        return response()->json(['success' => true]);
    }


    /* ===============================
     |  DELETE
     =============================== */
    public function destroy(Logo $logo)
    {
        Storage::disk('public')->delete([
            $logo->image,
            str_replace('logos/', 'logos/thumb/', $logo->image)
        ]);

        $logo->delete();

        return response()->json(['success' => true]);
    }

    /* ===============================
     |  BULK ACTIONS
     =============================== */
    public function bulk(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'action' => 'required|in:delete,active,block'
        ]);

        if ($request->action === 'delete') {
            Logo::whereIn('id', $request->ids)->get()->each(function ($logo) {
                Storage::disk('public')->delete([
                    $logo->image,
                    str_replace('logos/', 'logos/thumb/', $logo->image)
                ]);
                $logo->delete();
            });
        } else {
            Logo::whereIn('id', $request->ids)
                ->update(['status' => $request->action]);
        }

        return response()->json(['success' => true]);
    }

    /* ===============================
     |  IMAGE HANDLER (EXACT OLD PHP)
     =============================== */
    private function saveLogoImage($file)
    {
        $ext = $file->getClientOriginalExtension();
        $name = 'logo_' . now()->format('YmdHis') . '.' . $ext;

        // Save original
        $file->storeAs('logos', $name, 'public');

        // Create thumb (120x120)
        $src = imagecreatefromstring(file_get_contents($file));
        $thumb = imagecreatetruecolor(120, 120);

        imagecopyresampled(
            $thumb,
            $src,
            0,
            0,
            0,
            0,
            120,
            120,
            imagesx($src),
            imagesy($src)
        );

        Storage::disk('public')->makeDirectory('logos/thumb');

        imagejpeg(
            $thumb,
            storage_path("app/public/logos/thumb/{$name}"),
            90
        );

        imagedestroy($src);
        imagedestroy($thumb);

        return $name;
    }
}
