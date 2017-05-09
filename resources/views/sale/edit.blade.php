@extends('layouts.master')

@section('links')
<!--formden.js communicates with FormDen server to validate fields and submit via AJAX -->
<script type="text/javascript" src="https://formden.com/static/cdn/formden.js"></script>

<!-- Special version of Bootstrap that is isolated to content wrapped in .bootstrap-iso -->
<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />

<!--Font Awesome (added because you use icons in your prepend/append)-->
<link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />

<!-- Inline CSS based on choices in "Settings" tab -->
<style>.bootstrap-iso .formden_header h2, .bootstrap-iso .formden_header p, .bootstrap-iso form{font-family: Arial, Helvetica, sans-serif; color: black}.bootstrap-iso form button, .bootstrap-iso form button:hover{color: white !important;} .asteriskField{color: red;}</style>


<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
<link href="{{ URL::asset('css/styleToastr.css') }}" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
@stop

@section('content')

   <div class="page-header">
      <h1>Mostrar Venta</h1>
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

<div class="panel-body">
      <div class='form-group'>
        <label for="title" class='control-label'>Cliente: </label>
        {{ $sale->client }}
      </div>
      <div class='form-group'>
        <label for="title" class='control-label'>Fecha  y hora de pedido:</label>
        {{ $sale->orderDateTime }}
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
      <div class="form-group">
          <strong>Detalle de venta:</strong>
              <div class="panel-body">
                <form method="POST">
                  {{ csrf_field() }}
                    <table class='table table-bordered' id='productTable'>
                      <thead>
                        <th class="text-center">Id</th>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Precio Unitario</th>
                        <th class="text-center">Subtotal</th>
                        <th class="text-center">Borrar</th>
                      </thead>
                    </table>
                </form>
              </div>
      </div>
                <div class='form-group'>
            <label for="title" class='control-label'>Total: </label>
            <input required  readonly="readonly" class='form-control' type='text' name='total' id='total' value="0">
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
                          <th class="text-center">Precio</th>
                          <th class="text-center">Id</th>
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
                          <th class="text-center">Precio</th>
                          <th class="text-center">Id</th>
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

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/dataTables.cellEdit.js') }}"></script>
<script>
    $(document).ready(function(){
      console.log();

    })
</script>
<script >




