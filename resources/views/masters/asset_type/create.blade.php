@extends('layouts.admin')
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Tambah Data</h3>
    </div>
    {!! Form::open(['url' => 'master/asset_types', 'role' => 'form', 'class' => 'form-horizontal']) !!}
    <div class="box-body">
        {{ Form::inputText('type_code', 'Kode', 'code', 'type_code', ['required' => 'required', 'minlength' => 2, 'maxlength' => 2]) }}
        {{ Form::inputTextarea('type_desc', 'Keterangan', 'type_desc', ['rows' => 3]) }}
    </div>
    <div class="box-footer">
        {{ Form::btnSave('master/asset_types') }}
    </div>
    {!! Form::close() !!}
</div>
@endsection