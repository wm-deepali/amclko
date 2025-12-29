@extends('layouts.app')

@section('title','Add Certificate Image')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5>Add Certificate Image</h5>
            <p class="text-muted">Recommended size: <b>270 × 200</b></p>

            <form id="createForm" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label>Image *</label>
                    <input type="file" name="image" class="form-control" required>
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Add</button>
                    <a href="{{ route('certificates.index') }}" class="btn btn-secondary">Cancel</a>
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
        url:"{{ route('certificates.store') }}",
        type:"POST",
        data:fd,
        processData:false,
        contentType:false,
        success:()=>{
            Swal.fire('Success','Image added','success')
                .then(()=>location.href="{{ route('certificates.index') }}");
        }
    });
});
</script>
@endpush