//Comentario, el id en la tabla representa el id del producto si se agrega uno nuevo. Sino es el id del detalle de promoción que se había creado anteriormente
  var sale = {!! json_encode($sale->toArray()) !!};
  var id = sale.id;
  var deliveryDateTime = sale.deliveryDateTime;
  var productsUpdate = [];
  var promotionsUpdate = [];
  var productsDelete = [];//
  var promotionsDelete = [];//
  var productsNew = [];//
  var promotionsNew = [];//
  var productsExists = [] ;//

      var total = 0;

  



  $(document).ready(function(){
        var currentDate = new Date(deliveryDateTime);

  //mostrar hora actual
  h=""+currentDate.getHours();
  if (h<10){
    h="0"+ h
  }
  m=""+currentDate.getMinutes();
  if (m<10){
    m="0"+ m
  }

  document.getElementById('time').value = h + ":" + m;

 
        var date_input=$('input[name="deliveryDate"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            container: container,
            todayHighlight: true,
            autoclose: true,
            dateFormat: 'dd/mm/yy',
        })
        $("#deliveryDate").datepicker("setDate",currentDate);


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
      "targets": [ 5 ],
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
            url: "http://localhost:8080/pizzeria/public/api/sale/index/saleDetails",
    }).done(function(data){
            productsExists = data['data'];
            console.log(productsExists);
            //Agrega productos existentes a tabla 
            for (var key in productsExists) {
              console.log(productsExists[key]);
              var productColumn = '';
              if (productsExists[key]['productName'] != null){
                productColumn = productsExists[key]['typeProduct'] + ' ' + productsExists[key]['productName'];
              } else {
                productColumn = 'Promoción'  + ' ' + productsExists[key]['promotionName'];
              } 
              tableP.row.add( [productsExists[key]['id'],
                  productColumn,productsExists[key]['amount'], productsExists[key]['price'], productsExists[key]['price']*productsExists[key]['amount']
              ] ).draw( false );
              total = total +productsExists[key]['price']*productsExists[key]['amount'];
              $("#total").val(total);
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
        {
          "targets": 0,
          "data" : function(row, aoData, fnCallback) {
              return row['typeName'] + ' ' + row['name'];
        }},
        {data:'price', name: 'products.price'},
        {visible: false, data:'id', name: 'products.id'},
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
        { data:'name', name: 'promotion.name'},
        { data:'price', name: 'promotion.price'},
        {visible: false, data:'id', name: 'promotion.id'}
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
                          console.log(data);
            total= total - data[2]*data[3];
            $("#total").val(total);
            var product = {id:data[0]};
            //Ver este código se repite TODO
            if (data[1].substring(0, 9) == 'Promoción'){
              promotionsDelete.push(product);
            } else {
              productsDelete.push(product);
            }
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
              rowData['typeName'] + ' ' + rowData['name'],
              $("#amount").val(),
              rowData['price'], rowData['price']*parseFloat($("#amount").val())
          ] ).draw( false );
          var product = {id:rowData['id'], amount:$("#amount").val(),  price:rowData['price']};
          productsNew.push(product);
          total= total + rowData['price']*parseFloat($("#amount").val());
         $("#total").val(total);
          //limpia modelo
          $("#amount").val('');
          productTable.rows('tr.selected').deselect();
          $('#myModal').modal('toggle');
      }
  } );

  $('#addPromotion').on( 'click', function () {
      var errors = [];
      var rowData = promotionTable.rows('.selected').data()[0];
      //Valida que todos los datos están ingresados
      if ($("#amountPromotion").val() === '') {
        errors.push('El campo cantidad es requerido')
      } if ( $('#promotionTable tbody tr.selected').length < 1) {
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
              'Promoción' + ' ' + rowData['name'],
              $("#amountPromotion").val(),
              rowData['price'], rowData['price']*parseFloat($("#amountPromotion").val())
          ] ).draw( false );
          var product = {id:rowData['id'], amount:$("#amountPromotion").val(), price:rowData['price'] };
          promotionsNew.push(product);
          total= total + rowData['price']*parseFloat($("#amountPromotion").val());
         $("#total").val(total);
          //limpia modelo
          $("#amountPromotion").val('');
          productTable.rows('tr.selected').deselect();
          $('#modelPromotion').modal('toggle');
      }
  } );

});

  function myCallbackFunction(updatedCell, updatedRow, oldValue) {
      var id = updatedRow.data()[0];
      var amount = updatedRow.data()[2];
      var token = $(" [name=_token]").val();
      console.log(updatedRow);
      var data = updatedRow.data();
      data[4]=amount*updatedRow.data()[3];
      updatedRow.data(data).draw();  
     console.log('total');
      console.log(total);
      console.log(parseFloat((amount-oldValue)*updatedRow.data()[3]));
      total= total + (amount-oldValue)*updatedRow.data()[3];
      $("#total").val(total);
      //TODO si existe cambiar, no agregar
      var product = {newValue:amount, id:id};
      if (updatedRow.data()[1].substring(0, 9) == 'Promoción'){
        promotionsUpdate.push(product);
      } else {
        productsUpdate.push(product);
      }
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
         console.log( $("#deliveryDate").val());
        $.ajax({
         url: "http://localhost:8080/pizzeria/public/api/sale/update" + '/' + id + '',
          type: 'PUT',
          data: {"price": $("#price").val(),'_token': token, 'productsUpdate': productsUpdate, 'productsDelete': productsDelete, 'productsNew' : productsNew,  'promotionsUpdate': promotionsUpdate, 'promotionsDelete': promotionsDelete, 'promotionsNew' : promotionsNew,  "deliveryTime": $("#time").val(), "deliveryDate": $("#deliveryDate").val()},
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
