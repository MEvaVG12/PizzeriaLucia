@extends('layouts.master')

@section('links')
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link href="{{ URL::asset('css/datapicker.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
<link href="{{ URL::asset('css/styles.css') }}" rel="stylesheet">
@stop

@section('content')
<div class="page-header">
    <h1>Venta</h1>
</div>

<div id="errorDB" class="alert alert-danger hidden alert-dismissable">
    <strong>Peligro!</strong> La venta no se actualizó correctamente.
</div>

<div id="errorMain" class="alert alert-danger hidden alert-dismissable">
    <strong>Error!</strong> Existen algunos problemas en las entradas.
    <b<br>
        <ul id="listErrorMain">

        </ul>
</div>

<div id="success" class="alert alert-success hidden alert-dismissable">
    <strong>Éxito!</strong> La venta se guardo correctamente.
</div>

<form method="POST">
    {{ csrf_field() }}
    <div class="panel-body">
        <div class='form-group'>
            <label for="title" class='control-label'>Cliente: </label>
            <input required class='form-control' placeholder='Ingrese nombre del cliente' type='text' name='name' id='name'>
        </div>
        <div class='form-group'>
            <label for="title" class='control-label'>Fecha de pedido: </label>
              <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input required readonly="readonly" class='form-control' type='text' name='date' id='date'>
              </div>
        </div>
        <div class='form-group'>
            <label for="title" class='control-label'>Hora de pedido: </label>
            <input required readonly="readonly" class='form-control' type='time' name='timeP' id='timeP'>
        </div>
        <div class='form-group'>
            <label for="title" class='control-label'>Fecha de entrega: </label>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <div class="input-append date" id="dp" >
                    <input class=" form-control span2" id="deliveryDate" type="text" readonly=""><span class="add-on"><i class="icon-th"></i></span>
                </div>
            </div>
        </div>
        <div class='form-group'>
            <label for="title" class='control-label'>Hora de entrega: </label>
            <input required class='form-control' type='time' name='time' id='time' autocomplete="on">
        </div>
        <div class='form-group'>
            <label for="title" class='control-label'>Detalle Pedido: </label>
            <table class='table table-bordered' id='saleDetailTable'>
                <thead>
                    <th scope="col" class="text-center">Producto</th>
                    <th scope="col" class="text-center">IDProductos</th>
                    <th scope="col" class="text-center">Cantidad</th>
                    <th scope="col" class="text-center">Precio Unitario</th>
                    <th scope="col" class="text-center">Subtotal</th>
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Borrar</th>
                </thead>
            </table>
        </div>
        <div class='form-group'>
            <label for="title" class='control-label'>Total: </label>
            <input required readonly="readonly" class='form-control' type='text' name='total' id='total' value="0">
        </div>
    </div>
</form>

<!-- Button trigger modal add product-->
<a href="#modalAddProduct" role="button" class="btn btn-large btn-primary" data-toggle="modal">Agregar producto</a>

<!-- Modal add product -->
<div id="modalAddProduct" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Agregar producto</h4>
            </div>
            <div id="errorModalProduct" class="alert alert-danger hidden">
                <strong>Error!</strong> Existen algunos problemas en las entradas.
                <b<br>
                    <ul id="listErrorModalProduct">

                    </ul>
            </div>
            <div class="modal-body">
                <div class='form-group'>
                    <p>Cantidad</p>
                    <input required class='form-control' onkeypress="return isNumber(event)" placeholder='Ingrese cantidad del producto' type='text' name='amountProduct' id='amountProduct'>
                </div>
                <div class='form-group'>
                    <p> Producto: </p>
                    <table class='table table-bordered' id='productTable'>
                        <thead>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Id</th>
                            <th class="text-center">Precio</th>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id='closeProduct'  data-dismiss="modal">Cerrar</button>
                <button type="button" name='addProduct' id='addProduct' class="btn btn-primary">Agregar</button>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal add promotion-->
<a href="#modalAddPromotion" role="button" class="btn btn-large btn-primary" data-toggle="modal">Agregar promoción</a>

<!-- Modal add promotion-->
<div id="modalAddPromotion" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Agregar promoción</h4>
            </div>
            <div id="errorModalPromotion" class="alert alert-danger hidden">
                <strong>Error!</strong> Existen algunos problemas en las entradas.
                <b<br>
                    <ul id="listErrorModalPromotion">

                    </ul>
            </div>
            <div class="modal-body">
                <div class='form-group'>
                    <p>Cantidad</p>
                    <input required class='form-control' onkeypress="return isNumber(event)" placeholder='Ingrese cantidad del producto' type='text' name='amountPromotion' id='amountPromotion'>
                </div>
                <div class='form-group'>
                    <p> Promoción: </p>
                    <table class='table table-bordered' id='promotionTable'>
                        <thead>
                            <th class="text-center">Promoción</th>
                            <th class="text-center">Id</th>
                            <th class="text-center">Precio</th>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id='closePromotion' data-dismiss="modal">Cerrar</button>
                <button type="button" name='addPromotion' id='addPromotion' class="btn btn-primary">Agregar</button>
            </div>
        </div>
    </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 text-right">
    <button class="btn btn-primary" onclick='save()'>Guardar</button>
</div>
@stop

@section('javascript')
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<srcipt src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/datapicker.js') }}"></script>
<script >
  //Definición de rutas para ser usadas en js
  productsRoute = "{{url('api/products')}}";
  promotionsRoute = "{{url('api/promotion/index')}}";
  saleCreateRoute = "{{url('api/sale/create')}}";
</script>
<script type="text/javascript" src="{{ URL::asset('js/bootstrap-datepicker.es.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/sale/dateAndTimeCreateView.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/sale/saleView.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/sale/saleTableCreateSaleView.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/general.js') }}"></script>
@stop
