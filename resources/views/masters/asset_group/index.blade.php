@extends('layouts.admin')
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Kelompok Aset</h3>
        <div class="box-tools pull-right">
            @permission('create-master-asset-groups')
                <a href="{{ url('master/asset_groups/create') }}" class="btn btn-sm btn-primary" title="Add New"><i class="fa fa-plus"></i> Tambah</a>
            @endpermission
        </div>
    </div>
    <div class="box-body table-responsive">
        <table id="table-data2" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
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
                ajax : '{{ url('master/asset_groups_data') }}',
                columns: [
                    { data: 'assetgrp_code', name: 'assetgrp_code' },
                    { data: 'assetgrp_name', name: 'assetgrp_name' },
                    { data: 'asssetgrp_desc', name: 'asssetgrp_desc' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endpush