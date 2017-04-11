@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
@stop

@section('content')
    <div class="page-header">
      <h1>Crear Promoción</h1>
    </div>

    <div class="panel-body">
      <h4>Seleccione los productos que formarán parte de la promoción:</h4>
      <table class='table table-bordered' id='productTable'>
        <thead>
           <th>Nombre</th>
        </thead>
      </table>
    </div>
@stop

@section('javascript')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script>
$(document).ready(function(){
  var tableP = $('#productTable').DataTable({
    "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
    },
    "processing": true,
    "serverSide": true,
    "ajax": "{{url('api/products')}}",
    "deferRender": true,
    "bAutoWidth" : false,
    "columns":[
        {sWidth : "50%", data:'name', name: 'products.name'},
    ],
    "rowId": 'name',
    "select": true,
    "dom": 'Bfrtip',
  });
  /**$('#productTable tbody').on( 'click', 'tr', function () {
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
            "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
            },
            "paging": false,
            "ajax": "api/ingredients/".$id,
            "bAutoWidth" : false,
            "columns":[
              {sWidth : "100%", data:'name', name: 'ingredients.name'},
            ],
          });
          document.getElementById('ingredientes').style.display = "block";
        } else {
          console.log('Empanada');
          document.getElementById('ingredientes').style.display = "none";
        }
    }
  } );**/
});
</script>
@stop
