@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link href="{{ URL::asset('css/styleToastr.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="page-header">
      <h1>Mostrar Venta</h1>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Cliente:</strong>
                    {{ $sale->client }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Fecha  y hora de pedido:</strong>
                    {{ $sale->orderDateTime }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Fecha y hora de entrega:</strong>
                    {{ $sale->deliveryDateTime }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="form-group">
                  <strong>Detalle de venta:</strong>
                      <div class="panel-body">

                        <form method="POST">
                          {{ csrf_field() }}
                          <table class='table table-bordered' id='productTable'>
                           <thead>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Precio Unitario</th>
                            <th class="text-center">Subtotal</th>
                         </thead>
                          </table>
                        </form>

                      </div>
              </div>
            </div>
          <div class='form-group'>
            <label for="title" class='control-label'>Total: </label>
            <input required  readonly="readonly" class='form-control' type='text' name='total' id='total' value="0">
          </div>
      </div>



@stop

@section('javascript')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>


<script>$(document).ready(function(){

  var sale = {!! json_encode($sale->toArray()) !!};
  var id = sale.id;


  var token = $(" [name=_token]").val();
    var productTable =  $('#productTable').DataTable({
          "ajax": {
              "url": "http://localhost:8080/pizzeria/public/api/sale/index/saleDetails",
              "type": "post",
              "data" : {
                 '_token': token,
                  "id" :  id ,
              }
          },
          "language": {
              "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
          },
          "columns":[
            {
              "targets": 0,
              "data" : function(row, aoData, fnCallback) {
                if (row['productName'] != null){
                  return row['typeProduct'] + ' ' + row['productName'];
                } else {
                  return 'Promoción'  + ' ' + row['promotionName'];
                }     
            }},
            {sWidth : "30%", data:'amount', name: 'sale_details.amount'},
            {sWidth : "30%", data:'price', name: 'sale_details.price'},
            {
              "targets": 3,
              "data" : function(row, aoData, fnCallback) {
                     return row['amount']*row['price'];
                }      
            }
          ],

          "dom": 'Bfrtip',
          "initComplete": function(settings, json) {
              var total =0;
              productTable.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                 var data = this.data();
                 total = total + data['amount']*data['price'];
                 $("#total").val(total);
             } );
            }
      });

  
});
</script>
@stop