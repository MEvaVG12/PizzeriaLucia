@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<link href="{{ URL::asset('css/styles.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/cellEdit.css') }}" rel="stylesheet">
@stop

@section('content')

<div class="page-header">
    <h1>Stocks</h1>
</div>

<div id="errorDB" class="alert alert-danger hidden alert-dismissable">
    <strong>Peligro!</strong> El stock no se actualizó correctamente.
</div>

<div id="success" class="alert alert-success hidden alert-dismissable">
    <strong>Éxito!</strong> El stock se guardó correctamente.
</div>

<!-- Table -->
<form method="POST">
    <input type="hidden" name="_method" value="PUT"> {{ csrf_field() }}
    <table class="table table-bordered" id='stockTable'>
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

<div class="col-xs-12 col-sm-12 col-md-12 text-right">
    <button class="btn btn-primary" onclick='update()'>Guardar</button>
</div>
@stop

@section('javascript')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/dataTables.cellEdit.js') }}"></script>
<srcipt src="//code.jquery.com/jquery-1.12.4.js"></script>
<script>
//Definición de rutas para ser usadas en js
stocksRoute= "{{url('api/stocks')}}";
stockUpdateRoute= "{{url('api/stock/update')}}";
</script>
<script type="text/javascript" src="{{ URL::asset('js/stock/stockView.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/stock/stockTableStockView.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/general.js') }}"></script>
@stop
