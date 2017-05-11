//El id en la tabla representa el id del producto si se agrega uno nuevo. Sino es el id del detalle de promoción que se había creado anteriormente
var id = promotion.id;

$(document).ready(function() {

    var productTable = $('#productTable').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
        },
        "columnDefs": [{
                "targets": [0],
                "visible": false,
                "searchable": false
            },
            {
                "sWidth": "8%",
                "targets": [3],
                "defaultContent": " <p data-placement='top' data-toggle='tooltip' title='Borrar'><button id='deleteBtn' class='btn btn-danger btn-xs' data-title='Delete' data-toggle='modal' data-target='#delete'><span class='glyphicon glyphicon-trash'></span></button></p>",
                "searchable": false
            }
        ],
        "deferRender": true,
        "bAutoWidth": false,
        "dom": 'Bfrtip'
    });

    var productTableNew = $('#productTableNew').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
        },
        "processing": true,
        //"serverSide": true,
        "ajax": productsRoute,
        "deferRender": true,
        "bAutoWidth": false,
        "columns": [ {
              "targets": 0,
              "data" : function(row, aoData, fnCallback) {
                  return row['typeProduct'] + ' ' + row['name'];   
            }},
            {
                visible: false,
                data: 'id',
                name: 'products.id'
            },
        ],
        "rowId": 'name',
        "select": true,
        "dom": 'Bfrtip',
    });

    //Carga los datos de los detalles de promoción en la tabla
    var token = $(" [name=_token]").val();
    $.ajax({
        type: "POST",
        data: {
            '_token': token,
            "id": id,
        },
        url: promotionDetailsRoute,
    }).done(function(data) {
        promotionsExists = data['data'];
        //Agrega productos existentes a tabla 
        for (var key in promotionsExists) {
            productTable.row.add([
                promotionsExists[key]['id'],promotionsExists[key]['typeProduct'] + " " + promotionsExists[key]['productName'], promotionsExists[key]['amount']
            ]).draw(false);
        }
    });

    productTable.MakeCellsEditable({
        "onUpdate": updatePromotion,
        "inputCss": 'my-input-class',
        "columns": [2],
        "allowNulls": {
            "columns": [2],
            "errorClass": 'error'
        },
        "confirmationButton": {
            "confirmCss": 'my-confirm-class',
            "cancelCss": 'my-cancel-class'
        },
        "inputTypes": [{
            "column": 2,
            "type": "number",
            "options": null
        }]
    });

    //Borra la fila en la table
    $('#productTable tbody').on('click', 'button', function() {
        if (confirm("¿Esta seguro que desea eliminar esta promoción?")) {
            var data = productTable.row($(this).parents('tr')).data();
            var id = data[0];
            
            //ve si el objeto que elimino es uno nuevo o ya existente
            var isNew = false;
            for (var key in promotionsNew) {
                if ((promotionsNew[key]['id'] == id) && (isNew==false)) {
                            console.log(promotionsNew);  
                    isNew = true;
                     delete promotionsNew[key];
                                                 console.log(promotionsNew);  
                }
            }
            if (!isNew) {
                console.log('asdf');
                var promotion = {
                id: id
                 };
                 promotionsDelete.push(promotion);
            }
            productTable.row($(this).parents('tr')).remove().draw();
        } 
    });

    //Permite seleccionar solo una fila de la tabla
    $('#productTable tbody').on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            productTableNew.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    //Agrega producto nuevo
    $('#addProduct').on('click', function() {
        var errors = [];
        var rowData = productTableNew.rows('.selected').data()[0];
        //Valida que todos los datos están ingresados
        if ($("#amount").val() === '') {
            errors.push('El campo cantidad es requerido')
        }
        if (parseInt($("#amount").val()) <1 ) {
            errors.push('El campo cantidad debe ser positivo')
        }
        if ($('#productTableNew tbody tr.selected').length < 1) {
            errors.push('Seleccione un producto en la tabla')
        }
        if (errors.length > 0) {
            $('#listErrorModal').empty();
            $("#errorModal").removeClass('hidden');
            for (var i in errors) {
                $("#errorModal ul").append('<li><span>' + errors[i] + '</span></li>');
            }
        } else {
            $("#errorModal").addClass('hidden');
            //Agrega en la tabla de detalle de promoción los datos seleccionados
            productTable.row.add([
                rowData['id'], rowData['typeProduct'] + " " +
                rowData['name'],
                $("#amount").val()
            ]).draw(false);
            var product = {
                id: rowData['id'],
                amount: $("#amount").val()
            };
            promotionsNew.push(product);
            //limpia modelo
            $("#amount").val('');
            productTableNew.rows('tr.selected').deselect();
            $('#modalAddProduct').modal('toggle');
        }
    });

       $('#closeProduct').on('click', function() {
        //limpia modelo
            $("#amount").val('');
            productTableNew.rows('tr.selected').deselect();
            $('#modalAddProduct').modal('toggle');
       });


});

function updatePromotion(updatedCell, updatedRow, oldValue) {
    var id = updatedRow.data()[0];
    var amount = updatedRow.data()[2];

    //Si no existe en el array promotionsUpdate, lo agrega. Caso contrario, solo actualiza el precio
    var isNew = false;
    for (var key in promotionsUpdate) {
        if (promotionsUpdate[key]['id'] == id) {
            isNew = true;
            promotionsUpdate[key]['newValue'] = amount;
        }
    }
    if (!isNew) {
        var product = {
            newValue: amount,
            id: id
        };
        promotionsUpdate.push(product);
    }

    //En caso que exista en una nueva promoción agregada, actualiza su valor
    for (var key in promotionsNew) {
        if (promotionsNew[key]['id'] == id) {
            promotionsNew[key]['amount'] = amount;
        }
    }
}