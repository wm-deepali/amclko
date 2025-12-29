@extends('layouts.app')

@section('title','Add Slider')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5 class="card-title">Add New Slider</h5>
            <h6 class="card-subtitle mb-3 text-muted">
                Recommended image size: <b>1358 × 574</b>
            </h6>

            <form id="sliderForm" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Slider Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Slider Image <span class="text-danger">*</span></label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Add Slider</button>
                    <a href="{{ route('sliders.index') }}" class="btn btn-secondary">Cancel</a>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script>
$('#sliderForm').submit(function(e){
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "{{ route('sliders.store') }}",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function () {
            Swal.fire('Success','Slider added successfully','success')
                .then(() => window.location.href = "{{ route('sliders.index') }}");
        },
        error: function (xhr) {
            let msg = '';
            $.each(xhr.responseJSON.errors, (k,v) => msg += v[0]+'<br>');
            Swal.fire('Error', msg, 'error');
        }
    });
});
</script>
@endpush
