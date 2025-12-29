@extends('layouts.app')

@section('title', 'Logo')

@section('content')
    <div class="card">
        <div class="card-body">

            <div class="d-flex mb-3">
                <select id="filter" class="form-control w-25">
                    <option value="all">All</option>
                    <option value="active">Active</option>
                    <option value="block">Blocked</option>
                </select>

                <a href="{{ route('logos.create') }}" class="btn btn-primary ms-auto">+ Add Logo</a>
            </div>

            <table class="table table-bordered" id="logoTable">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"></th>
                        <th>Title</th>
                        <th>Image</th>
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
        let table = $('#logoTable').DataTable({
            processing: true,   // ✅ REQUIRED
            serverSide: true,
            ajax: {
                url: "{{ route('logos.index') }}",
                data: function (d) {
                    d.status = $('#filter').val();
                }
            },
            columns: [
                { data: 'checkbox', orderable: false, searchable: false },
                { data: 'title' },
                { data: 'image', orderable: false, searchable: false },
                { data: 'status', orderable: false, searchable: false },
                { data: 'action', orderable: false, searchable: false }
            ],
            order: [[1, 'asc']],
            language: {
                processing: "Loading data..."
            }
        });


        $('#filter').change(() => table.ajax.reload());

        $('#checkAll').click(function () {
            $('.row_check').prop('checked', this.checked);
        });

        $('#bulkDelete').click(function () {
            let ids = [];
            $('.row_check:checked').each((i, e) => ids.push(e.value));
            if (!ids.length) return alert('Select rows');

            $.post("{{ route('logos.bulk') }}", {
                ids: ids,
                action: 'delete',
                _token: "{{ csrf_token() }}"
            }, () => table.ajax.reload());
        });

        $(document).on('click', '.delete', function () {
            if (!confirm('Delete?')) return;
            $.ajax({
                url: '/admin/logos/' + $(this).data('id'),
                type: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: () => table.ajax.reload()
            });
        });
    </script>
@endpush