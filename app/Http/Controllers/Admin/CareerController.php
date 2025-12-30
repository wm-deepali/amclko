<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CareerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Career::latest())
                ->addColumn('resume', fn($r) =>
                    '<a href="'.asset('storage/'.$r->resume).'" target="_blank">View Resume</a>'
                )
                ->addColumn('action', fn($r) =>
                    '
                    <a href="'.route('manage-careers.show',$r->id).'" class="btn btn-sm btn-info">View</a>
                    <button class="btn btn-sm btn-danger delete" data-id="'.$r->id.'">Delete</button>
                    '
                )
                ->rawColumns(['resume','action'])
                ->make(true);
        }

        return view('admin.careers.index');
    }

    public function show($id)
    {
        $career = Career::findOrFail($id);
        return view('admin.careers.show', compact('career'));
    }

    public function destroy($id)
    {
        $career = Career::findOrFail($id);

        if ($career->resume) {
            Storage::disk('public')->delete($career->resume);
        }

        $career->delete();

        return response()->json(['success'=>true]);
    }
}
