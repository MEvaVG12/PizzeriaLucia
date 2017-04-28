@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
@stop

@section('content')
    <div class="page-header">
      <h1>Consultar Promoción</h1>
    </div>

    <div class="panel-body">
      <table class='table table-bordered' id='promotionTable'>
        <thead>
           <th>Nombre</th>
           <th>Precio</th>
           <th>Editar</th>
           <th>Borrar</th>
        </thead>
      </table>
    </div>

    <form method="POST">
      {{ csrf_field() }}
      <div class="page-body" id="products" style="display:none">
        <h3>Promoción formada por:</h3>
        <table class='table table-bordered' id='productTable'>
          <thead>
            <th>Producto</th>
            <th>Cantidad</th>
          </thead>
        </table>
      </div>
    </form>

       <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
      </div>
          <div class="modal-body">

       <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>

      </div>
        <div class="modal-footer ">
        <button type="button" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
      </div>
        </div>
    <!-- /.modal-content -->
  </div>
      <!-- /.modal-dialog -->
    </div>
@stop

@section('javascript')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script>
    // global app configuration object
    var config = {
        routes: [
            { promotionIndex: "{{ URL::to('api.promotion.index') }}" ,
              promotionDelete: "{{ URL::to('api.promotion.delete') }}" ,
              promotionDetails: "{{ URL::to('api.promotion.index.promotionDetails') }}"
            }
        ]
    };
</script>
<script>$(document).ready(function(){

  var tableP = $('#promotionTable').DataTable({
    "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
    },
    "processing": true,
   // "serverSide": true,
    "ajax": config.routes.promotionIndex,
    "deferRender": true,
    "bAutoWidth" : false,
    "columns":[
        {sWidth : "50%", data:'name', name: 'promotions.name'},
        {sWidth : "50%", data:'price', name: 'promotions.price'},
        {"className":      'details-control',
          "orderable":      false,
          "data":           null,
          "defaultContent": " <p data-placement='top' data-toggle='tooltip' title='Edit'><button class='btn btn-primary btn-xs' data-title='Edit' data-toggle='modal' data-target='#edit' ><span class='glyphicon glyphicon-pencil'></span></button></p>"
        },
        {"className":      'details-control',
          "orderable":      false,
          "data":           null,
          "defaultContent": " <p data-placement='top' data-toggle='tooltip' title='Delete'><button class='btn btn-danger btn-xs' data-title='Delete' data-toggle='modal' data-target='#delete' ><span class='glyphicon glyphicon-trash'></span></button></p>"
        }
    ],
    "rowId": 'name',
    "select": true,
    "dom": 'Bfrtip',
  });
  $('#promotionTable tbody').on( 'click', 'tr', function () {
    if ( $(this).hasClass('selected') ) {//cuando deselecciono
        $(this).removeClass('selected');
        document.getElementById('products').style.display = "none";
    }
    else {
      $id = tableP.row(this).data()['id'];
      tableP.$('tr.selected').removeClass('selected');
      $(this).addClass('selected');
      var token = $(" [name=_token]").val();
      //$('#productTable').destroy();
      $('#productTable').DataTable({
          "ajax": {
              "url": config.routes.promotionDetails,
              "type": "post",
              "data" : {
                 '_token': token,
                  "id" :  $id ,
              }
          },
          "language": {
              "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
          },
          "columns":[
              {sWidth : "50%", data:'productName', name: 'products.name'},
              {sWidth : "50%", data:'amount', name: 'promotion_details.amount'},
          ],
      });
      console.log($id)
      document.getElementById('products').style.display = "block";
    }
  } );
   $('#promotionTable tbody').on( 'click', 'button', function () {
      var data = tableP.row( $(this).parents('tr') ).data();
      console.log(this);
      console.log(data['id']);
      fun_delete(data['id']);
    } );
});

 function fun_delete(id){
    var token = $(" [name=_token]").val();
    var tableP = $('#promotionTable').DataTable();
    console.log(this);

    $.ajax({
      url: config.routes.promotionDelete + id + '',
      type: 'PUT',
      data: {'_token': token},
        success: function (data) {
          $('#promotionTable').DataTable().ajax.reload();
        },
        error : function(xhr, status) {

        }
    });
  }
</script>
@stop
