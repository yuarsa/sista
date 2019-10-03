@extends('layouts.admin')
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Ubah Data</h3>
    </div>
    {!! Form::model($data, ['method' => 'PATCH','url' => ['master/regions', $data->reg_id],'role' => 'form', 'class' => 'form-horizontal']) !!}
        <div class="box-body">
            {{ Form::inputText('reg_code', 'Kode', 'code', 'reg_code', ['required' => 'required', 'minlength' => 3, 'maxlength' => 3]) }}
            {{ Form::inputText('reg_name', 'Nama', 'id-card-o', 'reg_name', ['required' => 'required']) }}
            {{ Form::inputTextarea('reg_desc', 'Keterangan', 'reg_desc', ['rows' => 3]) }}
        </div>
        @permission('update-master-regions')
        <div class="box-footer">
            {{ Form::btnSave('master/regions') }}
        </div>
        @endpermission
    {!! Form::close() !!}
</div>
@endsection