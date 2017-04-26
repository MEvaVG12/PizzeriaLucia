@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<link href="{{ URL::asset('css/styleToastr.css') }}" rel="stylesheet">
@stop

@section('content')

  <div class="page-header">
    <h1>Stocks</h1>
  </div>

  <!-- Table -->
  <form method="POST">
      <input type="hidden" name="_method" value="PUT">
      {{ csrf_field() }}
      <table class="table table-bordered" id='stockTable' >
        <thead>
            <tr>
                <th class="text-center">Ingrediente</th>
                <th class="text-center">Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            </tr>
        </tbody>
      </table>
    </form>
@stop

@section('javascript')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/dataTables.cellEdit.js') }}"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<srcipt src="//code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/stockTableStockView.js') }}"></script>

@stop
