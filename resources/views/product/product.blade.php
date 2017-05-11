@extends('layouts.master')

@section('links')
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
<link href="{{ URL::asset('css/styles.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/cellEdit.css') }}" rel="stylesheet">
@stop

@section('content')

<div class="page-header">
    <h1>Productos</h1>
</div>

<div id="errorDB" class="alert alert-danger hidden alert-dismissable">
    <strong>Peligro!</strong> El producto no se actualizó correctamente.
</div>

<div id="errorMain" class="alert alert-danger hidden alert-dismissable">
    <strong>Error!</strong> Existen algunos problemas en las entradas.
    <b<br>
        <ul id="listErrorMain">

        </ul>
</div>

<div id="success" class="alert alert-success hidden alert-dismissable">
    <strong>Éxito!</strong> El producto se guardó correctamente.
</div>

<div class="panel-body">
    <table class='table table-bordered' id='productTable'>
        <thead>
            <th class="text-center">Nombre</th>
            <th class="text-center">Precio</th>
            <th class="text-center">Ingredientes</th>
        </thead>
    </table>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 text-right">
    <button class="btn btn-primary" onclick='save()'>Guardar</button>
</div>
@stop

@section('javascript')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/dataTables.cellEdit.js') }}"></script>
<srcipt type="text/javascript" src="//code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/general.js') }}"></script>
<script>
//Definición de rutas para ser usadas en js
productShowRoute= "{{url('product/show')}}";
</script>
<script type="text/javascript" src="{{ URL::asset('js/product/productView.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/product/productTableProductView.js') }}"></script>
@stop
