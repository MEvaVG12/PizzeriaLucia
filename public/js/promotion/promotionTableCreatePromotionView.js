$(document).ready(function() {

    var productTable = $('#productTable').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
        },
        "processing": true,
        //"serverSide": true,
        "ajax": productsRoute,
        "deferRender": true,
        "bAutoWidth": false,
        "columns": [{
                "targets": 0,
                "sWidth": "50%",
                "data": function(row, aoData, fnCallback) {
                    return row['typeProduct'] + ' ' + row['name'];
                }
            },
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

    var promotionDetailTable = $('#promotionDetailTable').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
        },
        "columnDefs": [{
                "targets": [1],
                "visible": false,
                "searchable": false
            },
            {
                "sWidth": "8%",
                "targets": [3],
                "defaultContent": " <p data-placement='top' data-toggle='tooltip' title='Borrar'><button type='button'  id='deleteBtn' class='btn btn-danger btn-xs' data-title='Delete' data-toggle='modal' data-target='#delete'><span class='glyphicon glyphicon-trash'></span></button></p>",
                "searchable": false
            }
        ],
        "deferRender": true,
        "bAutoWidth": false,
        "rowId": 'name',
        "dom": 'Bfrtip',
    });

    //Borra la fila en la table
    $('#promotionDetailTable tbody').on('click', 'button', function() {
        if (confirm("¿Esta seguro que desea eliminar?")) {
            promotionDetailTable.row($(this).parents('tr')).remove().draw();
        }
    });

    //Permite seleccionar solo una fila de la tabla
    $('#productTable tbody').on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            productTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $('#closeProduct').on('click', function() {
        //limpia modelo
        $("#amount").val('');
        productTable.rows('tr.selected').deselect();
        $('#modalAddProduct').modal('toggle');
    });

    $('#addProduct').on('click', function() {
        var errors = [];
        var rowData = productTable.rows('.selected').data()[0];
        //Valida que todos los datos están ingresados
        if (parseInt($("#amount").val()) < 1) {
            errors.push('El campo cantidad debe ser positivo')
        }
        if ($("#amount").val() === '') {
            errors.push('El campo cantidad es requerido')
        }
        if ($('#productTable tbody tr.selected').length < 1) {
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
            promotionDetailTable.row.add([
                rowData['typeProduct'] + " " +rowData['name'],
                rowData['id'],
                $("#amount").val()
            ]).draw(false);

            //limpia modelo
            $("#amount").val('');
            productTable.rows('tr.selected').deselect();
            $('#modelAddProduct').modal('toggle');
        }
    });

});