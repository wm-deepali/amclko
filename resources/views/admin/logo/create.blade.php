@extends('layouts.app')

@section('title','Add Logo')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5 class="card-title">Add New Logo</h5>
            <h6 class="card-subtitle mb-3 text-muted">
                Upload logo image (Recommended size: 120×120)
            </h6>

            <form id="logoForm" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Logo Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Logo Image <span class="text-danger">*</span></label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                    <small class="text-muted">Only jpg, png, webp (max 2MB)</small>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        Add Logo
                    </button>
                    <a href="{{ route('logos.index') }}" class="btn btn-secondary">
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
$('#logoForm').on('submit', function(e){
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "{{ route('logos.store') }}",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function () {
            Swal.fire('Success','Logo added successfully','success')
                .then(() => window.location.href = "{{ route('logos.index') }}");
        },
        error: function (xhr) {
            let msg = '';
            $.each(xhr.responseJSON.errors, (k,v)=> msg += v[0]+'<br>');
            Swal.fire('Error', msg, 'error');
        }
    });
});
</script>
@endpush
