@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
<link href="{{ URL::asset('css/styles.css') }}" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link href="{{ URL::asset('css/cellEdit.css') }}" rel="stylesheet">
@stop

@section('content')
<div class="page-header">
    <h1>Crear Promoción</h1>
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

<form method="POST">

    {{ csrf_field() }}

    <div class="panel-body">
        <div class='form-group'>
            <label for="title" class='control-label'>Nombre de la promoción: </label>
            <input required class='form-control' placeholder='Ingrese nombre de la promoción' type='text' name='name' id='name'>
        </div>
        <div class='form-group'>
            <label for="title" class='control-label'>Precio de la promoción: </label>
            <input required class='form-control' onkeypress="return isDecimal(event, this.form.price.value)" placeholder='Ingrese precio de la promoción' type='text' name='price' id='price'>
        </div>
        <div class='form-group'>
            <label for="title" class='control-label'>Productos: </label>
            <table class='table table-bordered' id='promotionDetailTable'>
                <thead>
                    <th class="text-center">Producto</th>
                    <th class="text-center">IDProductos</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Borrar</th>
                </thead>
            </table>
        </div>
    </div>
</form>



<!-- Button trigger modal add product-->
<a href="#modelAddProduct" role="button" class="btn btn-large btn-primary" data-toggle="modal">Agregar producto</a>

<!-- Modal add product -->
<div id="modelAddProduct" class="modal fade">
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
                    <table class='table table-bordered' id='productTable'>
                        <thead>
                            <th class="text-center">Producto</th>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id='closeProduct' data-dismiss="modal">Cerrar</button>
                <button type="button" name='addProduct' id='addProduct' class="btn btn-primary">Agregar</button>
            </div>
        </div>
    </div>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 text-right">
    <button class="btn btn-primary" onclick='save()'>Guardar</button>
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
  //Definición de rutas para ser usadas en js
  productsRoute = "{{url('api/products')}}";
  promotionCreateRoute = "{{url('api/promotion/create')}}";
</script>
<script type="text/javascript" src="{{ URL::asset('js/promotion/promotionView.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/promotion/promotionTableCreatePromotionView.js') }}"></script>
@stop
