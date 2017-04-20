@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link href="{{ URL::asset('css/styleToastr.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
@stop

@section('content')

    <div class="page-header">
      <h1>Productos</h1>
    </div>

    <div class="panel-body">
      <table class='table table-bordered' id='productTable'>
        <thead>
           <th>Nombre</th>
           <th>Precio</th>
        </thead>
      </table>
    </div>


   <form method="POST">
    {{ csrf_field() }}
    <div class="page-body" id="ingredientes" style="display:none">
      <h2>Ingredientes</h2>
      <table class='table table-bordered' id='ingredientTable'>
        <thead>
           <th>Ingredientes</th>
        </thead>
        </table>
    </div>
    </form>

@stop

@section('javascript')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/dataTables.cellEdit.js') }}"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <srcipt type="text/javascript" src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/productTableProductView.js') }}"></script>
@stop


