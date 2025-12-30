@extends('layouts.app')
@section('title','Gallery Categories')

@section('content')
<div class="card">
    <div class="card-body">

        <div class="d-flex mb-3">
            <a href="{{ route('manage-gallery-categories.create') }}"
               class="btn btn-primary ms-auto">
                + Add Category
            </a>
        </div>

        <table class="table table-bordered" id="categoryTable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Include in Programmes</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>

    </div>
</div>
@endsection

@push('after-scripts')
<script>
let table = $('#categoryTable').DataTable({
    processing:true,
    serverSide:true,
    ajax:"{{ route('manage-gallery-categories.index') }}",
    columns:[
        {data:'title'},
        {data:'include', orderable:false},
        {data:'status'},
        {data:'action', orderable:false}
    ]
});

$(document).on('click','.delete',function(){
    if(!confirm('Delete this category?')) return;

    $.ajax({
        url:"{{ url('manage-gallery-categories') }}/"+$(this).data('id'),
        type:'DELETE',
        data:{ _token:"{{ csrf_token() }}" },
        success:()=>table.ajax.reload(null,false)
    });
});
</script>
@endpush
