@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

@stop

@section('content')

    <style>
        .my-input-class {
            padding: 3px 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .my-confirm-class {
            padding: 3px 6px;
            font-size: 12px;
            color: white;
            text-align: center;
            vertical-align: middle;
            border-radius: 4px;
            background-color: #337ab7;
            text-decoration: none;
        }

        .my-cancel-class {
            padding: 3px 6px;
            font-size: 12px;
            color: white;
            text-align: center;
            vertical-align: middle;
            border-radius: 4px;
            background-color: #a94442;
            text-decoration: none;
        }

        .destroy-button{
            padding:5px 10px 5px 10px;
            border: 1px blue solid;
            background-color:lightgray;
        }

        td {
            text-align:center;
        }

    </style>


  <div class="page-header">
    <h1>Stocks</h1>
  </div>

  <!-- Table -->
  <form method="POST">
      <input type="hidden" name="_method" value="PUT">
      {{ csrf_field() }}
      <table class="table" id='stockTable' >
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
@stop

@section('javascript')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/dataTables.cellEdit.js') }}"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<srcipt src="//code.jquery.com/jquery-1.12.4.js"></script>
<script>
  $(document).ready(function(){

    var table = $('#stockTable').DataTable({

      "language": {
              "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
      },
      "processing": true,
      "serverSide": true,
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
          "type":"text",
          "options":null
        }
          ]
      });


  });

  function myCallbackFunction(updatedCell, updatedRow, oldValue) {
    var id = updatedRow.data().id;
    var amount = updatedRow.data().amount;
    var route = "{{url('api/stock/update')}}/";
    var token = $(" [name=_token]").val();

    $.ajax({
      url: "{{ url('api/stock/update') }}" + '/' + id + '',
      type: 'PUT',
      data: {"amount": amount, '_token': token},
        success: function (data) {
          toastr.success('La cantidad de stock se cambió exitosamente.', 'Guardado!', {timeOut: 5000});
          $('#stockTable').DataTable().ajax.reload();
        },
        error : function(xhr, status) {
          toastr.error('En el campo cantidad debe ingresar un número', 'Error!')
        }
    });
  }
</script>
@stop
