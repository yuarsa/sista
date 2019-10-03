@extends('layouts.admin')
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Ubah Data</h3>
    </div>
    {!! Form::model($data, ['method' => 'PATCH','url' => ['master/assets', $data->asset_id], 'role' => 'form', 'class' => 'form-horizontal']) !!}
        <div class="box-body">
            <div class="form-group">
                <label for="asset_code" class="control-label col-sm-2">Kode</label>
                <div class="col-md-10 col-sm-10 col-xs-12">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-code"></i></div>
                        <input class="form-control" placeholder="Generate Otomatis" disabled>
                    </div>
                </div>
            </div>
            {{ Form::inputSelect('asset_region_id', 'Region', 'list', 'asset_region_id', $region, ['required'=>'required']) }}
            {{ Form::inputSelect('asset_area_id', 'Rest Area', 'list', 'asset_area_id', $area, ['required'=>'required']) }}
            {{ Form::inputSelect('asset_point', 'Titik', 'list', 'asset_point', $point, ['required'=>'required']) }}
            {{ Form::inputSelect('asset_type_id', 'Jenis Aset', 'list', 'asset_type_id', $jenis, ['required'=>'required']) }}
            {{ Form::inputSelect('asset_asset_group_id', 'Kelompok', 'list', 'asset_asset_group_id', $kelompok, ['required'=>'required']) }}
            {{ Form::inputText('asset_name', 'Nama Aset', 'id-card-o', 'asset_name', ['required' => 'required']) }}
            {{ Form::inputText('asset_year', 'Tahun', 'calendar', 'asset_year', ['required' => 'required', 'minLength' => 4, 'maxLength' => 4]) }}
        </div>
        @permission('update-master-assets')
        <div class="box-footer">
            {{ Form::btnSave('master/assets') }}
        </div>
        @endpermission
    {!! Form::close() !!}
</div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#asset_region_id').select2({placeholder: "Region", width:'100%'});
            $('#asset_area_id').select2({placeholder: "Area", width:'100%'});
            $('#asset_point').select2({placeholder: "Titik", width:'100%'});
            $('#asset_type_id').select2({placeholder: "Jenis Aset", width:'100%'});
            $('#asset_asset_group_id').select2({placeholder: "Kelompok Aset", width:'100%'});

            $('#asset_region_id').on('change', function() {
                $.post('{{ url('master/assets/dropdown') }}', {id: $('#asset_region_id').val(), _token: "{{ csrf_token() }}"}, function(e) {
                    $('#asset_area_id').html(e);
                });
            });
        });
    </script>
@endpush
