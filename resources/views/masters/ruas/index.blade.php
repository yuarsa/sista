@extends('layouts.admin')
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Data Ruas</h3>
        <div class="box-tools pull-right">
            @permission('create-master-ruas')
                <a href="{{ url('master/ruas/create') }}" class="btn btn-sm btn-primary" title="Add New"><i class="fa fa-plus"></i> Tambah</a>
            @endpermission
        </div>
    </div>
    <div class="box-body table-responsive">
        <table id="table-data2" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Region</th>
                    <th>Keterangan</th>
                    <th>Dibuat</th>
                    <th>Dirubah</th>
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
                ajax : '{{ url('master/ruas_data') }}',
                columns: [
                    { data: 'ruas_code', name: 'ruas_code' },
                    { data: 'ruas_name', name: 'ruas_name' },
                    { data: 'region', name: 'region' },
                    { data: 'ruas_desc', name: 'ruas_desc' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endpush
