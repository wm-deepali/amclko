<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VideoController extends Controller
{
    /* ================= LIST ================= */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Video::latest();

            if ($request->status && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addColumn(
                    'checkbox',
                    fn($v) =>
                    '<input type="checkbox" class="row_check" value="' . $v->id . '">'
                )
                ->addColumn(
                    'status',
                    fn($v) =>
                    $v->status === 'active'
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Blocked</span>'
                )
                ->addColumn(
                    'action',
                    fn($v) =>
                    '<a href="' . route('manage-videos.edit', $v->id) . '" class="btn btn-sm btn-info">Edit</a>
                     <button class="btn btn-sm btn-danger delete" data-id="' . $v->id . '">Delete</button>'
                )
                ->rawColumns(['checkbox', 'status', 'action'])
                ->make(true);
        }

        return view('admin.video.index');
    }

    /* ================= CREATE ================= */
    public function create()
    {
        return view('admin.video.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|string'
        ]);

        Video::create([
            'url' => $request->url,
            'status' => 'active'
        ]);

        return response()->json(['success' => true]);
    }

    /* ================= EDIT ================= */
    public function edit($id)
    {
        $video = Video::findOrFail($id);
        return view('admin.video.edit', compact('video'));
    }

    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        $request->validate([
            'url' => 'required|string',
            'status' => 'required|in:active,block'
        ]);

        $video->update([
            'url' => $request->url,
            'status' => $request->status
        ]);

        return response()->json(['success' => true]);
    }

    /* ================= DELETE ================= */
    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();
        return response()->json(['success' => true]);
    }

    /* ================= BULK ================= */
    public function bulk(Request $request)
    {
        if ($request->action === 'delete') {
            Video::whereIn('id', $request->ids)->delete();
        } else {
            Video::whereIn('id', $request->ids)
                ->update(['status' => $request->action]);
        }

        return response()->json(['success' => true]);
    }
}
