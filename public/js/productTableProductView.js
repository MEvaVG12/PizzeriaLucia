    $(document).ready(function(){
      var tableP = $('#productTable').DataTable({
        "language": {"url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"},
        "processing": true,
       // "serverSide": true,
       // "ajax": "api/products",
        "ajax": "api/stocks",
        "bAutoWidth" : false,
        "deferRender": true,
        /*"columns":[
            {data:'price', name: 'products.price'},
            {data:'price', price: 'products.price'},
        ],*/
           "columns":[
        {sWidth : "50%", data:'name', name: 'ingredients.name'},
        {sWidth : "50%", data:'amount', name: 'stocks.amount'}
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
    