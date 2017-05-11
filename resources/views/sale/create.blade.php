@extends('layouts.master')

@section('links')
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<!--formden.js communicates with FormDen server to validate fields and submit via AJAX -->
<script type="text/javascript" src="https://formden.com/static/cdn/formden.js"></script>

<!-- Special version of Bootstrap that is isolated to content wrapped in .bootstrap-iso -->
<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />

<!--Font Awesome (added because you use icons in your prepend/append)-->
<link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />

<!-- Inline CSS based on choices in "Settings" tab -->
<style>.bootstrap-iso .formden_header h2, .bootstrap-iso .formden_header p, .bootstrap-iso form{font-family: Arial, Helvetica, sans-serif; color: black}.bootstrap-iso form button, .bootstrap-iso form button:hover{color: white !important;} .asteriskField{color: red;}</style>



<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<link href="{{ URL::asset('css/styles.css') }}" rel="stylesheet">

@stop

@section('content')

  <div class="page-header">
    <h1>Venta</h1>
  </div>

  <div id="errorDB" class="alert alert-danger hidden alert-dismissable">
    <strong>Peligro!</strong> La venta no se actualizó correctamente.
  </div>

  <div id="errorMain" class="alert alert-danger hidden alert-dismissable">
    <strong>Error!</strong> Existen algunos problemas en las entradas.<b<br>
    <ul id="listErrorMain">

    </ul>
  </div>

  <div id="success" class="alert alert-success hidden alert-dismissable">
    <strong>Éxito!</strong> La venta se guardo correctamente.
  </div>

  <form method="POST">

    {{ csrf_field() }}

    <div class="panel-body">
      <div class='form-group'>
        <label for="title" class='control-label'>Cliente: </label>
        <input required class='form-control' placeholder='Ingrese nombre del cliente' type='text' name='name' id='name' >
      </div>
      <div class='form-group'>
        <label for="title" class='control-label'>Fecha de pedido: </label>
        <input required  readonly="readonly" class='form-control' type='text' name='date' id='date'>
      </div>
      <div class='form-group'>
        <label for="title" class='control-label'>Hora de pedido: </label>
        <input required  readonly="readonly" class='form-control' type='time' name='timeP' id='timeP'>
      </div>
      <div class='form-group'>
        <label for="title" class='control-label'>Fecha de entrega: </label>
           <div class="input-group">
            <div class="input-group-addon">
             <i class="fa fa-calendar">
             </i>
            </div>
            <input class="form-control" id="deliveryDate" name="deliveryDate" placeholder="MM/DD/YYYY" type="text"/>
           </div>
         </div>
      <div class='form-group'>
        <label for="title" class='control-label'>Hora de entrega: </label>
        <input required  class='form-control' type='time' name='time' id='time' autocomplete="on" >
      </div>

      <div class='form-group'>
        <label for="title" class='control-label'>Detalle Pedido: </label>
         <table class='table table-bordered' id='saleDetailTable'>
            <thead>
              <th scope="col" class="text-center">Producto</th>
              <th scope="col" class="text-center">IDProductos</th>
              <th scope="col" class="text-center">Cantidad</th>
              <th scope="col" class="text-center">Precio Unitario</th>
              <th scope="col" class="text-center">Subtotal</th>
              <th class="text-center">Tipo</th>
              <th class="text-center">Borrar</th>
           </thead>
         </table>
      </div>
      <div class='form-group'>
        <label for="title" class='control-label'>Total: </label>
        <input required  readonly="readonly" class='form-control' type='text' name='total' id='total' value="0">
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
                      <input required  class='form-control' onkeypress="return isNumber(event)" placeholder='Ingrese cantidad del producto' type='text' name='amountProduct' id='amountProduct' >
                    </div>
                    <div class='form-group'>
                      <p> Producto: </p>
                      <table class='table table-bordered' id='productTable'>
                        <thead>
                          <th class="text-center">Producto</th>
                          <th class="text-center">Id</th>
                          <th class="text-center">Precio</th>
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

      <!-- Button trigger modal -->
    <a href="#modelPromotion" role="button" class="btn btn-large btn-primary" data-toggle="modal">Agregar promoción</a>

    <!-- Modal -->
    <div id="modelPromotion" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Agregar promoción</h4>
                </div>
                <div id="errorModal" class="alert alert-danger hidden">
                    <strong>Error!</strong> Existen algunos problemas en las entradas.<b<br>
                    <ul id="listErrorModal">

                    </ul>
                </div>
                <div class="modal-body">
                    <div class='form-group'>
                      <p>Cantidad</p>
                      <input required  class='form-control' onkeypress="return isNumber(event)" placeholder='Ingrese cantidad del producto' type='text' name='amountPromotion' id='amountPromotion' >
                    </div>
                    <div class='form-group'>
                      <p> Promoción: </p>
                      <table class='table table-bordered' id='promotionTable'>
                        <thead>
                          <th class="text-center">Promoción</th>
                          <th class="text-center">Id</th>
                          <th class="text-center">Precio</th>
                        </thead>
                      </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" name='addPromotion' id='addPromotion' class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </div>
    </div>



    <div class="col-xs-12 col-sm-12 col-md-12 text-right">
      <button class="btn btn-primary"  onclick='save()'>Guardar</button>
    </div>

@stop

@section('javascript')

<!-- Extra JavaScript/CSS added manually in "Settings" tab -->
<!-- Include jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>


