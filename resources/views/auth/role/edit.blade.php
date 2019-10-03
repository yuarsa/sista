@extends('layouts.admin')
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Ubah Role/Level</h3>
    </div>
    {!! Form::model($role, ['method' => 'PATCH','url' => ['auth/roles', $role->id],'role' => 'form', 'class' => 'form-horizontal']) !!}
        <div class="box-body">
            {{ Form::inputText('name', 'Kode', 'code', 'name', ['required' => 'required']) }}
            {{ Form::inputText('display_name', 'Nama', 'id-card-o', 'display_name') }}
            {{ Form::inputTextarea('description', 'Keterangan', 'description', ['rows' => 3]) }}
            <div id="role-permissions" class="col-md-12">
                <label for="permissions" class="control-label">Permisi/ Hak Akses</label>
                <br><br>
    
                <span class="permission-select-button" style="cursor:pointer">Pilih Semua</span> |
                <span class="permission-unselect-button" style="cursor:pointer">Hapus Semua</span>
    
                <div class="nav-tabs-custom" style="margin-top: 20px;">
                    <ul class="nav nav-tabs">
                        @foreach($names as $name)
                            <li {{ ($name == 'read') ? 'class=active' : '' }}><a href="#tab-{{ $name }}" data-toggle="tab" aria-expanded="false">{{ ucwords($name) }}</a></li>
                        @endforeach
                    </ul>
    
                    <div class="tab-content">
                        @foreach ($permissions as $code => $code_permissions)
                            <div class="tab-pane in {{ ($code == 'read') ? 'active' : '' }}" id="tab-{{ $code }}">
                                <div class="permission-button-group">
                                    <span class="permission-select-button" style="cursor:pointer">Pilih Semua</span> |
                                    <span class="permission-unselect-button" style="cursor:pointer">Hapus Semua</span>
                                </div>
                                <div class="form-group col-md-12 {{ $errors->has('permissions') ? 'has-error' : '' }}">
                                    <label class="input-checkbox"></label>
                                    <br>
                                    @foreach($code_permissions as $item)
                                        <div class="col-md-3">
                                            <label class="input-checkbox">{{ Form::checkbox('permissions' . '[]', $item->id) }} &nbsp;{{ $item->display_name }}</label>
                                        </div>
                                    @endforeach
                                    {!! $errors->first('permissions', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>            
        </div>
        @permission('update-auth-roles')
        <div class="box-footer">
            {{ Form::btnSave('auth/roles') }}
        </div>
        @endpermission
    {!! Form::close() !!}
</div>
@endsection
@push('js')
    <script src="{{ asset('js/plugin/icheck.min.js') }}"></script>
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('css/iCheck/square/green.css') }}">
@endpush
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('input[type=checkbox]').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
                increaseArea: '10%' // optional
            });

            $('.permission-select-button').on('click', function (event) {
                $(this).parent().parent().find('input[type=checkbox]').iCheck('check');
            });

            $('.permission-unselect-button').on('click', function (event) {
                $(this).parent().parent().find('input[type=checkbox]').iCheck('uncheck');
            });
        });
    </script>
@endpush