@extends('layouts.app')
@section('title', 'Add Program')

@section('content')
    <div class="card">
        <div class="card-body">

            <form id="programForm" enctype="multipart/form-data">
                @csrf

                <div class="mb-2">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label>Short Description</label>
                    <textarea name="short_description" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-2">
                    <label>Detail Content</label>
                    <textarea name="detail_content" id="editor" class="form-control" rows="6" required></textarea>
                </div>

                <div class="mb-2">
                    <label>Thumbnail Image</label>
                    <input type="file" name="thumbnail" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label>Banner Image</label>
                    <input type="file" name="banner" class="form-control" required>
                </div>

                <button class="btn btn-success mt-2">Save</button>
                <a href="{{ route('manage-programs.index') }}" class="btn btn-secondary mt-2">Back</a>
            </form>

        </div>
    </div>
@endsection

@push('after-scripts')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
        $('#programForm').submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('manage-programs.store') }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: () => window.location.href =
                    "{{ route('manage-programs.index') }}"
            });
        });
    </script>
@endpush