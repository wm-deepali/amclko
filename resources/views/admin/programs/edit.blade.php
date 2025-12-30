@extends('layouts.app')
@section('title', 'Edit Program')

@section('content')
    <div class="card">
        <div class="card-body">

            <form id="programForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-2">
                    <label>Title</label>
                    <input type="text" name="title" value="{{ $program->title }}" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label>Short Description</label>
                    <textarea name="short_description" class="form-control" rows="3"
                        required>{{ $program->short_description }}</textarea>
                </div>

                <div class="mb-2">
                    <label>Detail Content</label>
                    <textarea name="detail_content" id="editor" class="form-control" rows="6"
                        required>{{ $program->detail_content }}</textarea>
                </div>

                <div class="mb-2">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $program->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="block" {{ $program->status == 'block' ? 'selected' : '' }}>Blocked</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label>Thumbnail</label><br>
                    @if($program->thumbnail)
                        <img src="{{ asset('storage/' . $program->thumbnail) }}" height="80" class="mb-1">
                    @endif
                    <input type="file" name="thumbnail" class="form-control">
                </div>

                <div class="mb-2">
                    <label>Banner</label><br>
                    @if($program->banner)
                        <img src="{{ asset('storage/' . $program->banner) }}" height="80" class="mb-1">
                    @endif
                    <input type="file" name="banner" class="form-control">
                </div>

                <button class="btn btn-success mt-2">Update</button>
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
                url: "{{ route('manage-programs.update', $program->id) }}",
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