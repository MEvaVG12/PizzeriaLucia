@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
<link href="{{ URL::asset('css/styles.css') }}" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link href="{{ URL::asset('css/cellEdit.css') }}" rel="stylesheet">
@stop

@section('content')
<div class="page-header">
    <h1>Editar Promoción</h1>
</div>

<div id="errorDB" class="alert alert-danger hidden alert-dismissable">
    <strong>Peligro!</strong> La promoción no se actualizó correctamente.
</div>

<div id="errorMain" class="alert alert-danger hidden alert-dismissable">
    <strong>Error!</strong> Existen algunos problemas en las entradas.
    <b<br>
        <ul id="listErrorMain">

        </ul>
</div>

<div id="success" class="alert alert-success hidden alert-dismissable">
    <strong>Éxito!</strong> La promoción se guardo correctamente.
</div>

<div class="panel-body">
    <div class='form-group'>
        <label for="title" class='control-label'>Nombre de la promoción: </label> {{ $promotion->name }}
    </div>
    <div class='form-group'>
        <label for="title" class='control-label'>Precio de la promoción: </label>
        <input required class='form-control' onkeypress="return isDecimal(event, this.value)" placeholder='Ingrese precio de la promoción' type='text' name='price' id='price' value={{$promotion->price}}>
    </div>
    <div class="form-group">
        <strong>Productos:</strong>
        <div class="panel-body">
            <form method="POST">
                {{ csrf_field() }}
                <table class='table table-bordered' id='productTable'>
                    <thead>
                        <th class="text-center">Id</th>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Borrar</th>
                    </thead>
                </table>
            </form>
        </div>
    </div>
</div>

<!-- Button trigger modal add product -->
<a href="#modalAddProduct" role="button" class="btn btn-large btn-primary" data-toggle="modal">Agregar producto</a>

<!-- Modal add product -->
<div id="modalAddProduct" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Agregar producto</h4>
            </div>
            <div id="errorModal" class="alert alert-danger hidden">
                <strong>Error!</strong> Existen algunos problemas en las entradas.
                <b<br>
                    <ul id="listErrorModal">

                    </ul>
            </div>
            <div class="modal-body">
                <div class='form-group'>
                    <p>Cantidad</p>
                    <input required class='form-control' onkeypress="return isNumber(event)" placeholder='Ingrese cantidad del producto' type='text' name='amount' id='amount'>
                </div>
                <div class='form-group'>
                    <p> Producto: </p>
                    <table class='table table-bordered' id='productTableNew'>
                        <thead>
                            <th class="text-center">Producto</th>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id='closeProduct'>Cerrar</button>
                <button type="button" name='addProduct' id='addProduct' class="btn btn-primary">Agregar</button>
            </div>
        </div>
    </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 text-right">
    <button class="btn btn-primary" onclick='update()'>Guardar</button>
</div>
@stop

@section('javascript')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/dataTables.cellEdit.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/general.js') }}"></script>
<script >
  var promotion = {!! json_encode($promotion->toArray()) !!};

  //Definición de rutas para ser usadas en js
  promotionDetailsRoute = "{{url('api/promotion/index/promotionDetails')}}";
  productsRoute = "{{url('api/products')}}";
  promotionUpdateRoute = "{{url('api/promotion/update')}}";
</script>
<script type="text/javascript" src="{{ URL::asset('js/promotion/promotionView.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/promotion/promotionTableEditPromotionView.js') }}"></script>
@stop
