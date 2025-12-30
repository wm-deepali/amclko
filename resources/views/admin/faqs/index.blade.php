@extends('layouts.app')

@section('title','Manage FAQs')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">
                <h5>FAQs</h5>
                <a href="{{ route('manage-faqs.create') }}" class="btn btn-primary">Add FAQ</a>
            </div>

            <table class="table table-bordered" id="faqTable">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script>
$('#faqTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('manage-faqs.index') }}",
    columns: [
        { data: 'question' },
        { data: 'status', orderable:false, searchable:false },
        { data: 'action', orderable:false, searchable:false }
    ]
});

// delete
$(document).on('click','.delete',function(){
    let id = $(this).data('id');

    Swal.fire({
        title: 'Delete?',
        text: 'This FAQ will be deleted',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
    }).then((r) => {
        if (r.isConfirmed) {
            $.ajax({
                url: `/manage-faqs/${id}`,
                type: 'DELETE',
                data: {_token:"{{ csrf_token() }}"},
                success: () => $('#faqTable').DataTable().ajax.reload()
            });
        }
    });
});
</script>
@endpush
