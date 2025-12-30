@extends('layouts.app')

@section('title','Edit FAQ')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5>Edit FAQ</h5>

            <form id="faqEditForm">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Question *</label>
                    <input type="text" name="question" class="form-control"
                           value="{{ $faq->question }}" required>
                </div>

                <div class="mb-3">
                    <label>Answer *</label>
                    <textarea name="answer" id="editor" class="form-control">
                        {!! $faq->answer !!}
                    </textarea>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $faq->status=='active'?'selected':'' }}>Active</option>
                        <option value="block" {{ $faq->status=='block'?'selected':'' }}>Blocked</option>
                    </select>
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Update</button>
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

$('#faqEditForm').submit(function(e){
    e.preventDefault();

    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }

    $.ajax({
        url:"{{ route('manage-faqs.update',$faq->id) }}",
        type:"POST",
        data: $(this).serialize(),
        success:()=>{
            Swal.fire('Updated','FAQ updated','success')
            .then(()=>location.href="{{ route('manage-faqs.index') }}");
        }
    });
});
</script>
@endpush
