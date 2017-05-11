@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link href="{{ URL::asset('css/styles.css') }}" rel="stylesheet">
@stop

@section('content')
<div class="page-header">
    <h1>Mostrar Promoción</h1>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Nombre:</strong> {{ $promotion->name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Precio:</strong> ${{ $promotion->price }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Productos:</strong>
            <div class="panel-body">

                <form method="POST">
                    {{ csrf_field() }}
                    <table class='table table-bordered' id='productTable'>
                        <thead>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Cantidad</th>
                        </thead>
                    </table>
                </form>

            </div>
        </div>
    </div>
</div>
@stop

@section('javascript')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script>
//Definición de variables
var promotion = {!! json_encode($promotion->toArray()) !!};

//Definición de rutas para ser usadas en js
promotionDetailsRoute = "{{url('api/promotion/index/promotionDetails')}}";
</script>
<script type="text/javascript" src="{{ URL::asset('js/promotion/promotionTableShowPromotionView.js') }}"></script>
@stop