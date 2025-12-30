@extends('layouts.app')
@section('title', 'Annual Reports')

@section('content')
    <div class="card">
        <div class="card-body">

            <div class="d-flex mb-3">
                <select id="filter" class="form-control w-25">
                    <option value="all">All</option>
                    <option value="active">Active</option>
                    <option value="block">Blocked</option>
                </select>

                <a href="{{ route('manage-annual-reports.create') }}" class="btn btn-primary ms-auto">+ Add Report</a>
            </div>

            <table class="table table-bordered" id="reportTable">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"></th>
                        <th>Title</th>
                        <th>PDF</th>
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
        let table = $('#reportTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('manage-annual-reports.index') }}",
                data: function (d) {
                    d.status = $('#filter').val();
                }
            },
            columns: [
                { data: 'checkbox', orderable: false },
                { data: 'title' },
                { data: 'pdf', orderable: false },
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

            $.post("{{ route('manage-annual-reports.bulk') }}", {
                ids, action: 'delete', _token: "{{ csrf_token() }}"
            }, () => table.ajax.reload());
        });

        $(document).on('click', '.delete', function () {
            if (!confirm('Delete this report?')) return;

            $.ajax({
                url: "{{ url('manage-annual-reports') }}/" + $(this).data('id'),
                type: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: () => table.ajax.reload(null, false)
            });
        });
    </script>
@endpush