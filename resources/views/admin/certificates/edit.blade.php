@extends('layouts.app')

@section('title','Edit Certificate Image')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5>Edit Certificate Image</h5>

            <form id="editForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <img src="{{ asset('storage/'.$certificate->image) }}" height="120">
                </div>

                <div class="mb-3">
                    <label>Change Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('manage-certificates.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script>
$('#editForm').submit(function(e){
    e.preventDefault();

    let fd = new FormData(this);

    $.ajax({
        url:"{{ route('manage-certificates.update',$certificate->id) }}",
        type:"POST",
        data:fd,
        processData:false,
        contentType:false,
        success:()=>{
            Swal.fire('Success','Image updated','success')
                .then(()=>location.href="{{ route('manage-certificates.index') }}");
        }
    });
});
</script>
@endpush
