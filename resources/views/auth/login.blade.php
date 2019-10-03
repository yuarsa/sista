@extends('layouts.login')
@section('content')
<form action="{{ route('login') }}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <div class="login__block__body">
        <div class="form-group form-group--float form-group--centered{{ $errors->has('username') ? ' has-error' : '' }}">
            <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="NIK" autofocus required autocomplete="off">
            <i class="form-group__bar"></i>
            @if ($errors->has('username'))
                <span class="help-block">
                    <strong style="color:red">{{ $errors->first('username') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group form-group--float form-group--centered{{ $errors->has('password') ? ' has-error' : '' }}">
            <input type="password" name="password" class="form-control" required placeholder="Kata Sandi">
            <i class="form-group__bar"></i>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong style="color: red">{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <button type="submit" class="btn btn--icon login__block__btn waves-effect"><i class="zmdi zmdi-long-arrow-right"></i></button>
    </div>
</form>
@endsection
