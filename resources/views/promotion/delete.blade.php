@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<link href="{{ URL::asset('css/styleToastr.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="page-header">
      <h1>Consultar Promoción</h1>
    </div>

    <div class="panel-body">
      <table class='table table-bordered' id='promotionTable'>
        <thead>
           <th>Nombre</th>
           <th>Precio</th>
           <th></th>
        </thead>
      </table>
    </div>

    <form method="POST">
      <input type="hidden" name="_method" value="PUT">
      {{ csrf_field() }}
      <div class="page-body" id="products" style="display:none">
        <h3>Promoción formada por:</h3>
        <table class='table table-bordered' id='productTable'>
          <thead>
            <th>Producto</th>
            <th>Cantidad</th>
          </thead>
        </table>
      </div>
    </form>
@stop

@section('javascript')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/promotionTableDeletePromotionView.js') }}"></script>
@stop
