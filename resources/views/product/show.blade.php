@extends('layouts.master')

@section('links')
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
<link href="{{ URL::asset('css/styles.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/cellEdit.css') }}" rel="stylesheet">
@stop

@section('content')
<div class="page-header">
    <h1>Mostrar Producto</h1>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Nombre:</strong> {{ $product->productType['name'] }} {{ $product->name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Precio:</strong> ${{ $product->price }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group" id="ingredients" style="display:none">
            <strong>Ingredientes:</strong>
            <form method="POST">
                {{ csrf_field() }}
                <div class="page-body">
                    <h2>Ingredientes</h2>
                    <table class='table table-bordered' id='ingredientTable'>
                        <thead>
                            <th class="text-center">Ingredientes</th>
                        </thead>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('javascript')

<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script>
  //Definición de variables
  var product = {!! json_encode($product->toArray()) !!};
  var productType = {!! json_encode($product->productType->toArray()) !!};

  //Definición de rutas para ser usadas en js
  ingredientsRoute= "{{url('api/ingredients')}}";
</script>
<script type="text/javascript" src="{{ URL::asset('js/product/productShowView.js') }}"></script>
@stop