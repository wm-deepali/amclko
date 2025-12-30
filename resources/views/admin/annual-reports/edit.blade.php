@extends('layouts.app')
@section('title', 'Edit Annual Report')

@section('content')
    <div class="card">
        <div class="card-body">

            <form id="reportForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-2">
                    <label>Title</label>
                    <input type="text" name="title" value="{{ $report->title }}" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $report->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="block" {{ $report->status == 'block' ? 'selected' : '' }}>Blocked</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label>Current PDF</label><br>
                    <a href="{{ asset('storage/' . $report->pdf) }}" target="_blank">View PDF</a>
                </div>

                <div class="mb-2">
                    <label>Replace PDF (optional)</label>
                    <input type="file" name="pdf" class="form-control">
                </div>

                <button class="btn btn-success">Update</button>
                <a href="{{ route('manage-annual-reports.index') }}" class="btn btn-secondary">Back</a>
            </form>

        </div>
    </div>
@endsection

@push('after-scripts')
    <script>
        $('#reportForm').submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('manage-annual-reports.update', $report->id) }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: () => window.location.href =
                    "{{ route('manage-annual-reports.index') }}"
            });
        });
    </script>
@endpush