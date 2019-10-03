@extends('layouts.admin')
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Tambah Data</h3>
    </div>
    {!! Form::open(['url' => 'master/regions', 'role' => 'form', 'class' => 'form-horizontal']) !!}
    <div class="box-body">
        {{ Form::inputText('reg_code', 'Kode', 'code', 'reg_code', ['required' => 'required', 'minlength' => 3, 'maxlength' => 3]) }}
        {{ Form::inputText('reg_name', 'Nama', 'id-card-o', 'reg_name', ['required' => 'required']) }}
        {{ Form::inputTextarea('reg_desc', 'Keterangan', 'reg_desc', ['rows' => 3]) }}
    </div>
    <div class="box-footer">
        {{ Form::btnSave('master/regions') }}
    </div>
    {!! Form::close() !!}
</div>
@endsection