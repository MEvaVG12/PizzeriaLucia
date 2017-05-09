@extends('layouts.master')

@section('links')
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link href="{{ URL::asset('css/styleToastr.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="page-header">
      <h1>Consultar Venta</h1>
    </div>

    <div class="panel-body">
      <table class='table table-bordered' id='promotionTable'>
        <thead>
           <th class="text-center">Cliente</th>
           <th class="text-center">Fecha pedido</th>
           <th class="text-center">Fecha de entrega</th>
           <th class="text-center">Editar</th>
           <th class="text-center">Borrar</th>
           <th class="text-center">Consultar</th>
        </thead>
      </table>
    </div>
@stop

@section('javascript')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script>$(document).ready(function(){

  var tableP = $('#promotionTable').DataTable({
    "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
    },
    "processing": true,
   // "serverSide": true,
    "ajax": "http://localhost:8080/pizzeria/public/api/sale/index",
    "deferRender": true,
    "bAutoWidth" : false,
    "columns":[
        {sWidth : "40%", data:'client', name: 'sale.client'},
        {sWidth : "30%", data:'orderDateTime', name: 'sale.orderDateTime'},
        {sWidth : "30%", data:'deliveryDateTime', name: 'sale.deliveryDateTime'},
        {"className":      'details-control',
          "orderable":      false,
          "data":           null,
          "defaultContent": " <p data-placement='top' data-toggle='tooltip' title='Editar'><button  id='EditBtn' class='btn btn-primary btn-xs' data-title='Edit' data-toggle='modal' data-target='#edit' ><span class='glyphicon glyphicon-pencil'></span></button></p>"
        },
        {"className":      'details-control',
          "orderable":      false,
          "data":           null,
          "defaultContent": " <p data-placement='top' data-toggle='tooltip' title='Borrar'><button id='deleteBtn' class='btn btn-danger btn-xs' data-title='Delete' data-toggle='modal' data-target='#delete'><span class='glyphicon glyphicon-trash'></span></button></p>"
        },
        {"className":      'details-control',
          "orderable":      false,
          "data":           null,
          "defaultContent": " <p data-placement='top' data-toggle='tooltip' title='Cosultar'><button id='ShowBtn' class='btn btn-info btn-xs' data-title='Show' data-toggle='modal' data-target='#show'><span class='glyphicon glyphicon-search'></span></button></p>"
        }
    ],
  });

    $('#promotionTable tbody').on( 'click', 'button', function () {
      var button = this;
      var id = tableP.row( $(this).parents('tr') ).data()['id'];
      if (button['id'] == 'deleteBtn'){
        if ( confirm( "¿Esta seguro que desea eliminar esta venta?" ) ) {

          fun_delete(id);
        }
      } else if (button['id'] == 'EditBtn'){
          window.location.href = "{{url('sale/edit')}}" + "/" + id;
      } else if(button['id'] == 'ShowBtn'){
          window.location.href = "{{url('sale/show')}}" + "/" + id;
      }

    } );   
});

 function fun_delete(id){ 

    var token = $(" [name=_token]").val();
    var tableP = $('#promotionTable').DataTable();
    console.log(this);

    $.ajax({
      url: "http://localhost:8080/pizzeria/public/api/sale/delete/" + id + '',
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