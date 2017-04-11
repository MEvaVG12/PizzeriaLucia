@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
@stop

@section('content')
    <div class="page-header">
      <h1>Consultar Promoción</h1>
    </div>

    <div class="panel-body">
      <table class='table table-bordered' id='promotionTable'>
        <thead>
           <th>Nombre</th>
           <th>Precio</th>
        </thead>
      </table>
    </div>

    <form method="POST">
      {{ csrf_field() }}
      <div class="page-body" id="products" style="display:none">
        <h3>Promoción formada por:</h3>
        <table class='table table-bordered' id='productTable'>
          <thead>
            <th>Producto</th>
            <th>Cantidad</th>
          </thead>
        </table>
      </div>
    </form>
@stop

@section('javascript')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script>
$(document).ready(function(){
  var tableP = $('#promotionTable').DataTable({
    "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
    },
    "processing": true,
    "serverSide": true,
    "ajax": "{{url('api/promotion/index')}}",
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
  $('#promotionTable tbody').on( 'click', 'tr', function () {
    if ( $(this).hasClass('selected') ) {//cuando deselecciono
        $(this).removeClass('selected');
        document.getElementById('products').style.display = "none";
    }
    else {
      $id = tableP.row(this).data()['id'];
      tableP.$('tr.selected').removeClass('selected');
      $(this).addClass('selected');
      var token = $(" [name=_token]").val();
      $('#productTable').DataTable({
          "ajax": {
              "url": "{{url('api/promotion/index/promotionDetails')}}",
              "type": "post",
              "data" : {
                 '_token': token,
                  "id" :  $id ,
              }
          },
          "language": {
              "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
          },
          "columns":[
              {sWidth : "50%", data:'productName', name: 'products.name'},
              {sWidth : "50%", data:'amount', name: 'promotion_details.amount'},
          ],
      });
      console.log($id)
      document.getElementById('products').style.display = "block";
    }
  } );
});
</script>
@stop
