@extends('layouts.app')

@section('title','Urdu Academy')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">
                <h5>Urdu Academy</h5>
                <a href="{{ route('manage-urdu-academy.create') }}" class="btn btn-primary">
                    + Add New
                </a>
            </div>

            <table class="table table-bordered" id="urduTable">
                <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th>Image</th>
                    <th>Title</th>
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
$(function () {
    let table = $('#urduTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('manage-urdu-academy.index') }}",
        columns: [
            {data:'checkbox', orderable:false, searchable:false},
            {data:'image', orderable:false, searchable:false},
            {data:'title'},
            {data:'status', orderable:false},
            {data:'action', orderable:false, searchable:false},
        ]
    });

    $(document).on('click','.delete',function(){
        let id = $(this).data('id');
        Swal.fire({
            title:'Are you sure?',
            icon:'warning',
            showCancelButton:true
        }).then((r)=>{
            if(r.isConfirmed){
                $.ajax({
                    url:`/manage-urdu-academy/${id}`,
                    type:'DELETE',
                    data:{ _token:"{{ csrf_token() }}" },
                    success:()=>table.ajax.reload()
                });
            }
        });
    });
});
</script>
@endpush
