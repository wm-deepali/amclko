@extends('layouts.app')

@section('title','Add Application Form')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5>Add Application Form</h5>
            <p class="text-muted">Image size: <b>900 × 1080</b></p>

            <form id="createForm" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label>Title *</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Image *</label>
                    <input type="file" name="image" class="form-control" required>
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Add</button>
                    <a href="{{ route('manage-applications.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script>
$('#createForm').submit(function(e){
    e.preventDefault();

    let fd = new FormData(this);

    $.ajax({
        url:"{{ route('manage-applications.store') }}",
        type:"POST",
        data:fd,
        processData:false,
        contentType:false,
        success:()=>{
            Swal.fire('Success','Application added','success')
                .then(()=>location.href="{{ route('manage-applications.index') }}");
        }
    });
});
</script>
@endpush
