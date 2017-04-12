@extends('layouts.master')

@section('content')
<style>
    .my-input-class {
        padding: 3px 6px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .my-confirm-class {
        padding: 3px 6px;
        font-size: 12px;
        color: white;
        text-align: center;
        vertical-align: middle;
        border-radius: 4px;
        background-color: #337ab7;
        text-decoration: none;
    }

    .my-cancel-class {
        padding: 3px 6px;
        font-size: 12px;
        color: white;
        text-align: center;
        vertical-align: middle;
        border-radius: 4px;
        background-color: #a94442;
        text-decoration: none;
    }

    .destroy-button{
        padding:5px 10px 5px 10px;
        border: 1px blue solid;
        background-color:lightgray;
    }

    td {
        text-align:center;
    }

  </style>

    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

    <div class="page-header">
      <h1>Productos</h1>
    </div>

    <div class="panel-body">
      <table class='table table-bordered' id='productTable'>
        <thead>
           <th>Nombre</th>
           <th>Precio</th>
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

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/dataTables.cellEdit.js') }}"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <srcipt src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script>
    $(document).ready(function(){
      var tableP = $('#productTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "api/products",
        "deferRender": true,
        "columns":[
            {data:'name', name: 'products.name'},
            {data:'price', price: 'products.price'},
        ],
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
            "type":"text",
            "options":null
          }
            ]
        });

      $('#productTable tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {//cuando deselecciono
            $(this).removeClass('selected');
            document.getElementById('ingredientes').style.display = "none";
        }
        else {//cuando selecciono
            $("#ingredientTable").dataTable().fnDestroy();

            $id = tableP.row(this).data()['id'];
            tableP.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            if (tableP.row(this).data()['typeName'] == "Pizza") {
              console.log( $id);
                    var token = $(" [name=_token]").val();
              $('#ingredientTable').DataTable({
                "ajax": {
                    "url": "api/ingredients",
                    "type": "post",
                     "data" : {
                         '_token': token,
                          "id" :  $id ,
                      },
                },
                "columns":[
                  {data:'name', name: 'ingredients.name'},
                ],
              });
              document.getElementById('ingredientes').style.display = "block";
            } else {
              console.log('Empanada');
              document.getElementById('ingredientes').style.display = "none";
            }
        }
      } );
    });

    function myCallbackFunction(updatedCell, updatedRow, oldValue) {
      var id = updatedRow.data().id;
      var price = updatedRow.data().price;
      var route = "{{url('api/product/update')}}/";
      var token = $(" [name=_token]").val();

      $.ajax({
        url: "{{ url('api/product/update') }}" + '/' + id + '',
        type: 'PUT',
        data: {"price": price, '_token': token},
          success: function (data) {
            toastr.success('El precio de producto se cambió exitosamente.', 'Guardado!', {timeOut: 5000});
            $('#productTable').DataTable().ajax.reload();
          },
          error : function(xhr, status) {
            toastr.error('En el campo cantidad debe ingresar un número', 'Error!')
          }
      });
    }

    </script>
@stop
