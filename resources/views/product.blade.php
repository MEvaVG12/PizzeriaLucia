@extends('layouts.master')

@section('content')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <link href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

    <div class="page-header">
      <h1>Productos</h1>
    </div>

    <div class="panel-body">
      <table class="table table-bordered" id='productTable'>
        <thead>
           <th>Nombre</th>
           <th>Precio</th>
        </thead>
        <tbody>
          @foreach($products as $product)
            <tr>
              <td>{{$product->name}}</td>
              <td>{{$product->price}}</td>
             </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <script src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"type="text/javascript"></script>

    <script>
      $('#productTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "api/products",
        "columns":[
          {data:'name'},
          {data:'price'},
        ]
      });
    </script>
@stop
