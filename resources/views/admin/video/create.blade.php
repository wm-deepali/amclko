@extends('layouts.app')

@section('title','Add Video')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5 class="card-title">Add Video</h5>

            <form id="videoForm">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Video URL <span class="text-danger">*</span></label>
                    <input type="text" name="url" class="form-control" required>
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Add</button>
                    <a href="{{ route('videos.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script>
$('#videoForm').submit(function(e){
    e.preventDefault();

    $.ajax({
        url:"{{ route('videos.store') }}",
        type:"POST",
        data:$(this).serialize(),
        success:function(){
            Swal.fire('Success','Video added','success')
                .then(()=>location.href="{{ route('videos.index') }}");
        }
    });
});
</script>
@endpush
