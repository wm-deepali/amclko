@extends('layouts.app')

@section('title','Edit Application Form')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5>Edit Application Form</h5>

            <form id="editForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Title *</label>
                    <input type="text" name="title"
                           value="{{ $application->title }}"
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <img src="{{ asset('storage/'.$application->image) }}"
                         height="120" class="border">
                </div>

                <div class="mb-3">
                    <label>Change Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $application->status=='active'?'selected':'' }}>
                            Active
                        </option>
                        <option value="block" {{ $application->status=='block'?'selected':'' }}>
                            Blocked
                        </option>
                    </select>
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('manage-applications.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script>
$('#editForm').submit(function(e){
    e.preventDefault();

    let fd = new FormData(this);

    $.ajax({
        url:"{{ route('manage-applications.update',$application->id) }}",
        type:"POST",
        data:fd,
        processData:false,
        contentType:false,
        success:()=>{
            Swal.fire('Success','Updated successfully','success')
                .then(()=>location.href="{{ route('manage-applications.index') }}");
        }
    });
});
</script>
@endpush
