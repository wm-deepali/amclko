@extends('layouts.app')

@section('title','Add Contact')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5>Add Contact</h5>

            <form id="contactForm" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label>Title *</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Mobile</label>
                    <input type="text" name="mobile" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Website</label>
                    <input type="text" name="website" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Map Embed Code</label>
                    <textarea name="map_embed" class="form-control" rows="4"></textarea>
                </div>

                <div class="mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control" rows="4"></textarea>
                </div>

                <div class="mb-3">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Save</button>
                    <a href="{{ route('manage-contacts.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
$('#contactForm').submit(function(e){
    e.preventDefault();

    let fd = new FormData(this);

    $.ajax({
        url: "{{ route('manage-contacts.store') }}",
        type: "POST",
        data: fd,
        processData:false,
        contentType:false,
        success: () => {
            Swal.fire('Success','Saved successfully','success')
            .then(()=> location.href="{{ route('manage-contacts.index') }}");
        }
    });
});
</script>
@endpush
