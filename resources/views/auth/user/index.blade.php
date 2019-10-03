@extends('layouts.admin')
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Data Pengguna</h3>
        <div class="box-tools pull-right">
            @permission('create-auth-users')
                <a href="{{ url('auth/users/create') }}" class="btn btn-sm btn-primary" title="Add New"><i class="fa fa-plus"></i> Tambah</a>
            @endpermission
        </div>
    </div>
    <div class="box-body table-responsive">
        <table id="table-data2" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Shift</th>
                    <th>Level</th>
                    <th style="width: 50px"></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#table-data2').DataTable({
                processing : true,
                serverSide : true,
                ajax : '{{ url('auth/users_data') }}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'username', name: 'username' },
                    { data: 'email', name: 'email' },
                    { data: 'shift', name: 'shift' },
                    { data: 'role', name: 'role' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endpush