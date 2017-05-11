$(document).ready(function() {


    var id = promotion.id;

    var token = $(" [name=_token]").val();
    $('#productTable').DataTable({
        "ajax": {
            "url": promotionDetailsRoute,
            "type": "post",
            "data": {
                '_token': token,
                "id": id,
            }
        },
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
        },
        "columns": [{
                "targets": 0,
                "sWidth": "50%",
                "data": function(row, aoData, fnCallback) {
                    return row['typeProduct'] + ' ' + row['productName'];
                }
            },
            {
                sWidth: "50%",
                data: 'amount',
                name: 'promotion_details.amount'
            },
        ],
        "dom": 'Bfrtip',
    });

});