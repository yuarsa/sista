@extends('layouts.admin')
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Ubah Data</h3>
    </div>
    {!! Form::model($data, ['method' => 'PATCH','url' => ['master/ruas', $data->ruas_id],'role' => 'form', 'class' => 'form-horizontal']) !!}
        <div class="box-body">
            {{ Form::inputText('ruas_code', 'Kode', 'code', 'reg_code', ['required' => 'required']) }}
            {{ Form::inputText('ruas_name', 'Nama', 'id-card-o', 'reg_name', ['required' => 'required']) }}
            {{ Form::inputSelect('ruas_region_id', 'Region', 'list', 'ruas_region_id', $region, ['required'=>'required']) }}
            {{ Form::inputTextarea('ruas_desc', 'Keterangan', 'ruas_desc', ['rows' => 3]) }}
        </div>
        @permission('update-master-ruas')
        <div class="box-footer">
            {{ Form::btnSave('master/ruas') }}
        </div>
        @endpermission
    {!! Form::close() !!}
</div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#ruas_region_id').select2({placeholder: "Region", width:'100%'});
        });
    </script>
@endpush