@extends('layouts.app')

@section('title','Add FAQ')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5>Add FAQ</h5>

            <form id="faqForm">
                @csrf

                <div class="mb-3">
                    <label>Question *</label>
                    <input type="text" name="question" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Answer *</label>
                    <textarea name="answer" id="editor" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="active">Active</option>
                        <option value="block">Blocked</option>
                    </select>
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Save</button>
                    <a href="{{ route('manage-faqs.index') }}" class="btn btn-secondary">Cancel</a>
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

$('#faqForm').submit(function(e){
    e.preventDefault();

    // ✅ sync CKEditor
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }

    $.ajax({
        url:"{{ route('manage-faqs.store') }}",
        type:"POST",
        data: $(this).serialize(),
        success:()=>{
            Swal.fire('Saved','FAQ added','success')
            .then(()=>location.href="{{ route('manage-faqs.index') }}");
        }
    });
});
</script>
@endpush
