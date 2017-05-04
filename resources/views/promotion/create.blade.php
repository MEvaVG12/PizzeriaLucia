@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<link href="{{ URL::asset('css/dataTables.checkboxes.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/styleToastr.css') }}" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
@stop

@section('content')

  <div class="page-header">
    <h1>Crear Promoción</h1>
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

  <form method="POST">

    {{ csrf_field() }}

    <div class="panel-body">
      <div class='form-group'>
        <label for="title" class='control-label'>Nombre de la promoción: </label>
        <input required class='form-control' placeholder='Ingrese nombre de la promoción' type='text' name='name' id='name' >
      </div>
      <div class='form-group'>
        <label for="title" class='control-label'>Precio de la promoción: </label>
        <input required  class='form-control' onkeypress="return isNumber(event)" placeholder='Ingrese precio de la promoción' type='text' name='price' id='price' >
      </div>
      <div class='form-group'>
          <label for="title" class='control-label'>Productos: </label>
           <table class='table table-bordered' id='promotionDetailTable'>
              <thead>
                <th class="text-center">Producto</th>
                <th class="text-center">IDProductos</th>
                <th class="text-center">Cantidad</th>
                <th class="text-center">Borrar</th>
             </thead>
           </table>
      </div>
    </div>
  </form>



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
                      <table class='table table-bordered' id='productTable'>
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
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/dataTables.checkboxes.min.js') }}"></script>
<script >
  $(document).ready(function(){

    var productTable = $('#productTable').DataTable({
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
  var promotionDetailTable = $('#promotionDetailTable').DataTable({
    "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
    },
    "columnDefs": [
    {
      "targets": [ 1 ],
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
  var counter = 1; //contiene la cantidad de filas de la tabla
  //Borra la fila en la table
  $('#promotionDetailTable tbody').on( 'click', 'button', function () {
     promotionDetailTable.row( $(this).parents('tr') ).remove().draw();
      counter--;
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
      } if ( $('#productTable tbody tr.selected').length < 1) {
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
          promotionDetailTable.row.add( [
              rowData['name'],
              rowData['id'],
              $("#amount").val()
          ] ).draw( false );

          counter++;
          //limpia modelo
          $("#amount").val('');
          productTable.rows('tr.selected').deselect();
          $('#myModal').modal('toggle');
      }
  } );

});
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
      var table = $('#promotionDetailTable').DataTable();
      var productsId = [];
      var amounts = [];
      var token = $(" [name=_token]").val();
      //Valida que todos los datos están ingresados
      if ($("#name").val() === '') {
        errors.push('El campo nombre es requerido')
      }  if ($("#price").val() === '') {
        errors.push('El campo precio es requerido')
      }  if (table.rows().data().length<1) {
        errors.push('Ingrese al menos un producto en la tabla')
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
        table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
          var data = this.data();
          productsId.push(data[1]);
          amounts.push(parseInt(data[2]));
         } );
        $.ajax({
          url: "http://localhost:8080/pizzeria/public/api/promotion/create",
          type: 'POST',
          data: {"amounts": amounts, "productsId": productsId, "name": $("#name").val(), "price": $("#price").val(),'_token': token},
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
