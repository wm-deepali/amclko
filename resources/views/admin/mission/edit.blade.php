@extends('layouts.app')

@section('title','Edit Mission')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5>Edit Vision / Mission</h5>

            <form id="missionEditForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Title *</label>
                    <input type="text" name="title"
                           value="{{ $mission->title }}"
                           class="form-control" required>
                </div>

                @if($mission->image)
                <div class="mb-3">
                    <img src="{{ asset('storage/'.$mission->image) }}"
                         height="120" class="border">
                </div>
                @endif

                <div class="mb-3">
                    <label>Change Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Content *</label>
                    <textarea name="content" id="editor" class="form-control">
{!! $mission->content !!}
                    </textarea>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $mission->status=='active'?'selected':'' }}>
                            Active
                        </option>
                        <option value="block" {{ $mission->status=='block'?'selected':'' }}>
                            Blocked
                        </option>
                    </select>
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('manage-missions.index') }}" class="btn btn-secondary">Cancel</a>
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

$('#missionEditForm').submit(function(e){
    e.preventDefault();

    let fd = new FormData(this);
    fd.set('content', CKEDITOR.instances.editor.getData());

    $.ajax({
        url:"{{ route('manage-missions.update',$mission->id) }}",
        type:"POST",
        data:fd,
        processData:false,
        contentType:false,
        success:()=>{
            Swal.fire('Success','Updated successfully','success')
            .then(()=>location.href="{{ route('manage-missions.index') }}");
        }
    });
});
</script>
@endpush
