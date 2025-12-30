@extends('layouts.app')

@section('title', 'Add Blog')

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">

                <h5>Add Blog</h5>

                <form id="blogForm" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label>Title *</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Thumbnail</label>
                        <input type="file" name="thumbnail" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Banner</label>
                        <input type="file" name="banner" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Content *</label>
                        <textarea name="content" id='editor' class="form-control" rows="6"></textarea>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-primary">Save</button>
                        <a href="{{ route('manage-blogs.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');

        $('#blogForm').submit(function (e) {
            e.preventDefault();

            // ✅ IMPORTANT: sync CKEditor content
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            let fd = new FormData(this);

            $.ajax({
                url: "{{ route('manage-blogs.store') }}",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                success: () => {
                    Swal.fire('Saved', 'Blog added', 'success')
                        .then(() => location.href = "{{ route('manage-blogs.index') }}");
                },
                error: (xhr) => {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>

@endpush