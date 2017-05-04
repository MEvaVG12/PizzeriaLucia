@extends('layouts.master')

@section('links')
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
<link href="{{ URL::asset('css/styleToastr.css') }}" rel="stylesheet">
@stop

@section('content')

    <div class="page-header">
      <h1>Productos</h1>
    </div>

    <div id="errorDB" class="alert alert-danger hidden alert-dismissable">
      <strong>Peligro!</strong> El producto no se actualizó correctamente.
    </div>

    <div id="success" class="alert alert-success hidden alert-dismissable">
      <strong>Éxito!</strong> El producto se guardo correctamente.
    </div>

    <div class="panel-body">
      <table class='table table-bordered' id='productTable'>
        <thead>
           <th class="text-center">Nombre</th>
           <th class="text-center">Precio</th>
           <th class="text-center">Ingredientes</th>
        </thead>
      </table>
    </div>


   <form method="POST">
    {{ csrf_field() }}
    <div class="page-body" id="ingredientes" style="display:none">
      <h2>Ingredientes</h2>
      <table class='table table-bordered' id='ingredientTable'>
        <thead>
           <th>Ingredientes</th>
        </thead>
        </table>
    </div>
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
    <srcipt type="text/javascript" src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script>
      productsUpdate = [];

    $(document).ready(function(){
      var tableP = $('#productTable').DataTable({
        "language": {"url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"},
        "processing": true,
       // "serverSide": true,
        "ajax": "api/products",
       // "ajax": "api/stocks",
        "bAutoWidth" : false,
        "deferRender": true,
        "columns":[
            {sWidth : "50%", data:'name', name: 'products.name'},
            {sWidth : "50%", data:'price', price: 'products.price'},
            {"className":      'details-control',
              "orderable":      false,
              "data":           null,
              "defaultContent": " <p data-placement='top' data-toggle='tooltip' title='Cosultar'><button id='ShowBtn' class='btn btn-info btn-xs' data-title='Show' data-toggle='modal' data-target='#show'><span class='glyphicon glyphicon-search'></span></button></p>"
            }
        ],
          /* "columns":[
        {sWidth : "50%", data:'name', name: 'ingredients.name'},
        {sWidth : "50%", data:'amount', name: 'stocks.amount'}
      ],*/
        "rowId": 'name',
        "select": true,
        "dom": 'Bfrtip',
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

      $('#productTable tbody').on( 'click', 'button', function () {
          var button = this;
          var id = tableP.row( $(this).parents('tr') ).data()['id'];
          window.location.href = "{{url('product/show')}}" + "/" + id;
      } );
    });

    function myCallbackFunction(updatedCell, updatedRow, oldValue) {
      var id = updatedRow.data().id;
      var price = updatedRow.data().price;
      var token = $(" [name=_token]").val();

      //TODO si existe cambiar, no agregar
      var product = {price:price, id:id};
      productsUpdate.push(product);
    }

    //Permite ingresar solo números
    function isNumber(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
      }
      return true;
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
            url: "api/product/update/" + productsUpdate[key]['id']+ '',
            type: 'PUT',
            data: {"price": productsUpdate[key]['price'], '_token': token},
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
