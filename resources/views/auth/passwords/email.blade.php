@extends('layouts.masterLogin')

@section('title')
<title>Recuperar contraseña</title>
@stop

@section('content')
<form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Correo electrónico">
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>

    <div class='text-center'>
        <button type="submit" class="btn btn-default">
            Enviar
        </button>
        <a class="btn btn-link" href="{{ route('login') }}">Volver</a>
    </div>

</form>
@stop
