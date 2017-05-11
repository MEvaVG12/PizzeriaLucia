@extends('layouts.master')

@section('links')
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link href="{{ URL::asset('css/styles.css') }}" rel="stylesheet">
@stop

@section('content')
<div class="page-header">
    <h1>Consultar Promoción</h1>
</div>

<div id="errorDB" class="alert alert-danger hidden alert-dismissable">
    <strong>Peligro!</strong> La promoción no se eliminó correctamente.
</div>

<div id="success" class="alert alert-success hidden alert-dismissable">
    <strong>Éxito!</strong> La promoción se eliminó correctamente.
</div>

<div class="panel-body">
    <table class='table table-bordered' id='promotionTable'>
        <thead>
            <th class="text-center">Nombre</th>
            <th class="text-center">Precio</th>
            <th class="text-center">Editar</th>
            <th class="text-center">Borrar</th>
            <th class="text-center">Consultar</th>
        </thead>
    </table>
</div>
@stop

@section('javascript')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script>
  //Definición de rutas para ser usadas en js
  promotionDeleteRoute= "{{url('api/promotion/delete')}}";
  promotionIndexRoute= "{{url('api/promotion/index')}}";
  promotionEditRoute= "{{url('promotion/edit')}}";
  promotionShowRoute= "{{url('promotion/show')}}";
</script>
<script type="text/javascript" src="{{ URL::asset('js/promotion/promotionView.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/promotion/promotionTableIndexPromotionView.js') }}"></script>
@stop