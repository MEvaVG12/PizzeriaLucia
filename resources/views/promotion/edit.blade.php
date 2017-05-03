@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
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
        <input required  class='form-control' onkeypress="return isNumber(event)" placeholder='Ingrese precio de la promoción' type='text' name='price' id='price' value= {{ $promotion->price }}>
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
                        <th></th>
                      </thead>
                    </table>
                </form>
              </div>
      </div>

    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-right">
      <button class="btn btn-primary"  onclick='save()'>Guardar</button>
    </div>


@stop

@section('javascript')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/dataTables.cellEdit.js') }}"></script>
<script>
  var promotion = {!! json_encode($promotion->toArray()) !!};
  var id = promotion.id;
  var productsUpdate = [];
  var productsDelete = [];

$(document).ready(function(){

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
              {"className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": "<button class='delete-modal btn btn-danger'>Delete</button>"
              },
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

        //Borra la fila en la table
        $('#productTable tbody').on( 'click', 'button', function () {
          if ( confirm( "¿Esta seguro que desea eliminar esta promoción?" ) ) {
            var data = tableP.row( $(this).parents('tr') ).data();
            var product = {id:data['id']};
            productsDelete.push(product);
            console.log(productsDelete);
            tableP.row( $(this).parents('tr') ).remove().draw();
          }
        } );

  
});

 function myCallbackFunction(updatedCell, updatedRow, oldValue) {
      var id = updatedRow.data().id;
      var amount = updatedRow.data().amount;
      var token = $(" [name=_token]").val();
      //TODO si existe cambiar, no agregar
      var product = {newValue:amount, id:id};
      productsUpdate.push(product);
      console.log(productsUpdate);
    }

  //Recoge los datos para ser guardados en la bd
   function save()
    {
      var errors = [];
      var table = $('#productTable').DataTable();
      var productsId = [];
      var amounts = [];
      var token = $(" [name=_token]").val();
      //Valida que todos los datos están ingresados
      if ($("#price").val() === '') {
        errors.push('El campo precio es requerido')
      }  

      if (errors.length>0) {
          $("#success").addClass('hidden');
          $("#errorDB").addClass('hidden');
          $('#listErrorMain').empty();
          $("#errorMain").removeClass('hidden');
          for (var i in errors) {
            $("#errorMain ul").append('<li><span>'+ errors[i] + '</span></li>');
          }
      } else {
        $("#errorMain").addClass('hidden');
        $("#errorDB").addClass('hidden');
        $("#success").addClass('hidden')
        /*table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
          var data = this.data();
          productsId.push(data[1]);
          amounts.push(parseInt(data[2]));
         } );*/
        $.ajax({
         url: "http://localhost:8080/pizzeria/public/api/promotion/update" + '/' + id + '',
          type: 'PUT',
          data: {"price": $("#price").val(),'_token': token, 'productsUpdate': productsUpdate, 'productsDelete': productsDelete},
            success: function (data) {
              $("#success").removeClass('hidden')
              //$('#promotionTable').DataTable().ajax.reload();
            },
            error : function(xhr, status) {
               $("#errorDB").removeClass('hidden')
            }
        });
        //limpia pantalla
        $("#name").val('');
        $("#price").val('');
        table.clear().draw();
      }
    }

</script>
@stop