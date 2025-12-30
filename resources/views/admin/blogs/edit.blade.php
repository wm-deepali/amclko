@extends('layouts.app')

@section('title','Edit Blog')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5>Edit Blog</h5>

            <form id="blogEditForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Title *</label>
                    <input type="text" name="title" class="form-control"
                           value="{{ $blog->title }}" required>
                </div>

                <div class="mb-3">
                    <label>Thumbnail</label><br>
                    @if($blog->thumbnail)
                        <img src="{{ asset('storage/'.$blog->thumbnail) }}" height="80">
                    @endif
                    <input type="file" name="thumbnail" class="form-control mt-2">
                </div>

                <div class="mb-3">
                    <label>Banner</label><br>
                    @if($blog->banner)
                        <img src="{{ asset('storage/'.$blog->banner) }}" height="80">
                    @endif
                    <input type="file" name="banner" class="form-control mt-2">
                </div>

                <div class="mb-3">
                    <label>Content *</label>
                    <textarea name="content" id='content' class="form-control" rows="6">{!! $blog->content !!}</textarea>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $blog->status=='active'?'selected':'' }}>Active</option>
                        <option value="block" {{ $blog->status=='block'?'selected':'' }}>Blocked</option>
                    </select>
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Update</button>
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
CKEDITOR.replace('content');

$('#blogEditForm').submit(function(e){
    e.preventDefault();

    // ✅ IMPORTANT: sync CKEditor data to textarea
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }

    let fd = new FormData(this);

    $.ajax({
        url: "{{ route('manage-blogs.update',$blog->id) }}",
        type: "POST",
        data: fd,
        processData: false,
        contentType: false,
        success: () => {
            Swal.fire('Updated','Blog updated','success')
            .then(() => location.href="{{ route('manage-blogs.index') }}");
        },
        error: (xhr) => {
            console.log(xhr.responseText);
        }
    });
});
</script>

@endpush
