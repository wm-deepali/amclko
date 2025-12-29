@extends('layouts.app')

@section('title','Edit Gallery Image')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5 class="card-title mb-3">Edit Gallery Image</h5>

            <form id="galleryEditForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- IMAGE PREVIEW --}}
                <div class="mb-3">
                    <img src="{{ asset('storage/'.$gallery->image) }}" height="120" class="border">
                </div>

                {{-- CHANGE IMAGE --}}
                <div class="mb-3">
                    <label class="form-label">Change Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                {{-- STATUS --}}
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $gallery->status === 'active' ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="block" {{ $gallery->status === 'block' ? 'selected' : '' }}>
                            Blocked
                        </option>
                    </select>
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('galleries.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script>
$('#galleryEditForm').on('submit', function(e){
    e.preventDefault();

    let fd = new FormData(this);

    $.ajax({
        url: "{{ route('galleries.update', $gallery->id) }}",
        type: "POST",
        data: fd,
        processData: false,
        contentType: false,
        success: function () {
            Swal.fire('Success','Updated successfully','success')
                .then(()=> window.location.href="{{ route('galleries.index') }}");
        },
        error: function (xhr) {
            Swal.fire('Error','Something went wrong','error');
        }
    });
});
</script>
@endpush
