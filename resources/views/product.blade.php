@extends('layouts.master')

@section('content')
    <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">

    <div class="page-header">
      <h1>Productos</h1>
    </div>

    <div class="panel-body">
      <table class='table table-bordered' id='productTable'>
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

    <div class="page-body" id="ingredientes" style="display:none">
      <h2>Ingredientes</h2>
      <table class='table table-bordered' id='ingredientTable'>
        <thead>
           <th>Ingredientes</th>
        </thead>
        <tbody>
          @foreach($products as $product)
            <tr>
              <td>{{$product->name}}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <script src="http://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

    <script>
    $(document).ready(function(){
      var tableP = $('#productTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "api/products",
        "columns":[
            {data:'name'},
            {data:'price'},
        ]
      });

      $('#productTable tbody').on( 'click', 'tr', function () {
        $product = tableP.row(this).data();
        console.log($product);
        if (tableP.row(this).data()['product_type_id'] == 2) {
          console.log('Pizza');
        /**  var table = $('#ingredientTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "api/ingredients/".$product['id'],
            "columns":[
                {data:'name'},
            ]
          });**/
            var table = $('#ingredientTable').DataTable({
              "processing": true,
              "serverSide": true,
              "ajax": "api/products",
              "columns":[
                  {data:'name'},
              ]
            });
          document.getElementById('ingredientes').style.display = "block";
        } else {
          console.log('Empanada');
          document.getElementById('ingredientes').style.display = "none";
        }
      });
    });
    </script>
@stop
