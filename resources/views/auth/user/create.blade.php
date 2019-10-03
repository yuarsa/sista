@extends('layouts.admin')
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Tambah Pengguna</h3>
    </div>
    {!! Form::open(['url' => 'auth/users', 'role' => 'form', 'class' => 'form-horizontal']) !!}
    <div class="box-body">
        {{ Form::inputText('name', 'Nama Pengguna', 'id-card-o', 'name', ['required' => 'required']) }}
        {{ Form::inputText('username', 'Username', 'id-card-o', 'username') }}
        {{ Form::inputEmail('email', 'Email', 'envelope', 'email', ['required' => 'required']) }}
        {{ Form::inputPassword('password', 'Password', 'key', 'password', ['required' => 'required']) }}
        {{ Form::inputSelect('shift', 'Shift', 'list', 'shift', $shift) }}
        {{ Form::inputSelect('area_id', 'Rest Area', 'list', 'area_id', $area) }}
        @permission('read-auth-roles')
            {{ Form::inputCheckbox('roles', 'Role/Level', $roles, 'display_name') }}
        @endpermission
    </div>
    <div class="box-footer">
        {{ Form::btnSave('auth/roles') }}
    </div>
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
    <script>
        $(function() {
            $('#shift').select2({placeholder: "Shift", width:'100%'});
            $('#area_id').select2({placeholder: "Rest Area", width:'100%'});

            $('input[type=checkbox]').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
                increaseArea: '20%' // optional
            });
        });
    </script>
@endpush