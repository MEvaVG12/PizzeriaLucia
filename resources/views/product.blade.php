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
      </table>
    </div>

    <div class="page-body" id="ingredientes" style="display:none">
      <h2>Ingredientes</h2>
      <table class='table table-bordered' id='ingredientTable'>
        <thead>
           <th>Ingredientes</th>
        </thead>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
    <script>
    $(document).ready(function(){
      var tableP = $('#productTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "api/products",
        "deferRender": true,
        "columns":[
            {data:'name', name: 'products.name'},
            {data:'price', price: 'products.price'},
        ],
        "rowId": 'name',
        "select": true,
        "dom": 'Bfrtip',
      });

      $('#productTable tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {//cuando deselecciono
            $(this).removeClass('selected');
            document.getElementById('ingredientes').style.display = "none";
        }
        else {//cuando selecciono
            $id = tableP.row(this).data()['id'];
            tableP.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            if (tableP.row(this).data()['typeName'] == "Pizza") {
              console.log('Pizza');
              $('#ingredientTable').DataTable({
                "ajax": "api/ingredients/".$id,
                "columns":[
                  {data:'name', name: 'ingredients.name'},
                ],
              });
              document.getElementById('ingredientes').style.display = "block";
            } else {
              console.log('Empanada');
              document.getElementById('ingredientes').style.display = "none";
            }
        }
      } );

      /**$('#productTable tbody').on( 'click', 'tr', function () {
        $id = tableP.row(this).data()['id'];
        if (tableP.row(this).data()['typeName'] == "Pizza") {
          var table = $('#ingredientTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "api/ingredients/".$id,
            "columns":[
                {data:'name', name: 'ingredients.name'},
            ]
          });
          console.log('Pizza');
          document.getElementById('ingredientes').style.display = "block";
        } else {
          console.log('Empanada');
          document.getElementById('ingredientes').style.display = "none";
        }
      });**/
    });
    </script>
@stop
