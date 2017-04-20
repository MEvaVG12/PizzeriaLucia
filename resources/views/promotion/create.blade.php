@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
@stop

@section('content')
    <div class="page-header">
      <h1>Crear Promoción</h1>
    </div>

    <div class="panel-body">
      <div class='form-group'>
        <label class='control-label'>Ingrese nombre de la promoción: </label>
        <input class='form-control' placeholder='Nombre promoción' type='text'>
      </div>
      <div class='form-group'>
        <label class='control-label'>Seleccione los productos que formarán parte de la promoción: </label>
        <table class='table table-bordered' id='productTable'>
          <thead>
            <th>Nombre</th>
          </thead>
        </table>
      </div>
    </div>
@stop

@section('javascript')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/productTableCreatePromotionView.js') }}"></script>
@stop
