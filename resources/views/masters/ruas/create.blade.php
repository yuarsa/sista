@extends('layouts.admin')
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Tambah Data</h3>
    </div>
    {!! Form::open(['url' => 'master/ruas', 'role' => 'form', 'class' => 'form-horizontal']) !!}
    <div class="box-body">
        {{ Form::inputText('ruas_code', 'Kode', 'code', 'reg_code', ['required' => 'required']) }}
        {{ Form::inputText('ruas_name', 'Nama', 'id-card-o', 'reg_name', ['required' => 'required']) }}
        {{ Form::inputSelect('ruas_region_id', 'Region', 'list', 'ruas_region_id', $region, ['required'=>'required']) }}
        {{ Form::inputTextarea('ruas_desc', 'Keterangan', 'ruas_desc', ['rows' => 3]) }}
    </div>
    <div class="box-footer">
        {{ Form::btnSave('master/ruas') }}
    </div>
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