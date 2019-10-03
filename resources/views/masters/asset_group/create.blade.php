@extends('layouts.admin')
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Tambah Data</h3>
    </div>
    {!! Form::open(['url' => 'master/asset_groups', 'role' => 'form', 'class' => 'form-horizontal']) !!}
    <div class="box-body">
        {{ Form::inputText('assetgrp_code', 'Kode', 'code', 'assetgrp_code') }}
        {{ Form::inputText('assetgrp_name', 'Nama', 'id-card-o', 'assetgrp_name', ['required' => 'required']) }}
        {{ Form::inputTextarea('asssetgrp_desc', 'Keterangan', 'asssetgrp_desc', ['rows' => 3]) }}
    </div>
    <div class="box-footer">
        {{ Form::btnSave('master/asset_groups') }}
    </div>
    {!! Form::close() !!}
</div>
@endsection