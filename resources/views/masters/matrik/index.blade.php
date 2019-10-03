@extends('layouts.admin')
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Data Matrik Kategori Kerusakan</h3>
        <div class="box-tools pull-right">
            @permission('create-master-matriks')
                <a href="{{ url('master/matriks/create') }}" class="btn btn-sm btn-primary" title="Add New"><i class="fa fa-plus"></i> Tambah</a>
            @endpermission
        </div>
    </div>
    <div class="box-body table-responsive">
        <table id="table-data2" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kelompok Aset</th>
                    <th>Keterangan</th>
                    <th>Kategori Kerusakan</th>
                    <th>Prioritas Perbaikan</th>
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
                ajax : '{{ url('master/matriks_data') }}',
                columns: [
                    { data: 'matrik_name', name: 'matrik_name' },
                    { data: 'kelompok', name: 'kelompok' },
                    { data: 'matrik_desc', name: 'matrik_desc' },
                    { data: 'fault', name: 'fault' },
                    { data: 'repair', name: 'repair' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endpush
