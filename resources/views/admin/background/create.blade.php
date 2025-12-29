@extends('layouts.app')

@section('title','Add Background Profile')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5 class="card-title">Add Background Profile</h5>
            <h6 class="card-subtitle mb-3 text-muted">
                Image size: <strong>258 × 242</strong>
            </h6>

            <form id="bgForm" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" id="editor" class="form-control" rows="8"></textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Add</button>
                    <a href="{{ route('backgrounds.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
@push('after-scripts')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.replace('editor');
        } else {
            console.error('CKEditor not loaded');
        }
    });

    $('#bgForm').on('submit', function(e){
        e.preventDefault();

        let formData = new FormData(this);
        formData.set('content', CKEDITOR.instances.editor.getData());

        $.ajax({
            url: "{{ route('backgrounds.store') }}",
            type: "POST",
            data: formData,
            processData:false,
            contentType:false,
            success: function () {
                Swal.fire('Success','Background added successfully','success')
                    .then(()=> window.location.href="{{ route('backgrounds.index') }}");
            },
            error: function (xhr) {
                let msg='';
                $.each(xhr.responseJSON.errors,(k,v)=> msg+=v[0]+'<br>');
                Swal.fire('Error',msg,'error');
            }
        });
    });
</script>
@endpush
