@extends('layouts.app')

@section('title','Edit Slider')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5 class="card-title">Edit Slider</h5>
            <h6 class="card-subtitle mb-3 text-muted">
                Recommended image size: <b>1358 × 574</b>
            </h6>

            <form id="sliderEditForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Slider Title</label>
                    <input type="text"
                           name="title"
                           class="form-control"
                           value="{{ $slider->title }}"
                           required>
                </div>

                {{-- STATUS --}}
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $slider->status === 'active' ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="block" {{ $slider->status === 'block' ? 'selected' : '' }}>
                            Blocked
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <img src="{{ asset('storage/'.$slider->image) }}" height="100">
                </div>

                <div class="mb-3">
                    <label class="form-label">Change Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Update Slider</button>
                    <a href="{{ route('sliders.index') }}" class="btn btn-secondary">Back</a>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script>
$('#sliderEditForm').submit(function(e){
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "{{ route('sliders.update',$slider->id) }}",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function () {
            Swal.fire('Success','Slider updated successfully','success')
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
