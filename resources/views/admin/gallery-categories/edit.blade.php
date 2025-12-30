@extends('layouts.app')
@section('title','Edit Gallery Category')

@section('content')
<div class="card">
    <div class="card-body">

        <form id="categoryForm">
            @csrf
            @method('PUT')

            <div class="mb-2">
                <label>Category Title</label>
                <input type="text"
                       name="title"
                       value="{{ $category->title }}"
                       class="form-control"
                       required>
            </div>

            <div class="mb-2">
                <label>Include In Programmes</label>
                <select name="include_in_programmes"
                        id="includeSelect"
                        class="form-control">
                    <option value="0"
                        {{ !$category->include_in_programmes ? 'selected' : '' }}>
                        No
                    </option>
                    <option value="1"
                        {{ $category->include_in_programmes ? 'selected' : '' }}>
                        Yes
                    </option>
                </select>
            </div>

            <div class="mb-2" id="programBox">
                <label>Select Programme(s)</label>
                <select name="program_ids[]"
                        class="form-control"
                        multiple>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}"
                            {{ $category->programmes->contains($program->id) ? 'selected' : '' }}>
                            {{ $program->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-2">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="active"
                        {{ $category->status=='active'?'selected':'' }}>
                        Active
                    </option>
                    <option value="block"
                        {{ $category->status=='block'?'selected':'' }}>
                        Blocked
                    </option>
                </select>
            </div>

            <button class="btn btn-success">Update</button>
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
        url:"{{ route('manage-gallery-categories.update',$category->id) }}",
        method:'POST',
        data:$(this).serialize(),
        success:()=>window.location.href=
            "{{ route('manage-gallery-categories.index') }}"
    });
});
</script>
@endpush
