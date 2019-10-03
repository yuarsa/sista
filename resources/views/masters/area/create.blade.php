@extends('layouts.admin')
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Tambah Data</h3>
    </div>
    {!! Form::open(['url' => 'master/areas', 'role' => 'form', 'class' => 'form-horizontal']) !!}
    <div class="box-body">
        {{ Form::inputText('area_code', 'Kode', 'code', 'area_code', ['required' => 'required', 'minlength' => 4, 'maxlength' => 4]) }}
        {{ Form::inputText('area_name', 'Area', 'id-card-o', 'area_name', ['required' => 'required']) }}
        {{ Form::inputSelect('area_region_id', 'Region', 'list', 'area_region_id', $region, ['required'=>'required', 'onchange' => 'getRuasDropdown()']) }}
        {{ Form::inputSelect('area_ruas_id', 'Ruas', 'list', 'area_ruas_id', [], ['required'=>'required']) }}
        {{ Form::inputTextarea('area_desc', 'Keterangan', 'area_desc', ['rows' => 3]) }}
    </div>
    <div class="box-footer">
        {{ Form::btnSave('master/areas') }}
    </div>
    {!! Form::close() !!}
</div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#area_region_id').select2({placeholder: "Region", width:'100%'});
            $('#area_ruas_id').select2({placeholder: "Ruas", width:'100%'});
        });

        function getRuasDropdown()
        {
            $.post('{{ url('master/areas/ruas-dropdown') }}', {id: $('#area_region_id').val(), _token: "{{ csrf_token() }}"}, function(e) {
                $('#area_ruas_id').html(e);
            });
        }
    </script>
@endpush
