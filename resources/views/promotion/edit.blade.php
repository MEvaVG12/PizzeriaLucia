@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
<link href="{{ URL::asset('css/styleToastr.css') }}" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
@stop

@section('content')

   <div class="page-header">
      <h1>Mostrar Promoción</h1>
    </div>

    <div id="errorDB" class="alert alert-danger hidden alert-dismissable">
      <strong>Peligro!</strong> La promoción no se actualizó correctamente.
    </div>

    <div id="errorMain" class="alert alert-danger hidden alert-dismissable">
      <strong>Error!</strong> Existen algunos problemas en las entradas.<b<br>
      <ul id="listErrorMain">

      </ul>
    </div>

  <div id="success" class="alert alert-success hidden alert-dismissable">
    <strong>Éxito!</strong> La promoción se guardo correctamente.
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
                        <th class="text-center">Id</th>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Borrar</th>
                      </thead>
                    </table>
                </form>
              </div>
      </div>
    </div>


    <!-- Button trigger modal -->
    <a href="#myModal" role="button" class="btn btn-large btn-primary" data-toggle="modal">Agregar producto</a>

    <!-- Modal -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Agregar producto</h4>
                </div>
                <div id="errorModal" class="alert alert-danger hidden">
                    <strong>Error!</strong> Existen algunos problemas en las entradas.<b<br>
                    <ul id="listErrorModal">

                    </ul>
                </div>
                <div class="modal-body">
                    <div class='form-group'>
                      <p>Cantidad</p>
                      <input required  class='form-control' onkeypress="return isNumber(event)" placeholder='Ingrese cantidad del producto' type='text' name='amount' id='amount' >
                    </div>
                    <div class='form-group'>
                      <p> Producto: </p>
                      <table class='table table-bordered' id='productTableNew'>
                        <thead>
                          <th class="text-center">Producto</th>
                        </thead>
                      </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" name='addProduct' id='addProduct' class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-12 text-right">
      <button class="btn btn-primary"  onclick='save()'>Guardar</button>
    </div>
@stop

@section('javascript')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/dataTables.cellEdit.js') }}"></script>
<script >
//Comentario, el id en la tabla representa el id del producto si se agrega uno nuevo. Sino es el id del detalle de promoción que se había creado anteriormente
  var promotion = {!! json_encode($promotion->toArray()) !!};
  var id = promotion.id;
  var productsUpdate = [];
  var productsDelete = [];//
  var productsNew = [];//
  var productsExists = [] ;//

  $(document).ready(function(){

     var tableP = $('#productTable').DataTable({
    "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
    },
    "columnDefs": [
    {
      "targets": [ 0 ],
      "visible": false,
      "searchable": false
    },
    { "sWidth" : "8%",
      "targets": [ 3 ],
      "defaultContent": " <p data-placement='top' data-toggle='tooltip' title='Borrar'><button id='deleteBtn' class='btn btn-danger btn-xs' data-title='Delete' data-toggle='modal' data-target='#delete'><span class='glyphicon glyphicon-trash'></span></button></p>",
      "searchable": false
    }],
    "deferRender": true,
    "bAutoWidth" : false,
    "rowId": 'name',
    "dom": 'Bfrtip',
  });

    var token = $(" [name=_token]").val();
    $.ajax({
            type: "POST",
            data : {
                 '_token': token,
                  "id" :  id ,
              },
            url: "http://localhost:8080/pizzeria/public/api/promotion/index/promotionDetails",
    }).done(function(data){
            productsExists = data['data'];
            console.log(productsExists);
            //Agrega productos existentes a tabla 
            for (var key in productsExists) {
              console.log(productsExists[key]);
              tableP.row.add( [
                  productsExists[key]['id'],productsExists[key]['productName'], productsExists[key]['amount']
              ] ).draw( false );
            }
    });
      
    var productTable = $('#productTableNew').DataTable({
    "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
    },
    "processing": true,
    //"serverSide": true,
    "ajax": "http://localhost:8080/pizzeria/public/api/products",
    "deferRender": true,
    "bAutoWidth" : false,
    "columns":[
        {sWidth : "80%", data:'name', name: 'products.name'},
        {visible: false, data:'id', name: 'products.id'},
    ],
    "rowId": 'name',
    "select": true,
    "dom": 'Bfrtip',
  });
  

    tableP.MakeCellsEditable({
            "onUpdate": myCallbackFunction,
            "inputCss":'my-input-class',
            "columns": [2],
            "allowNulls": {
                "columns": [2],
                "errorClass": 'error'
            },
            "confirmationButton": {
                "confirmCss": 'my-confirm-class',
                "cancelCss": 'my-cancel-class'
            },
        "inputTypes": [
                {
            "column":2,
            "type":"number",
            "options":null
          }
            ]
        });

        //Borra la fila en la table
        $('#productTable tbody').on( 'click', 'button', function () {
          if ( confirm( "¿Esta seguro que desea eliminar esta promoción?" ) ) {
            var data = tableP.row( $(this).parents('tr') ).data();
            var product = {id:data[0]};
            productsDelete.push(product);
            tableP.row( $(this).parents('tr') ).remove().draw();
          }
        } );

  //Permite seleccionar solo una fila de la tabla
  $('#productTable tbody').on( 'click', 'tr', function () {
      if ( $(this).hasClass('selected') ) {
        $(this).removeClass('selected');
      } else {
        productTable.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
      }
  } );

  $('#addProduct').on( 'click', function () {
      var errors = [];
      var rowData = productTable.rows('.selected').data()[0];
      //Valida que todos los datos están ingresados
      if ($("#amount").val() === '') {
        errors.push('El campo cantidad es requerido')
      } if ( $('#productTableNew tbody tr.selected').length < 1) {
        errors.push('Seleccione un producto en la tabla')
      }
      console.log(errors);
      if (errors.length>0) {
          $('#listErrorModal').empty();
          $("#errorModal").removeClass('hidden');
          for (var i in errors) {
            $("#errorModal ul").append('<li><span>'+ errors[i] + '</span></li>');
          }
      } else {
          $("#errorModal").addClass('hidden');
          //Agrega en la tabla de detalle de promoción los datos seleccionados
          tableP.row.add( [
              rowData['id'],
              rowData['name'],
              $("#amount").val()
          ] ).draw( false );
          var product = {id:rowData['id'], amount:$("#amount").val()};
          productsNew.push(product);
          //limpia modelo
          $("#amount").val('');
          productTable.rows('tr.selected').deselect();
          $('#myModal').modal('toggle');
      }
  } );

});

  function myCallbackFunction(updatedCell, updatedRow, oldValue) {
      var id = updatedRow.data()[0];
      var amount = updatedRow.data()[2];
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
          data: {"price": $("#price").val(),'_token': token, 'productsUpdate': productsUpdate, 'productsDelete': productsDelete, 'productsNew' : productsNew},
            success: function (data) {
              $("#success").removeClass('hidden')
            },
            error : function(xhr, status) {
               $("#errorDB").removeClass('hidden')
            }
        });
      }
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

</script>
@stop
