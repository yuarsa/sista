@extends('layouts.admin')
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Ubah Data</h3>
    </div>
    {!! Form::model($data, ['method' => 'PATCH','url' => ['master/areas', $data->area_id],'role' => 'form', 'class' => 'form-horizontal']) !!}
        <div class="box-body">
            {{ Form::inputText('area_code', 'Kode', 'code', 'area_code', ['required' => 'required', 'minlength' => 4, 'maxlength' => 4]) }}
            {{ Form::inputText('area_name', 'Area', 'id-card-o', 'area_name', ['required' => 'required']) }}
            {{ Form::inputSelect('area_region_id', 'Region', 'list', 'area_region_id', $region, ['required'=>'required', 'onchange' => 'getRuasDropdown()']) }}
            {{ Form::inputSelect('area_ruas_id', 'Ruas', 'list', 'area_ruas_id', [], ['required'=>'required']) }}
            {{ Form::inputTextarea('area_desc', 'Keterangan', 'area_desc', ['rows' => 3]) }}
        </div>
        @permission('update-master-areas')
        <div class="box-footer">
            {{ Form::btnSave('master/areas') }}
        </div>
        @endpermission
    {!! Form::close() !!}
</div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#area_region_id').select2({placeholder: "Region", width:'100%'});
            $('#area_ruas_id').select2({placeholder: "Ruas", width:'100%'});

            $('#area_region_id').trigger('change');
        });

        function getRuasDropdown()
        {
            $.post('{{ url('master/areas/ruas-dropdown') }}', {id: $('#area_region_id').val(), _token: "{{ csrf_token() }}"}, function(e) {
                $('#area_ruas_id').html(e);
            });
        }
    </script>
@endpush
