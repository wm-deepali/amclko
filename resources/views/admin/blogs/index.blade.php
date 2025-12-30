@extends('layouts.app')

@section('title','Blogs')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">
                <h5 class="card-title">Blogs</h5>
                <a href="{{ route('manage-blogs.create') }}" class="btn btn-primary">+ Add Blog</a>
            </div>

            <table class="table table-bordered" id="blogTable">
                <thead>
                    <tr>
                        <th>Thumbnail</th>
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
let table = $('#blogTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('manage-blogs.index') }}",
    columns: [
        { data: 'thumbnail', orderable:false },
        { data: 'title' },
        { data: 'status', orderable:false },
        { data: 'action', orderable:false }
    ]
});

/* DELETE */
$(document).on('click','.delete',function(){
    let id = $(this).data('id');

    Swal.fire({
        title:'Delete?',
        icon:'warning',
        showCancelButton:true
    }).then(res=>{
        if(res.isConfirmed){
            $.ajax({
                url:'/manage-blogs/'+id,
                type:'DELETE',
                data:{ _token:'{{ csrf_token() }}' },
                success:()=>table.ajax.reload()
            });
        }
    });
});
</script>
@endpush
