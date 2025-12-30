<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnnualReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class AnnualReportController extends Controller
{
    /* ================= LIST ================= */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = AnnualReport::latest();

            if ($request->status && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addColumn('checkbox', fn ($r) =>
                    '<input type="checkbox" class="row_check" value="'.$r->id.'">'
                )
                ->addColumn('pdf', fn ($r) =>
                    '<a href="'.asset('storage/'.$r->pdf).'" target="_blank">View PDF</a>'
                )
                ->addColumn('status', fn ($r) =>
                    $r->status === 'active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Blocked</span>'
                )
                ->addColumn('action', fn ($r) =>
                    '
                    <a href="'.route('manage-annual-reports.edit',$r->id).'" class="btn btn-sm btn-info">Edit</a>
                    <button class="btn btn-sm btn-danger delete" data-id="'.$r->id.'">Delete</button>
                    '
                )
                ->rawColumns(['checkbox','pdf','status','action'])
                ->make(true);
        }

        return view('admin.annual-reports.index');
    }

    /* ================= CREATE ================= */
    public function create()
    {
        return view('admin.annual-reports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'pdf'   => 'required|mimes:pdf|max:5120',
        ]);

        AnnualReport::create([
            'title'  => $request->title,
            'pdf'    => $request->file('pdf')->store('annual-reports', 'public'),
            'status' => 'active',
        ]);

        return response()->json(['success' => true]);
    }

    /* ================= EDIT ================= */
    public function edit($id)
    {
        $report = AnnualReport::findOrFail($id);
        return view('admin.annual-reports.edit', compact('report'));
    }

    /* ================= UPDATE ================= */
    public function update(Request $request, $id)
    {
        $report = AnnualReport::findOrFail($id);

        $request->validate([
            'title'  => 'required',
            'status' => 'required|in:active,block',
            'pdf'    => 'nullable|mimes:pdf|max:5120',
        ]);

        $report->title  = $request->title;
        $report->status = $request->status;

        if ($request->hasFile('pdf')) {
            Storage::disk('public')->delete($report->pdf);
            $report->pdf = $request->file('pdf')
                ->store('annual-reports', 'public');
        }

        $report->save();

        return response()->json(['success' => true]);
    }

    /* ================= DELETE ================= */
    public function destroy($id)
    {
        $report = AnnualReport::findOrFail($id);
        Storage::disk('public')->delete($report->pdf);
        $report->delete();

        return response()->json(['success' => true]);
    }

    /* ================= BULK ================= */
    public function bulk(Request $request)
    {
        if ($request->action === 'delete') {
            $reports = AnnualReport::whereIn('id', $request->ids)->get();
            foreach ($reports as $r) {
                Storage::disk('public')->delete($r->pdf);
                $r->delete();
            }
        }

        if (in_array($request->action, ['active','block'])) {
            AnnualReport::whereIn('id', $request->ids)
                ->update(['status' => $request->action]);
        }

        return response()->json(['success' => true]);
    }
}
