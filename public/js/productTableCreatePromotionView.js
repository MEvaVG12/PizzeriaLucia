$(document).ready(function(){
  var tableP = $('#productTable').DataTable({
    "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
    },
    "processing": true,
    //"serverSide": true,
    "ajax": "http://localhost:8080/pizzeria/public/api/products",
    "deferRender": true,
    "bAutoWidth" : false,
    "columns":[
        {sWidth : "50%", data:'name', name: 'products.name'},
    ],
    "rowId": 'name',
    "select": true,
    "dom": 'Bfrtip',
  });
  $('#productTable tbody').on( 'click', 'tr', function () {
    if ( $(this).hasClass('selected') ) {//cuando deselecciono
        $(this).removeClass('selected');
        document.getElementById('ingredientes').style.display = "none";
    }
    else {//cuando selecciono
        $id = tableP.row(this).data()['id'];
        tableP.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if (tableP.row(this).data()['typeName'] == "Pizza") {
          console.log('Pizza');
          $('#ingredientTable').DataTable({
            "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
            },
            "paging": false,
            "ajax": "api/ingredients/".$id,
            "bAutoWidth" : false,
            "columns":[
              {sWidth : "100%", data:'name', name: 'ingredients.name'},
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