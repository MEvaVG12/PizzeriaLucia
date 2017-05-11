@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
@stop

@section('content')
    <div class="page-header">
      <h1>Mostrar Promoción</h1>
    </div>

    <div class="panel-body">
      <div class='form-group'>
        <label for="title" class='control-label'>Nombre de la promoción: </label>
        {{ $promotion->name }}
      </div>
      <div class='form-group'>
        <label for="title" class='control-label'>Precio de la promoción: </label>
        <input required  class='form-control' onkeypress="return isNumber(event)" placeholder='Ingrese precio de la promoción' type='text' name='price' id='price' value= ${{ $promotion->price }}>
      </div>
    </div>
    <div class="form-group">
        <strong>Productos:</strong>
            <div class="panel-body">
              <form method="POST">
                {{ csrf_field() }}
                  <table class='table table-bordered' id='productTable'>
                    <thead>
                      <th>Producto</th>
                      <th>Cantidad</th>
                    </thead>
                  </table>
              </form>
            </div>
    </div>




@stop

@section('javascript')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script>$(document).ready(function(){

  var promotion = {!! json_encode($promotion->toArray()) !!};
  var id = promotion.id;

  var token = $(" [name=_token]").val();
    var tableP =  $('#productTable').DataTable({
          "ajax": {
              "url": "http://localhost:8080/pizzeria/public/api/promotion/index/promotionDetails",
              "type": "post",
              "data" : {
                 '_token': token,
                  "id" :  id ,
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

      tableP.MakeCellsEditable({
            "onUpdate": myCallbackFunction,
            "inputCss":'my-input-class',
            "columns": [1],
            "allowNulls": {
                "columns": [1],
                "errorClass": 'error'
            },
            "confirmationButton": {
                "confirmCss": 'my-confirm-class',
                "cancelCss": 'my-cancel-class'
            },
        "inputTypes": [
                {
            "column":1,
            "type":"number",
            "options":null
          }
            ]
        });
  
});

 function myCallbackFunction(updatedCell, updatedRow, oldValue) {
      var id = updatedRow.data().id;
      var price = updatedRow.data().price;
      var token = $(" [name=_token]").val();

      $("#errorDB").addClass('hidden');
      $("#success").addClass('hidden')

      console.log(price);

      $.ajax({
        url: "http://localhost:8080/pizzeria/public/api/product/update" + '/' + id + '',
        type: 'PUT',
        data: {"price": price, '_token': token},
          success: function (data) {
            $("#success").removeClass('hidden');
            $('#productTable').DataTable().ajax.reload();
          },
          error : function(xhr, status) {
            $("#errorDB").removeClass('hidden')
          }
      });
    }


</script>
@stop