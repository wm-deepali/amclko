@extends('layouts.app')

@section('title','Add Gallery Image')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5 class="card-title mb-3">Add Gallery Image</h5>
            <p class="text-muted">
                Image size: <strong>250 × 171</strong>
            </p>

            <form id="galleryForm" enctype="multipart/form-data">
                @csrf

                {{-- CATEGORY --}}
                <div class="mb-3">
                    <label class="form-label">Category *</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">
                                {{ $cat->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- IMAGE --}}
                <div class="mb-3">
                    <label class="form-label">Image *</label>
                    <input type="file"
                           name="image"
                           class="form-control"
                           accept="image/*"
                           required>
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Add</button>
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
$('#galleryForm').on('submit', function(e){
    e.preventDefault();

    let fd = new FormData(this);

    $.ajax({
        url: "{{ route('manage-galleries.store') }}",
        type: "POST",
        data: fd,
        processData: false,
        contentType: false,
        success: function () {
            Swal.fire(
                'Success',
                'Image added successfully',
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
