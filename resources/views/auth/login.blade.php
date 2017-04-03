@extends('layouts.masterLogin')

@section('title')
<title>Iniciar Sesión</title>
@stop

@section('content')
<form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Correo electrónico">
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <input id="password" type="password" class="form-control" name="password" required placeholder="Contraseña">
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>

    <div class='text-center'>
        <div class='checkbox'>
            <label>
                <input type='checkbox' name="remember" {{ old('remember') ? 'checked' : '' }}>
                Recordarme en este equipo
            </label>
        </div>
        <button type="submit" class="btn btn-default">
            Entrar
        </button>
        <br>
        <a class="btn btn-link" href="{{ route('password.request') }}">¿Has olvidado tu contraseña?</a>
    </div>
</form>
@stop
