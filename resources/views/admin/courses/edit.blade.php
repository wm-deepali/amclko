@extends('layouts.app')

@section('title','Edit Course')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5>Edit Course</h5>

            <form id="courseEditForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Title *</label>
                    <input type="text" name="title"
                           value="{{ $course->title }}"
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>URL</label>
                    <input type="text" name="url"
                           value="{{ $course->url }}"
                           class="form-control">
                </div>

                {{-- STATUS --}}
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $course->status === 'active' ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="block" {{ $course->status === 'block' ? 'selected' : '' }}>
                            Blocked
                        </option>
                    </select>
                </div>

                @if($course->image)
                <div class="mb-3">
                    <img src="{{ asset('storage/'.$course->image) }}" height="100">
                </div>
                @endif

                <div class="mb-3">
                    <label>Change Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Content</label>
                    <textarea name="content" id="editor" class="form-control">
                        {!! $course->content !!}
                    </textarea>
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Update</button>
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

$('#courseEditForm').submit(function(e){
    e.preventDefault();

    let fd = new FormData(this);
    fd.set('content', CKEDITOR.instances.editor.getData());

    $.ajax({
        url: "{{ route('courses.update',$course->id) }}",
        type: "POST",
        data: fd,
        processData:false,
        contentType:false,
        success: () => {
            Swal.fire('Success','Course updated','success')
                .then(()=>location.href="{{ route('courses.index') }}");
        },
        error: () => Swal.fire('Error','Something went wrong','error')
    });
});
</script>
@endpush
