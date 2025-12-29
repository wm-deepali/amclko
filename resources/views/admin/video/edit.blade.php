@extends('layouts.app')

@section('title','Edit Video')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5>Edit Video</h5>

            <form id="videoEditForm">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Video URL</label>
                    <input type="text" name="url" class="form-control"
                           value="{{ $video->url }}" required>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $video->status=='active'?'selected':'' }}>Active</option>
                        <option value="block" {{ $video->status=='block'?'selected':'' }}>Blocked</option>
                    </select>
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('videos.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script>
$('#videoEditForm').submit(function(e){
    e.preventDefault();

    $.ajax({
        url:"{{ route('videos.update',$video->id) }}",
        type:"POST",
        data:$(this).serialize(),
        success:function(){
            Swal.fire('Success','Video updated','success')
                .then(()=>location.href="{{ route('videos.index') }}");
        }
    });
});
</script>
@endpush
