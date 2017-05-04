@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<link href="{{ URL::asset('css/styleToastr.css') }}" rel="stylesheet">
@stop

@section('content')

  <div class="page-header">
    <h1>Stocks</h1>
  </div>

  <div id="errorDB" class="alert alert-danger hidden alert-dismissable">
    <strong>Peligro!</strong> El stock no se actualizó correctamente.
  </div>

  <div id="success" class="alert alert-success hidden alert-dismissable">
    <strong>Éxito!</strong> El stock se guardo correctamente.
  </div>

  <!-- Table -->
  <form method="POST">
      <input type="hidden" name="_method" value="PUT">
      {{ csrf_field() }}
      <table class="table table-bordered" id='stockTable' >
        <thead>
            <tr>
                <th class="text-center">Ingrediente</th>
                <th class="text-center">Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            </tr>
        </tbody>
      </table>
    </form>

    <div class="col-xs-12 col-sm-12 col-md-12 text-right">
      <button class="btn btn-primary"  onclick='save()'>Guardar</button>
    </div>
@stop

@section('javascript')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/dataTables.cellEdit.js') }}"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<srcipt src="//code.jquery.com/jquery-1.12.4.js"></script>
<script>
  productsUpdate = [];

  $(document).ready(function(){

    var table = $('#stockTable').DataTable({

      "language": {
              "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
      },
      "processing": true,
      //"serverSide": true,
      "ajax": "api/stocks",
      "bAutoWidth" : false,
      "columns":[
        {sWidth : "50%", data:'name', name: 'ingredients.name'},
        {sWidth : "50%", data:'amount', name: 'stocks.amount'}
      ],
    });

    table.MakeCellsEditable({
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
    var amount = updatedRow.data().amount;
    var token = $(" [name=_token]").val();

    //TODO si existe cambiar, no agregar
    var product = {amount:amount, id:id};
    productsUpdate.push(product);
    console.log(updatedRow.row());
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
             

         for (var key in productsUpdate) {
          $.ajax({
            url: "api/stock/update/" + productsUpdate[key]['id']+ '',
            type: 'PUT',
            data: {"amount": productsUpdate   [key]['amount'], '_token': token},
            success: function (data) {
              $("#success").removeClass('hidden');
              $('#stockTable').DataTable().ajax.reload();
            },
            error : function(xhr, status) {
              $("#errorDB").removeClass('hidden')
            }
          });
         }
          }
        }
</script>

@stop
