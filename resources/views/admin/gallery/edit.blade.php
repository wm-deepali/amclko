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
                    <img src="{{ asset('storage/'.$gallery->image) }}"
                         height="120"
                         class="border rounded">
                </div>

                {{-- CATEGORY --}}
                <div class="mb-3">
                    <label class="form-label">Category *</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ $gallery->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- CHANGE IMAGE --}}
                <div class="mb-3">
                    <label class="form-label">Change Image</label>
                    <input type="file"
                           name="image"
                           class="form-control"
                           accept="image/*">
                </div>

                {{-- STATUS --}}
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="active"
                            {{ $gallery->status === 'active' ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="block"
                            {{ $gallery->status === 'block' ? 'selected' : '' }}>
                            Blocked
                        </option>
                    </select>
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('manage-galleries.index') }}"
                       class="btn btn-secondary">
                        Cancel
                    </a>
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
        url: "{{ route('manage-galleries.update', $gallery->id) }}",
        type: "POST",
        data: fd,
        processData: false,
        contentType: false,
        success: function () {
            Swal.fire(
                'Success',
                'Updated successfully',
                'success'
            ).then(() => {
                window.location.href =
                    "{{ route('manage-galleries.index') }}";
            });
        },
        error: function (xhr) {
            let msg = 'Something went wrong';

            if (xhr.responseJSON?.errors) {
                msg = Object.values(xhr.responseJSON.errors)
                    .flat()
                    .join('\n');
            }

            Swal.fire('Error', msg, 'error');
        }
    });
});
</script>
@endpush
