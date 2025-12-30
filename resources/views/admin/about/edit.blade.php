@extends('layouts.app')

@section('title','Edit About')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5 class="card-title">Edit About</h5>

            <form id="aboutEditForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title"
                           value="{{ $about->title }}"
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Content <span class="text-danger">*</span></label>
                    <textarea name="content" id="editor" class="form-control">
{!! $about->content !!}
                    </textarea>
                </div>

                @if($about->image)
                <div class="mb-3">
                    <label class="form-label">Current Image</label><br>
                    <img src="{{ asset('storage/'.str_replace('abouts/','abouts/thumb/',$about->image)) }}"
                         height="120" class="border">
                </div>
                @endif

                <div class="mb-3">
                    <label class="form-label">Change Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $about->status=='active'?'selected':'' }}>
                            Active
                        </option>
                        <option value="block" {{ $about->status=='block'?'selected':'' }}>
                            Blocked
                        </option>
                    </select>
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Update</button>
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

$('#aboutEditForm').submit(function(e){
    e.preventDefault();

    let fd = new FormData(this);
    fd.set('content', CKEDITOR.instances.editor.getData());

    $.ajax({
        url: "{{ route('manage-abouts.update',$about->id) }}",
        type: "POST",
        data: fd,
        processData:false,
        contentType:false,
        success: () => {
            Swal.fire('Success','Updated successfully','success')
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
