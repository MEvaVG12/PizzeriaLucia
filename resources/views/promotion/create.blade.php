@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<link href="{{ URL::asset('css/dataTables.checkboxes.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/styleToastr.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="page-header">
      <h1>Crear Promoción</h1>
    </div>
    <form method="POST">
        
    {{ csrf_field() }}
   
    <div class="panel-body">
      <div class='form-group'>
        <label for="title" class='control-label'>Nombre de la promoción: </label>
        <input class='form-control' placeholder='Ingrese nombre de la promoción' type='text' name='name' id='name' >
      </div>
      <div class='form-group'>
        <label for="title" class='control-label'>Precio de la promoción: </label>
        <input class='form-control' placeholder='Ingrese precio de la promoción' type='text' name='price' id='price' >
      </div>
      <div class='form-group'>
         <p> Producto: </p>
         <table class='table table-bordered' id='promotionDetailTable'>
            <thead>
              <th>Producto</th>
              <th>IDProductos</th>
              <th>Cantidad</th>
           </thead>
         </table>
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
                    <h4 class="modal-title">Confirmation</h4>
                </div>
                <div class="modal-body">
                    <div class='form-group'>
                      <p>Cantidad</p>
                      <input class='form-control' placeholder='Ingrese cantidad del producto' type='text' name='amount' id='amount' >
                    </div>
                    <div class='form-group'>
                      <p> Producto: </p>
                      <table class='table table-bordered' id='productTable'>
                        <thead>
                          <th>Producto</th>
                        </thead>
                      </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" data-dismiss="modal" name='addProduct' id='addProduct' class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </div>
    </div>

    </form>
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

    var rows_selected = [];
  var tableP = $('#productTable').DataTable({
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
    "deferRender": true,
    "bAutoWidth" : false,
    "rowId": 'name',
    "dom": 'Bfrtip',
  });

    var counter = 1;
    $('#addProduct').on( 'click', function () {

        var rowData = tableP.rows('.selected').data()[0];
        var object = rowData[0];
        console.log(rowData['id']);
        console.log($("#amount").val());
        promotionDetailTable.row.add( [
            rowData['name'],
            rowData['id'],
            $("#amount").val()
        ] ).draw( false );
 
        counter++;

        //TODO limpiar modelo
    } );
 
    $('#productTable tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );
});


 function save()
  {    
    var table = $('#promotionDetailTable').DataTable();
    var  productsId = [];
    var  amounts = [];
    var token = $(" [name=_token]").val();

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
         toastr.success('La promoción se guardó exitosamente.', 'Guardado!', {timeOut: 5000});
          $('#promotionTable').DataTable().ajax.reload();
        },
        error : function(xhr, status) {
        toastr.error('La promoción no ha podido ser guardada', 'Error!')
        }
    });
  }

</script>
@stop
