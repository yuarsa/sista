@extends('layouts.admin')
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Ubah Hak Akses/Permisi</h3>
    </div>
    {!! Form::model($data, ['method' => 'PATCH','url' => ['auth/permissions', $data->id],'role' => 'form', 'class' => 'form-horizontal']) !!}
        <div class="box-body">
            {{ Form::inputText('name', 'Kode', 'code', 'name', ['required' => 'required']) }}
            {{ Form::inputText('display_name', 'Nama', 'id-card-o', 'display_name') }}
            {{ Form::inputTextarea('description', 'Keterangan', 'description', ['rows' => 3]) }}
        </div>
        @permission('update-auth-permissions')
        <div class="box-footer">
            {{ Form::btnSave('auth/permissions') }}
        </div>
        @endpermission
    {!! Form::close() !!}
</div>
@endsection