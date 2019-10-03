@extends('layouts.admin')
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Tambah Data</h3>
    </div>
    {!! Form::open(['url' => 'master/matriks', 'role' => 'form', 'class' => 'form-horizontal']) !!}
    <div class="box-body">
        {{ Form::inputText('matrik_name', 'Nama Matriks', 'id-card-o', 'matrik_name', ['required' => 'required']) }}
        {{ Form::inputSelect('matrik_group_id', 'Kelompok Aset', 'list', 'matrik_group_id', $kelompok, ['required'=>'required']) }}
        {{ Form::inputSelect('matrik_fault_id', 'Kategori Kerusakan', 'list', 'matrik_fault_id', $fault, ['required'=>'required']) }}
        {{ Form::inputSelect('matrik_repair_id', 'Prioritas Perbaikan', 'list', 'matrik_repair_id', $repair, ['required'=>'required']) }}
        {{ Form::inputTextarea('matrik_desc', 'Keterangan', 'matrik_desc', ['rows' => 3]) }}
    </div>
    <div class="box-footer">
        {{ Form::btnSave('master/matriks') }}
    </div>
    {!! Form::close() !!}
</div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#matrik_group_id').select2({placeholder: "Kelompok Aset", width:'100%'});
            $('#matrik_fault_id').select2({placeholder: "Kategori Kerusakan", width:'100%'});
            $('#matrik_repair_id').select2({placeholder: "Prioritas Perbaikan", width:'100%'});
        });
    </script>
@endpush