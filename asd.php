@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
@stop

@section('content')
    <div class="page-header">
      <h1>Mostrar Promoción</h1>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nombre:</strong>
                    {{ $promotion->name }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Precio:</strong>
                    {{ $promotionDetail[0]->price }}
                </div>
            </div>
      </div>


    <div class="panel-body">
      <table class='table table-bordered' id='promotionTable'>
        <thead>
           <th>Nombre</th>
           <th>Precio</th>
        </thead>

      </table>
    </div>

      @foreach ($promotionDetail as $product)

          <li>{{ $product->productName }}</li>

      @endforeach

@stop

@section('javascript')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script>$(document).ready(function(){


  var tableP = $('#promotionTable').DataTable({
    "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
    },
    "processing": true,
   // "serverSide": true,
    "ajax": "http://localhost:8080/pizzeria/public/api/promotion/index",
    "deferRender": true,
    "bAutoWidth" : false,
    "columns":[
        {sWidth : "50%", data:'name', name: 'promotions.name'},
        {sWidth : "50%", data:'price', name: 'promotions.price'},
    ],
    "rowId": 'name',
    "select": true,
    "dom": 'Bfrtip',
  });
  
});

</script>
@stop