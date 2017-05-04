 productsUpdate = [];

  $(document).ready(function(){

    var table = $('#stockTable').DataTable({

      "language": {
              "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
      },
      "processing": true,
      "serverSide": true,
      "ajax": "api/stocks",
      "bAutoWidth" : false,
      "columns":[
        {sWidth : "50%", data:'name', name: 'ingredients.name'},
        {sWidth : "50%", data:'amount', name: 'stocks.amount'}
      ],
    });

    table.MakeCellsEditable({
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


  });

  function myCallbackFunction(updatedCell, updatedRow, oldValue) {
    var id = updatedRow.data().id;
    var amount = updatedRow.data().amount;
    var token = $(" [name=_token]").val();

    //TODO si existe cambiar, no agregar
    var product = {amount:amount, id:id};
    productsUpdate.push(product);
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
        $.ajax({
          url: "api/stock/updates/",
          type: 'PUT',
          data: {"stockUpdate": productsUpdate},
            success: function (data) {
              $("#success").removeClass('hidden');
              $('#stockTable').DataTable().ajax.reload();
            },
            error : function(xhr, status) {
              $("#errorDB").removeClass('hidden')
            }
        });
      }
    }
