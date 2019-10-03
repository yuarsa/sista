@extends('layouts.admin')
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Ubah Data</h3>
    </div>
    {!! Form::model($data, ['method' => 'PATCH','url' => ['master/asset_groups', $data->assetgrp_id],'role' => 'form', 'class' => 'form-horizontal']) !!}
        <div class="box-body">
            {{ Form::inputText('assetgrp_code', 'Kode', 'code', 'assetgrp_code') }}
            {{ Form::inputText('assetgrp_name', 'Nama', 'id-card-o', 'assetgrp_name', ['required' => 'required']) }}
            {{ Form::inputTextarea('asssetgrp_desc', 'Keterangan', 'asssetgrp_desc', ['rows' => 3]) }}
        </div>
        @permission('update-master-asset-groups')
        <div class="box-footer">
            {{ Form::btnSave('master/asset_groups') }}
        </div>
        @endpermission
    {!! Form::close() !!}
</div>   
@endsection