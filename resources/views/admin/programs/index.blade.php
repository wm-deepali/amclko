@extends('layouts.app')
@section('title', 'Programs')

@section('content')
    <div class="card">
        <div class="card-body">

            <div class="d-flex mb-3">
                <select id="filter" class="form-control w-25">
                    <option value="all">All</option>
                    <option value="active">Active</option>
                    <option value="block">Blocked</option>
                </select>

                <a href="{{ route('manage-programs.create') }}" class="btn btn-primary ms-auto">+ Add Program</a>
            </div>

            <table class="table table-bordered" id="programTable">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"></th>
                        <th>Title</th>
                        <th>Thumbnail</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>

            <button id="bulkDelete" class="btn btn-danger mt-2">Bulk Delete</button>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script>
        let table = $('#programTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('manage-programs.index') }}",
                data: function (d) {
                    d.status = $('#filter').val();
                }
            },
            columns: [
                { data: 'checkbox', orderable: false },
                { data: 'title' },
                { data: 'thumbnail', orderable: false },
                { data: 'status', orderable: false },
                { data: 'action', orderable: false }
            ],
            order: [[1, 'asc']]
        });

        $('#filter').change(() => table.ajax.reload());
        $('#checkAll').click(e => $('.row_check').prop('checked', e.target.checked));

        $('#bulkDelete').click(() => {
            let ids = [];
            $('.row_check:checked').each((i, e) => ids.push(e.value));
            if (!ids.length) return alert('Select rows');

            $.post("{{ route('manage-programs.bulk') }}", {
                ids, action: 'delete', _token: "{{ csrf_token() }}"
            }, () => table.ajax.reload());
        });

        // single delete
        $(document).on('click', '.delete', function () {
            if (!confirm('Delete this program?')) return;
            $.ajax({
                url: "{{ url('manage-programs') }}/" + $(this).data('id'),
                type: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: () => table.ajax.reload(null, false)
            });
        });
    </script>
@endpush