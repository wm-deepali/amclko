@extends('layouts.app')

@section('title', 'Edit Background Profile')

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">

                <h5 class="card-title">Edit Background Profile</h5>
                <h6 class="card-subtitle mb-3 text-muted">
                    Image size: <strong>258 × 242</strong>
                </h6>

                <form id="bgEditForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ $background->title }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ $background->status === 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="block" {{ $background->status === 'block' ? 'selected' : '' }}>
                                Blocked
                            </option>
                        </select>
                    </div>

                    @if($background->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $background->image) }}" height="120" class="border">
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Change Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea name="content" id="editor" class="form-control" rows="8">
                                {{ $background->content }}
                            </textarea>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('manage-backgrounds.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');

        $('#bgEditForm').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);
            formData.set('content', CKEDITOR.instances.editor.getData());

            $.ajax({
                url: "{{ route('manage-backgrounds.update', $background->id) }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function () {
                    Swal.fire('Success', 'Background updated successfully', 'success')
                        .then(() => window.location.href = "{{ route('manage-backgrounds.index') }}");
                },
                error: function (xhr) {
                    let msg = '';
                    $.each(xhr.responseJSON.errors, (k, v) => msg += v[0] + '<br>');
                    Swal.fire('Error', msg, 'error');
                }
            });
        });
    </script>
@endpush