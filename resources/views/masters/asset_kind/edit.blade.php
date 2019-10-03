@extends('layouts.admin')
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Ubah Data</h3>
    </div>
    {!! Form::model($data, ['method' => 'PATCH','url' => ['master/asset_kinds', $data->kind_id],'role' => 'form', 'class' => 'form-horizontal']) !!}
        <div class="box-body">
            {{ Form::inputText('kind_code', 'Kode', 'code', 'kind_code', ['required' => 'required', 'minlength' => 2, 'maxlength' => 2]) }}
            {{ Form::inputText('kind_name', 'Nama', 'id-card-o', 'kind_name', ['required' => 'required']) }}
            {{ Form::inputSelect('kind_asset_group_id', 'Kelompok', 'list', 'kind_asset_group_id', $kelompok, ['required'=>'required']) }}
            {{ Form::inputTextarea('kind_desc', 'Keterangan', 'kind_desc', ['rows' => 3]) }}
        </div>
        @permission('update-master-asset-kinds')
        <div class="box-footer">
            {{ Form::btnSave('master/asset_kinds') }}
        </div>
        @endpermission
    {!! Form::close() !!}
</div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#kind_asset_group_id').select2({placeholder: "Kelompok", width:'100%'});
        });
    </script>
@endpush