<script>
    $(document).ready(function(){
        var currentDate = new Date(); 
        var date_input=$('input[name="deliveryDate"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            container: container,
            todayHighlight: true,
            autoclose: true,
            dateFormat: 'dd/mm/yy',
        })
        $("#deliveryDate").datepicker("setDate",currentDate);
    })
</script>


<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script >

  //mostrar fecha actual
  var today = new Date();
  document.getElementById('date').value = today.getDate() + "/" + (today.getMonth() +1) + "/" + today.getFullYear();

  //mostrar hora actual
  h=""+today.getHours();
  if (h<10){
    h="0"+ h
  }
  m=""+today.getMinutes();
  if (m<10){
    m="0"+ m
  }
  document.getElementById('time').value = h + ":" + m;
  document.getElementById('timeP').value = h + ":" + m;
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
        {sWidth : "20%", data:'price', name: 'products.price'},
    ],
    "rowId": 'name',
    "select": true,
    "dom": 'Bfrtip',
  });

   var promotionTable = $('#promotionTable').DataTable({
    "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
    },
    "processing": true,
    //"serverSide": true,
    "ajax": "http://localhost:8080/pizzeria/public/api/promotion/index",
    "deferRender": true,
    "bAutoWidth" : false,
    "columns":[
        {sWidth : "80%", data:'name', name: 'promotion.name'},
        {visible: false, data:'id', name: 'promotion.id'},
        {sWidth : "20%", data:'price', name: 'promotion.price'},
    ],
    "rowId": 'name',
    "select": true,
    "dom": 'Bfrtip',
  });

  var promotionDetailTable = $('#saleDetailTable').DataTable({
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
      "targets": [ 6 ],
      "defaultContent": " <p data-placement='top' data-toggle='tooltip' title='Borrar'><button id='deleteBtn' class='btn btn-danger btn-xs' data-title='Delete' data-toggle='modal' data-target='#delete'><span class='glyphicon glyphicon-trash'></span></button></p>",
      "searchable": false
    },
    {
      "targets": [ 5 ],
      "visible": false,
      "searchable": false
    }],
    "deferRender": true,
    "bAutoWidth" : false,
    "rowId": 'name',
    "dom": 'Bfrtip',
  });
  var counter = 1; //contiene la cantidad de filas de la tabla
  //Borra la fila en la table
  $('#saleDetailTable tbody').on( 'click', 'button', function () {
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
      if ($("#amountProduct").val() === '') {
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
          var subtotal = rowData['price'] * $("#amountProduct").val();
          promotionDetailTable.row.add( [
              rowData['name'],
              rowData['id'],
              $("#amountProduct").val(),
              rowData['price'],
              subtotal, 'product'
          ] ).draw( false );

          counter++;
          //limpia modelo
          $("#amountProduct").val('');
          productTable.rows('tr.selected').deselect();
          $('#myModal').modal('toggle');
          $("#total").val( subtotal + parseFloat($("#total").val()) );
      }
  } );

          //Borra la fila en la table
        $('#promotionDetailTable tbody').on( 'click', 'button', function () {
          if ( confirm( "¿Esta seguro que desea eliminar?" ) ) {
            promotionDetailTable.push(product);
            tableP.row( $(this).parents('tr') ).remove().draw();
          }
        } );

  $('#addPromotion').on( 'click', function () {
    console.log('aa');
      var errors = [];
      var rowData = promotionTable.rows('.selected').data()[0];
      //Valida que todos los datos están ingresados
      if ($("#amountPromotion").val() === '') {
        errors.push('El campo cantidad es requerido')
      } if ( $('#promotionTable tbody tr.selected').length < 1) {
        errors.push('Seleccione una promoción en la tabla')
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
          var subtotal = rowData['price'] * $("#amountPromotion").val();
          promotionDetailTable.row.add( [
              rowData['name'],
              rowData['id'],
              $("#amountPromotion").val(),
              rowData['price'],
              subtotal , 'promotion'
          ] ).draw( false );

          counter++;
          //limpia modelo
          $("#amountPromotion").val('');
          promotionTable.rows('tr.selected').deselect();
          $('#modelPromotion').modal('toggle');
          $("#total").val( subtotal + parseFloat($("#total").val()) );
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
      var table = $('#saleDetailTable').DataTable();
      var products = [];
      var promotions = [];
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
          //console.log($("#date").val());
          if(data[5]=='product'){
            var product = {amount:data[2], id:data[1], price:data[3]};
            products.push(product);
          } else if (data[5]=='promotion'){
            var promotion = {amount:data[2], id:data[1], price:data[3]};
            promotions.push(promotion);
          }
         } );
      //  console.log($("#date").val() + ":" + $("#time").val()+':00');
        orderDateTime=$("#date").val() + ":" + $("#time").val()+':00';
        console.log(promotions);
        $.ajax({
          url: "http://localhost:8080/pizzeria/public/api/sale/create",
          type: 'POST',
          data: {"client": $("#name").val(), "orderDate": $("#date").val(), "orderTime": $("#timeP").val(), "deliveryDate": $("#deliveryDate").val(), "deliveryTime": $("#time").val(), "products": products, "promotions": promotions,'_token': token},
            success: function (data) {
              $("#success").removeClass('hidden')
            },
            error : function(xhr, status) {
               $("#errorDB").removeClass('hidden')
            }
        });
        //limpia pantalla
        $("#name").val('');
        $("#price").val('');
        $("#total").val('0');
        table.clear().draw();
      }
    }

</script>
@stop
