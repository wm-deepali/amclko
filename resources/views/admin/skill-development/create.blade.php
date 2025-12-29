@extends('layouts.app')

@section('title','Add Skill Development')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5>Add Skill Development</h5>
            <h6 class="text-muted mb-3">Image size: <b>360 × 290</b></h6>

            <form id="skillForm" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label>Title *</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Content</label>
                    <textarea name="content" id="editor" class="form-control"></textarea>
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Save</button>
                    <a href="{{ route('skill-dev.index') }}" class="btn btn-secondary">Cancel</a>
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

$('#skillForm').submit(function(e){
    e.preventDefault();

    let fd = new FormData(this);
    fd.set('content', CKEDITOR.instances.editor.getData());

    $.ajax({
        url:"{{ route('skill-dev.store') }}",
        type:"POST",
        data:fd,
        processData:false,
        contentType:false,
        success:()=>{
            Swal.fire('Success','Added successfully','success')
            .then(()=>location.href="{{ route('skill-dev.index') }}");
        }
    });
});
</script>
@endpush
