$(document).ready(function(){
  var tableP = $('#promotionTable').DataTable({
    "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
    },
    "processing": true,
   // "serverSide": true,
    "ajax": "http://localhost:8080/pizzeria/public/api/promotion/index",
    "deferRender": true,
    "bAutoWidth" : false,
    "columns":[
        {sWidth : "50%", data:'name', name: 'promotions.name'},
        {sWidth : "50%", data:'price', name: 'promotions.price'},
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
      $('#productTable').DataTable({
          "ajax": {
              "url": "index:173 http://localhost:8080/pizzeria/public/api/promotion/index/promotionDetails",
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
});