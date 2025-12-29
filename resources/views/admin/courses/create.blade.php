@extends('layouts.app')

@section('title','Add Course')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5>Add Course</h5>
            <small class="text-muted">Image size: 140 × 154</small>

            <form id="courseForm" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label>Title *</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>URL</label>
                    <input type="text" name="url" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <div class="mb-3">
                    <label>Content</label>
                    <textarea name="content" id="editor" class="form-control"></textarea>
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Add</button>
                    <a href="{{ route('courses.index') }}" class="btn btn-secondary">Cancel</a>
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

$('#courseForm').submit(function(e){
    e.preventDefault();

    let fd = new FormData(this);
    fd.set('content', CKEDITOR.instances.editor.getData());

    $.ajax({
        url: "{{ route('courses.store') }}",
        type: "POST",
        data: fd,
        processData:false,
        contentType:false,
        success: () => {
            Swal.fire('Success','Course added','success')
                .then(()=>location.href="{{ route('courses.index') }}");
        },
        error: xhr => {
            let msg='';
            $.each(xhr.responseJSON.errors,(k,v)=>msg+=v[0]+'<br>');
            Swal.fire('Error',msg,'error');
        }
    });
});
</script>
@endpush
