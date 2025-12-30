@extends('layouts.app')

@section('title','Edit Contact')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5>Edit Contact</h5>

            <form id="contactEditForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Title *</label>
                    <input type="text" name="title" value="{{ $contact->title }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $contact->email }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ $contact->phone }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Mobile</label>
                    <input type="text" name="mobile" value="{{ $contact->mobile }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Website</label>
                    <input type="text" name="website" value="{{ $contact->website }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Map Embed Code</label>
                    <textarea name="map_embed" class="form-control" rows="4">{{ $contact->map_embed }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control" rows="4">{{ $contact->address }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $contact->status=='active'?'selected':'' }}>Active</option>
                        <option value="block" {{ $contact->status=='block'?'selected':'' }}>Blocked</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Change Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('manage-contacts.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script>
$('#contactEditForm').submit(function(e){
    e.preventDefault();

    let fd = new FormData(this);

    $.ajax({
        url: "{{ route('manage-contacts.update',$contact->id) }}",
        type: "POST",
        data: fd,
        processData:false,
        contentType:false,
        success: () => {
            Swal.fire('Success','Updated successfully','success')
            .then(()=> location.href="{{ route('manage-contacts.index') }}");
        }
    });
});
</script>
@endpush
