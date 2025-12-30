@extends('layouts.app')
@section('title','Add Gallery Category')

@section('content')
<div class="card">
    <div class="card-body">

        <form id="categoryForm">
            @csrf

            <div class="mb-2">
                <label>Category Title</label>
                <input type="text" name="title"
                       class="form-control" required>
            </div>

            <div class="mb-2">
                <label>Include In Programmes</label>
                <select name="include_in_programmes"
                        id="includeSelect"
                        class="form-control">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>

            <div class="mb-2" id="programBox" style="display:none;">
                <label>Select Programme(s)</label>
                <select name="program_ids[]"
                        class="form-control"
                        multiple>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}">
                            {{ $program->title }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">
                    Hold Ctrl / Cmd to select multiple
                </small>
            </div>

            <div class="mb-2">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="active">Active</option>
                    <option value="block">Blocked</option>
                </select>
            </div>

            <button class="btn btn-success">Save</button>
            <a href="{{ route('manage-gallery-categories.index') }}"
               class="btn btn-secondary">Back</a>
        </form>

    </div>
</div>
@endsection

@push('after-scripts')
<script>
function togglePrograms(){
    document.getElementById('programBox').style.display =
        document.getElementById('includeSelect').value == 1
            ? 'block' : 'none';
}

document.getElementById('includeSelect')
        .addEventListener('change', togglePrograms);

togglePrograms();

$('#categoryForm').submit(function(e){
    e.preventDefault();

    $.ajax({
        url:"{{ route('manage-gallery-categories.store') }}",
        method:'POST',
        data:$(this).serialize(),
        success:()=>window.location.href=
            "{{ route('manage-gallery-categories.index') }}"
    });
});
</script>
@endpush
