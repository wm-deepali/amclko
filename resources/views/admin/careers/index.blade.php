@extends('layouts.app')
@section('title','Career Applications')

@section('content')
<div class="card">
    <div class="card-body">

        <table class="table table-bordered" id="careerTable">
            <thead>
            <tr>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Post Applied</th>
                <th>Resume</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>

    </div>
</div>
@endsection

@push('after-scripts')
<script>
let table = $('#careerTable').DataTable({
    processing:true,
    serverSide:true,
    ajax:"{{ route('manage-careers.index') }}",
    columns:[
        {data:'name'},
        {data:'mobile'},
        {data:'email'},
        {data:'post_applied'},
        {data:'resume',orderable:false},
        {data:'action',orderable:false}
    ]
});

$(document).on('click','.delete',function(){
    if(!confirm('Delete this application?')) return;

    $.ajax({
        url:"{{ url('manage-careers') }}/"+$(this).data('id'),
        type:'DELETE',
        data:{_token:"{{ csrf_token() }}"},
        success:()=>table.ajax.reload(null,false)
    });
});
</script>
@endpush
