
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

    $("#errorDB").addClass('hidden');
    $("#success").addClass('hidden')

    $.ajax({
      url: "api/stock/update/" + id + '',
      type: 'PUT',
      data: {"amount": amount, '_token': token},
        success: function (data) {
          $("#success").removeClass('hidden');
          $('#stockTable').DataTable().ajax.reload();
        },
        error : function(xhr, status) {
          $("#errorDB").removeClass('hidden')
        }
    });
  }
