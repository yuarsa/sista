@extends('layouts.admin')
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Ubah Data</h3>
    </div>
    {!! Form::model($data, ['method' => 'PATCH','url' => ['master/asset_types', $data->type_id],'role' => 'form', 'class' => 'form-horizontal']) !!}
        <div class="box-body">
            {{ Form::inputText('type_code', 'Kode', 'code', 'type_code', ['required' => 'required', 'minlength' => 2, 'maxlength' => 2]) }}
            {{ Form::inputTextarea('type_desc', 'Keterangan', 'type_desc', ['rows' => 3]) }}
        </div>
        @permission('update-master-asset-types')
        <div class="box-footer">
            {{ Form::btnSave('master/asset_types') }}
        </div>
        @endpermission
    {!! Form::close() !!}
</div>
@endsection