$(document).ready(function() {
    var productTable = $('#productTable').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
        },
        "processing": true,
        "ajax": "api/products",
        "bAutoWidth": false,
        "deferRender": true,
        "columns": [{
                "targets": 0,
                "sWidth": "50%",
                "data": function(row, aoData, fnCallback) {
                    return row['typeProduct'] + ' ' + row['name'];
                }
            },
            {
                sWidth: "50%",
                data: 'price',
                price: 'products.price'
            },
            {
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": " <p data-placement='top' data-toggle='tooltip' title='Cosultar'><button id='ShowBtn' class='btn btn-info btn-xs' data-title='Show' data-toggle='modal' data-target='#show'><span class='glyphicon glyphicon-search'></span></button></p>"
            }
        ],
        "rowId": 'name',
        "select": true,
        "dom": 'Bfrtip',
    });

    //Configuración de la/s celda/s editable/s
    productTable.MakeCellsEditable({
        "onUpdate": updateProduct,
        "inputCss": 'my-input-class',
        "columns": [1],
        "allowNulls": {
            "columns": [1],
            "errorClass": 'error'
        },
        "confirmationButton": {
            "confirmCss": 'my-confirm-class',
            "cancelCss": 'my-cancel-class'
        },
        "inputTypes": [{
            "column": 1,
            "type": "decimal",
            "options": null
        }]
    });

    //Ejecuta la consulta para mostrar los ingredientes de un producto específico
    $('#productTable tbody').on('click', 'button', function() {
        var id = productTable.row($(this).parents('tr')).data()['id'];
        window.location.href = productShowRoute + "/" + id;
    });
});

function updateProduct(updatedCell, updatedRow, oldValue) {
    var id = updatedRow.data().id;
    var price = updatedRow.data().price;

    //Si no existe en el array productsUpdate, lo agrega. Caso contrario, solo actualiza el precio
    var isNew = false;
    for (var key in productsUpdate) {
        if (productsUpdate[key]['id'] == id) {
            isNew = true;
            productsUpdate[key]['price'] = price;
        }
    }
    if (!isNew) {
        var product = {
            price: price,
            id: id
        };
        productsUpdate.push(product);
    }

}