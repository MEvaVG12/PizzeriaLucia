    $(document).ready(function(){
      var tableP = $('#productTable').DataTable({
        "language": {"url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"},
        "processing": true,
       // "serverSide": true,
        "ajax": "api/products",
       // "ajax": "api/stocks",
        "bAutoWidth" : false,
        "deferRender": true,
        "columns":[
            {data:'name', name: 'products.name'},
            {data:'price', price: 'products.price'},
        ],
          /* "columns":[
        {sWidth : "50%", data:'name', name: 'ingredients.name'},
        {sWidth : "50%", data:'amount', name: 'stocks.amount'}
      ],*/
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
            "type":"number",
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
      var token = $(" [name=_token]").val();

      $("#errorDB").addClass('hidden');
      $("#success").addClass('hidden')

      console.log(price);

      $.ajax({
        url: "http://localhost:8080/pizzeria/public/api/product/update" + '/' + id + '',
        type: 'PUT',
        data: {"price": price, '_token': token},
          success: function (data) {
            $("#success").removeClass('hidden');
            $('#productTable').DataTable().ajax.reload();
          },
          error : function(xhr, status) {
            $("#errorDB").removeClass('hidden')
          }
      });
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
    