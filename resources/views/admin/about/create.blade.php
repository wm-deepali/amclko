@extends('layouts.app')

@section('title','Add About')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5 class="card-title">Add About</h5>

            <form id="aboutCreateForm" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Content <span class="text-danger">*</span></label>
                    <textarea name="content" id="editor" class="form-control" rows="6"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control">
                    <small class="text-muted">Thumb auto generated (304 × 221)</small>
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Save</button>
                    <a href="{{ route('manage-abouts.index') }}" class="btn btn-secondary">Cancel</a>
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

$('#aboutCreateForm').submit(function(e){
    e.preventDefault();

    let fd = new FormData(this);
    fd.set('content', CKEDITOR.instances.editor.getData());

    $.ajax({
        url: "{{ route('manage-abouts.store') }}",
        type: "POST",
        data: fd,
        processData:false,
        contentType:false,
        success: () => {
            Swal.fire('Success','Added successfully','success')
            .then(()=>location.href="{{ route('manage-abouts.index') }}");
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
