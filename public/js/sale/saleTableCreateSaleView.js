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
                "data": function(row, aoData, fnCallback) {
                        return row['typeProduct'] + ' ' + row['name'];
                }
            },
            {
                visible: false,
                data: 'id',
                name: 'products.id'
            },
            {
                sWidth: "20%",
                data: 'price',
                name: 'products.price'
            },
        ],
        "rowId": 'name',
        "select": true,
        "dom": 'Bfrtip',
    });

    var promotionTable = $('#promotionTable').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
        },
        "processing": true,
        //"serverSide": true,
        "ajax": promotionsRoute,
        "deferRender": true,
        "bAutoWidth": false,
        "columns": [{
                sWidth: "80%",
                data: 'name',
                name: 'promotion.name'
            },
            {
                visible: false,
                data: 'id',
                name: 'promotion.id'
            },
            {
                sWidth: "20%",
                data: 'price',
                name: 'promotion.price'
            },
        ],
        "rowId": 'name',
        "select": true,
        "dom": 'Bfrtip',
    });

    var saleDetailTable = $('#saleDetailTable').DataTable({
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
                "targets": [6],
                "defaultContent": " <p data-placement='top' data-toggle='tooltip' title='Borrar'><button id='deleteBtn' class='btn btn-danger btn-xs' data-title='Delete' data-toggle='modal' data-target='#delete'><span class='glyphicon glyphicon-trash'></span></button></p>",
                "searchable": false
            },
            {
                "targets": [5],
                "visible": false,
                "searchable": false
            }
        ],
        "deferRender": true,
        "bAutoWidth": false,
        "rowId": 'name',
        "dom": 'Bfrtip',
    });

    //Borra la fila en la table
    $('#saleDetailTable tbody').on('click', 'button', function() {
        saleDetailTable.row($(this).parents('tr')).remove().draw();
    });

    $('#closeProduct').on('click', function() {
        //limpia modelo
        $("#amountProduct").val('');
        productTable.rows('tr.selected').deselect();
        $('#modalAddProduct').modal('toggle');
    });

    $('#closePromotion').on('click', function() {
        //limpia modelo
        $("#amountPromotion").val('');
        promotionTable.rows('tr.selected').deselect();
        $('#modalAddPromotion').modal('toggle');
    });

    $('#addProduct').on('click', function() {
        var errorsProduct = [];
        var rowData = productTable.rows('.selected').data()[0];
        //Valida que todos los datos están ingresados
        if (parseInt($("#amountProduct").val()) < 1) {
            errorsProduct.push('El campo cantidad debe ser positivo')
        }
        if ($("#amountProduct").val() === '') {
            errorsProduct.push('El campo cantidad es requerido')
        }
        if ($('#productTable tbody tr.selected').length < 1) {
            errorsProduct.push('Seleccione un producto en la tabla')
        }
        if (errorsProduct.length > 0) {
            $('#listErrorModalProduct').empty();
            $("#errorModalProduct").removeClass('hidden');
            for (var i in errorsProduct) {
                $("#errorModalProduct ul").append('<li><span>' + errorsProduct[i] + '</span></li>');
            }
        } else {
            $("#errorModalProduct").addClass('hidden');
            //Agrega en la tabla de detalle de promoción los datos seleccionados
            var subtotal = rowData['price'] * $("#amountProduct").val();
            saleDetailTable.row.add([
                rowData['typeProduct'] + " " + rowData['name'],
                rowData['id'],
                $("#amountProduct").val(),
                rowData['price'],
                subtotal, 'product'
            ]).draw(false);

            //limpia modelo
            $("#amountProduct").val('');
            productTable.rows('tr.selected').deselect();
            $('#modalAddProduct').modal('toggle');
            $("#total").val(subtotal + parseFloat($("#total").val()));
        }
    });

    //Borra la fila en la tabla
    $('#saleDetailTable tbody').on('click', 'button', function() {
        if (confirm("¿Esta seguro que desea eliminar?")) {
            saleDetailTable.push(product);
            tableP.row($(this).parents('tr')).remove().draw();
        }
    });

    $('#addPromotion').on('click', function() {
        var errorsPromotion = [];
        var rowData = promotionTable.rows('.selected').data()[0];
        //Valida que todos los datos están ingresados
        if (parseInt($("#amountPromotion").val()) < 1) {
            errorsPromotion.push('El campo cantidad debe ser positivo')
        }
        if ($("#amountPromotion").val() === '') {
            errorsPromotion.push('El campo cantidad es requerido')
        }
        if ($('#promotionTable tbody tr.selected').length < 1) {
            errorsPromotion.push('Seleccione una promoción en la tabla')
        }
        if (errorsPromotion.length > 0) {
            $('#listErrorModalPromotion').empty();
            $("#errorModalPromotion").removeClass('hidden');
            for (var i in errorsPromotion) {
                $("#errorModalPromotion ul").append('<li><span>' + errorsPromotion[i] + '</span></li>');
            }
        } else {
            $("#errorModalPromotion").addClass('hidden');
            //Agrega en la tabla de detalle de promoción los datos seleccionados
            var subtotal = rowData['price'] * $("#amountPromotion").val();
            saleDetailTable.row.add([
                "Promoción " + rowData['name'],
                rowData['id'],
                $("#amountPromotion").val(),
                rowData['price'],
                subtotal, 'promotion'
            ]).draw(false);

            //limpia modelo
            $("#amountPromotion").val('');
            promotionTable.rows('tr.selected').deselect();
            $('#modalAddPromotion').modal('toggle');
            $("#total").val(subtotal + parseFloat($("#total").val()));
        }
    });

});