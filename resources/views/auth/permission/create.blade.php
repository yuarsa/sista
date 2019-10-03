@extends('layouts.admin')
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Tambah Hak Akses/Permisi</h3>
    </div>
    {!! Form::open(['url' => 'auth/permissions', 'role' => 'form', 'class' => 'form-horizontal']) !!}
    <div class="box-body">
        {{ Form::inputText('name', 'Kode', 'code', 'name', ['required' => 'required']) }}
        {{ Form::inputText('display_name', 'Nama', 'id-card-o', 'display_name') }}
        {{ Form::inputTextarea('description', 'Keterangan', 'description', ['rows' => 3]) }}
    </div>
    <div class="box-footer">
        {{ Form::btnSave('master/permissions') }}
    </div>
    {!! Form::close() !!}
</div>
@endsection