@extends('layouts.app')
@section('title', 'Add Annual Report')

@section('content')
    <div class="card">
        <div class="card-body">

            <form id="reportForm" enctype="multipart/form-data">
                @csrf

                <div class="mb-2">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label>Upload PDF</label>
                    <input type="file" name="pdf" class="form-control" required>
                </div>

                <button class="btn btn-success">Save</button>
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
                url: "{{ route('manage-annual-reports.store') }}",
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