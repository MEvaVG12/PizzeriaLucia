$(document).ready(function() {

    var stockTable = $('#stockTable').DataTable({

        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
        },
        "processing": true,
        //"serverSide": true,
        "ajax": "api/stocks",
        "bAutoWidth": false,
        "columns": [{
                sWidth: "50%",
                data: 'name',
                name: 'ingredients.name'
            },
            {
                sWidth: "50%",
                data: 'amount',
                name: 'stocks.amount'
            }
        ],
    });

    stockTable.MakeCellsEditable({
        "onUpdate": updateStock,
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
            "type": "number",
            "options": null
        }]
    });


});

function updateStock(updatedCell, updatedRow, oldValue) {
    var id = updatedRow.data().id;
    var amount = updatedRow.data().amount;

    //Si no existe en el array stocksUpdate, lo agrega. Caso contrario, solo actualiza la cantidad
    var isNew = false;
    for (var key in stocksUpdate) {
        if (stocksUpdate[key]['id'] == id) {
            isNew = true;
            stocksUpdate[key]['amount'] = amount;
        }
    }
    if (!isNew) {
        var stock = {
            amount: amount,
            id: id
        };
        stocksUpdate.push(stock);
    }


}