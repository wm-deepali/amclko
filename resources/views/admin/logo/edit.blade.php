@extends('layouts.app')

@section('title','Edit Logo')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5 class="card-title">Update Logo</h5>
            <h6 class="card-subtitle mb-3 text-muted">
                Change title, status or replace logo image
            </h6>

            <form id="logoEditForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Logo Title <span class="text-danger">*</span></label>
                    <input type="text"
                           name="title"
                           class="form-control"
                           value="{{ $logo->title }}"
                           required>
                </div>

                {{-- STATUS --}}
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $logo->status === 'active' ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="block" {{ $logo->status === 'block' ? 'selected' : '' }}>
                            Blocked
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Current Logo</label>
                    <img src="{{ asset('storage/'.$logo->image) }}"
                         height="100"
                         class="mb-2 border rounded">
                </div>

                <div class="mb-3">
                    <label class="form-label">Replace Logo Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">
                        Leave empty to keep existing image
                    </small>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        Update Logo
                    </button>
                    <a href="{{ route('manage-logos.index') }}" class="btn btn-secondary">
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
$('#logoEditForm').on('submit', function(e){
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "{{ route('manage-logos.update', $logo->id) }}",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function () {
            Swal.fire('Success','Logo updated successfully','success')
                .then(() => window.location.href = "{{ route('manage-logos.index') }}");
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
