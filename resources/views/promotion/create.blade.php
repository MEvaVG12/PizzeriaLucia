@extends('layouts.master')

@section('links')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<link href="{{ URL::asset('css/dataTables.checkboxes.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/styleToastr.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="page-header">
      <h1>Crear Promoción</h1>
    </div>
    <form method="POST">
        
    {{ csrf_field() }}
   
    <div class="panel-body">
      <div class='form-group'>
        <label for="title" class='control-label'>Nombre de la promoción: </label>
        <input class='form-control' placeholder='Ingrese nombre de la promoción' type='text' name='name' id='name' >
      </div>
      <div class='form-group'>
        <label for="title" class='control-label'>Precio de la promoción: </label>
        <input class='form-control' placeholder='Ingrese precio de la promoción' type='text' name='price' id='price' >
      </div>
      <div class='form-group'>
        <label class='control-label'>Seleccione los productos que formarán parte de la promoción: </label>
        <table class='table table-bordered' id='productTable'>
          <thead>
            <th>Nombre</th>
          </thead>
        </table>
      </div>
    </div>


    </form>
        <div class="col-xs-12 col-sm-12 col-md-12 text-right">
      <button class="btn btn-primary" onclick='save()'>Guardar</button>
    </div>
@stop

@section('javascript')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/dataTables.checkboxes.min.js') }}"></script>
<script >
  $(document).ready(function(){
    var rows_selected = [];
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
        {sWidth : "95%", data:'name', name: 'products.name'},
        {visible: false, data:'id', name: 'products.id'},
    ],
    "rowId": 'name',
    "select": true,
    "dom": 'Bfrtip',
  });
 
    $('#productTable tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );

  /*$('#productTable tbody').on( 'click', 'tr', function () {
    console.log('sadf');
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
  } );*/
});


 function save()
    {    
     // console.log('asdfdsa');
    var token = $(" [name=_token]").val();
    var table = $('#productTable').DataTable();
    var rows_selected = table.column(0).checkboxes.selected();
   //console.log(rows_selected);
    /*$("#productTable > tbody  > tr").each(function() {
      $.each(this.cells, function(){
        var ids = [];
        $("input.checkbox:checked").each(function() {
            ids.push($(this).val());
        });

        var value = $(this).find(":input").val();
        if (value !== undefined) {
        console.log(ids);
         console.log(value);
        }

    });
   
    });*/




     var table = $('#productTable').DataTable();

 var  productsId = [];
    var rowData = table.rows('.selected').data();
    $.each($(rowData),function(key,value){
           //console.log(value["id"]); //"name" being the value of your first column.
          productsId.push(value["id"]);
    });
    //console.log(dataArr);

      table.rows('.selected').data().each( function ( index ) {
//console.log(this.data() );
    // ... do something with data(), or row.node(), etc
      } );


console.log(productsId); 


    $.ajax({
      url: "http://localhost:8080/pizzeria/public/api/promotion/create",
      type: 'POST',
      data: {"productsId": productsId, "name": $("#name").val(), "price": $("#price").val(),'_token': token},
        success: function (data) {
         toastr.success('La promoción se eliminó exitosamente.', 'Guardado!', {timeOut: 5000});
          $('#promotionTable').DataTable().ajax.reload();
        },
        error : function(xhr, status) {
        toastr.error('La promoción no ha podido ser eliminada', 'Error!')
        }
    });
    }




</script>
@stop
