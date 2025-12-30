@extends('layouts.app')

@section('title','Skill Development')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">
                <h5 class="card-title">Skill Development</h5>
                <a href="{{ route('manage-skill-dev.create') }}" class="btn btn-primary">
                    + Add
                </a>
            </div>

            <table class="table table-bordered" id="skillTable">
                <thead>
                <tr>
                    <th width="30"><input type="checkbox" id="checkAll"></th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th width="120">Action</th>
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

    let table = $('#skillTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('manage-skill-dev.index') }}",
        columns: [
            {data:'checkbox',orderable:false,searchable:false},
            {data:'image',orderable:false,searchable:false},
            {data:'title'},
            {data:'status',orderable:false},
            {data:'action',orderable:false,searchable:false}
        ]
    });

    // DELETE
    $(document).on('click','.delete',function(){
        let id = $(this).data('id');

        Swal.fire({
            title:'Delete?',
            text:'This record will be removed',
            icon:'warning',
            showCancelButton:true
        }).then(res=>{
            if(res.isConfirmed){
                $.ajax({
                    url:`/manage-skill-dev/${id}`,
                    type:'DELETE',
                    data:{_token:'{{ csrf_token() }}'},
                    success:()=>table.ajax.reload()
                });
            }
        });
    });

});
</script>
@endpush
