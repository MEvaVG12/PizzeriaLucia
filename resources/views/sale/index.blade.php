@extends('layouts.master')

@section('links')
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link href="{{ URL::asset('css/styles.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="page-header">
      <h1>Consultar Venta</h1>
    </div>

    <div id="errorDB" class="alert alert-danger hidden alert-dismissable">
    <strong>Peligro!</strong> La venta no se eliminó correctamente.
</div>

<div id="success" class="alert alert-success hidden alert-dismissable">
    <strong>Éxito!</strong> La venta se eliminó correctamente.
</div>

    <div class="panel-body">
      <table class='table table-bordered' id='saleTable'>
        <thead>
           <th class="text-center">Cliente</th>
           <th class="text-center">Fecha y hora de pedido</th>
           <th class="text-center">Fecha y hora de entrega</th>
           <th class="text-center">Editar</th>
           <th class="text-center">Borrar</th>
           <th class="text-center">Consultar</th>
        </thead>
      </table>
    </div>
@stop

@section('javascript')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<srcipt src="//code.jquery.com/jquery-1.12.4.js"></script>
<script>
//Definición de rutas para ser usadas en js
saleIndexRoute = "{{url('api/sale/index')}}";
saleEditRoute = "{{url('sale/edit')}}";
saleShowRoute = "{{url('sale/show')}}";
saleDeleteRoute = "{{url('api/sale/delete')}}";
</script>
<script type="text/javascript" src="{{ URL::asset('js/sale/saleView.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/sale/saleTableIndexSaleView.js') }}"></script>
@stop