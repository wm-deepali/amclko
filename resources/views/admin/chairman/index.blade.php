@extends('layouts.app')

@section('title','Chairman Message List')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <div class="d-flex mb-3">
                <select id="statusFilter" class="form-control w-25">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="block">Blocked</option>
                </select>

                <a href="{{ route('manage-chairmen.create') }}" class="btn btn-primary ms-auto">
                    + Add Chairman Message
                </a>
            </div>

            <table class="table table-bordered" id="chairmanTable">
                <thead>
                <tr>
                    <th width="40">
                        <input type="checkbox" id="checkAll">
                    </th>
                    <th>Title</th>
                    <th>Status</th>
                    <th width="120">Action</th>
                </tr>
                </thead>
            </table>

            <div class="mt-3">
                <button id="bulkDelete" class="btn btn-danger btn-sm">
                    Delete Selected
                </button>
            </div>

        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script>
let table = $('#chairmanTable').DataTable({
    processing:true,
    serverSide:true,
    ajax:{
        url:"{{ route('manage-chairmen.index') }}",
        data:d=>{
            d.status = $('#statusFilter').val();
        }
    },
    columns:[
        {data:'checkbox',orderable:false,searchable:false},
        {data:'title'},
        {data:'status',orderable:false},
        {data:'action',orderable:false,searchable:false},
    ]
});

$('#statusFilter').change(()=>table.ajax.reload());

$('#checkAll').on('click',function(){
    $('.row_check').prop('checked',this.checked);
});

$('#bulkDelete').click(function(){
    let ids = $('.row_check:checked').map(function(){
        return $(this).val();
    }).get();

    if(ids.length===0){
        Swal.fire('Warning','Select records first','warning');
        return;
    }

    Swal.fire({
        title:'Delete selected records?',
        icon:'warning',
        showCancelButton:true,
        confirmButtonText:'Delete'
    }).then(res=>{
        if(res.isConfirmed){
            $.post("{{ route('manage-chairmen.bulk') }}",{
                _token:"{{ csrf_token() }}",
                action:'delete',
                ids:ids
            },()=>table.ajax.reload());
        }
    });
});

$(document).on('click','.delete',function(){
    let id = $(this).data('id');

    Swal.fire({
        title:'Delete this record?',
        icon:'warning',
        showCancelButton:true,
        confirmButtonText:'Delete'
    }).then(res=>{
        if(res.isConfirmed){
            $.ajax({
                url:"{{ url('/manage-chairmen') }}/"+id,
                type:'DELETE',
                data:{_token:"{{ csrf_token() }}"},
                success:()=>table.ajax.reload()
            });
        }
    });
});
</script>
@endpush
