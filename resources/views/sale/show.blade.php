@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link href="{{ URL::asset('css/styles.css') }}" rel="stylesheet">
@stop

@section('content')
<div class="page-header">
    <h1>Mostrar Venta</h1>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Cliente:</strong> {{ $sale->client }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Fecha  y hora de pedido:</strong> {{ $sale->orderDateTime }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Fecha y hora de entrega:</strong> {{ $sale->deliveryDateTime }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Detalle de venta:</strong>
            <div class="panel-body">

                <form method="POST">
                    {{ csrf_field() }}
                    <table class='table table-bordered' id='saleTable'>
                        <thead>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Precio Unitario</th>
                            <th class="text-center">Subtotal</th>
                        </thead>
                    </table>
                </form>

            </div>
        </div>
    </div>
    <div class='form-group'>
        <label for="title" class='control-label'>Total: </label>
        <input required readonly="readonly" class='form-control' type='text' name='total' id='total' value="0">
    </div>
</div>
@stop

@section('javascript')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<srcipt src="//code.jquery.com/jquery-1.12.4.js"></script>
<script>
//Definición de variables
var sale = {!! json_encode($sale->toArray()) !!};

//Definición de rutas para ser usadas en js
saleDetailsRoute = "{{url('api/sale/saleDetails')}}";
</script>
<script type="text/javascript" src="{{ URL::asset('js/sale/saleTableShowSaleView.js') }}"></script>
@stop