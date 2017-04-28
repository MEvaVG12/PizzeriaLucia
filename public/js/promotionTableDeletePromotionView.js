$(document).ready(function(){
  var tableP = $('#promotionTable').DataTable({
    "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
    },
    "processing": true,
   // "serverSide": true,
    "ajax": "api/promotion/index",
    "deferRender": true,
    "bAutoWidth" : false,
    "columns":[
        {sWidth : "50%", data:'name', name: 'promotions.name'},
        {sWidth : "50%", data:'price', name: 'promotions.price'},
        {"className":      'details-control',
          "orderable":      false,
          "data":           null,
          "defaultContent": "<button class='delete-modal btn btn-danger' onclick='fun_delete()'>Delete</button>"
        },
    ],
    "rowId": 'name',
    "dom": 'Bfrtip',
  });


});


 function fun_delete(){
    var id = 1; //TODO generalizar
    var token = $(" [name=_token]").val();

    $.ajax({
      url: "api/promotion/delete/" + id + '',
      type: 'PUT',
      data: {'_token': token},
        success: function (data) {
         toastr.success('La promoción se eliminó exitosamente.', 'Guardado!', {timeOut: 5000});
          $('#promotionTable').DataTable().ajax.reload();
        },
        error : function(xhr, status) {
        toastr.error('La promoción no ha podido ser eliminada', 'Error!')
        }
    });
  }
