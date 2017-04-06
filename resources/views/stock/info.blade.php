@extends('layouts.master')

@section('content')

  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">

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
                <th class="text-center">Id</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            </tr>
        </tbody>
      </table>
    </form>

  <!-- Javascripts -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>

  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>

  <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>

  <script type="text/javascript" src="{{ URL::asset('js/dataTables.cellEdit.js') }}"></script>


  <script>
    $(document).ready(function(){

      var table = $('#stockTable').DataTable({
        "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
        },
        "processing": true,
        "serverSide": true,
        "ajax": "api/stocks",
        "columns":[
          {data:'name', name: 'ingredients.name'},
          {data:'amount', name: 'stocks.amount'},
          {data:'id', name: 'stocks.id'},
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
            //console.log(data.sms);
          }
        });      
      }

  </script>




@stop
