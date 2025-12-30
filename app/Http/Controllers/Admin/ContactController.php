<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    /* ================= LIST ================= */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Contact::latest();

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
                    <a href="'.route('manage-contacts.edit',$r->id).'" class="btn btn-sm btn-info">Edit</a>
                    <button class="btn btn-sm btn-danger delete" data-id="'.$r->id.'">Delete</button>
                    '
                )
                ->rawColumns(['checkbox','status','action'])
                ->make(true);
        }

        return view('admin.contacts.index');
    }

    /* ================= CREATE ================= */
    public function create()
    {
        return view('admin.contacts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required',
            'email'   => 'nullable|email',
            'image'   => 'nullable|image|max:2048'
        ]);

        $data = $request->only([
            'title',
            'address',
            'email',
            'phone',
            'mobile',
            'website',
            'map_embed'
        ]);

        $data['status'] = 'active';

        if ($request->hasFile('image')) {
            $data['image'] = $this->saveImage(
                $request->file('image'),
                'contacts',
                360,
                290
            );
        }

        Contact::create($data);

        return response()->json(['success' => true]);
    }

    /* ================= EDIT ================= */
    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.edit', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $request->validate([
            'title'  => 'required',
            'email'  => 'nullable|email',
            'status' => 'required|in:active,block',
            'image'  => 'nullable|image|max:2048'
        ]);

        $contact->fill($request->only([
            'title',
            'address',
            'email',
            'phone',
            'mobile',
            'website',
            'map_embed',
            'status'
        ]));

        if ($request->hasFile('image')) {

            if ($contact->image) {
                Storage::disk('public')->delete([
                    $contact->image,
                    str_replace('contacts/', 'contacts/thumb/', $contact->image)
                ]);
            }

            $contact->image = $this->saveImage(
                $request->file('image'),
                'contacts',
                360,
                290
            );
        }

        $contact->save();

        return response()->json(['success' => true]);
    }

    /* ================= DELETE ================= */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        if ($contact->image) {
            Storage::disk('public')->delete([
                $contact->image,
                str_replace('contacts/', 'contacts/thumb/', $contact->image)
            ]);
        }

        $contact->delete();

        return response()->json(['success' => true]);
    }

    /* ================= BULK ================= */
    public function bulk(Request $request)
    {
        if ($request->action === 'delete') {
            Contact::whereIn('id', $request->ids)->delete();
        }

        if (in_array($request->action, ['active', 'block'])) {
            Contact::whereIn('id', $request->ids)
                ->update(['status' => $request->action]);
        }

        return response()->json(['success' => true]);
    }

    /* ================= IMAGE HANDLER ================= */
    private function saveImage($file, $dir, $w, $h)
    {
        $name = 'contact_' . time() . '.' . $file->getClientOriginalExtension();

        // original
        $file->storeAs($dir, $name, 'public');

        // thumb
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
