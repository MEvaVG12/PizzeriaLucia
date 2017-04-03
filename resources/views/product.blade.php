@extends('layouts.master')

@section('content')
    <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">

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

     <script src="http://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

    <script>
    $(document).ready(function(){
      $('#productTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "api/products",
        "columns":[
          {data:'name'},
          {data:'price'},
        ]
      });
    });
    </script>
@stop
