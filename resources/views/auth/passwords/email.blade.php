@extends('layouts.masterLogin')

@section('title')
<title>Recuperar contraseña</title>
@stop

@section('content')
<div class='text-center'>
  <button type="submit" class="btn btn-default">
    Enviar
  </button>
  <a class="btn btn-link" href="{{ route('login') }}">Volver</a>
</div>
@stop
