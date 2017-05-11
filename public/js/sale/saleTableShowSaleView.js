$(document).ready(function() {
    var id = sale.id;
    var token = $(" [name=_token]").val();

    var saleTable = $('#saleTable').DataTable({
        "ajax": {
            "url": saleDetailsRoute,
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
                "data": function(row, aoData, fnCallback) {
                    if (row['productName'] != null) {
                        return row['typeProduct'] + ' ' + row['productName'];
                    } else {
                        return 'Promoción' + ' ' + row['promotionName'];
                    }
                }
            },
            {
                sWidth: "30%",
                data: 'amount',
                name: 'sale_details.amount'
            },
            {
                sWidth: "30%",
                data: 'price',
                name: 'sale_details.price'
            },
            {
                "targets": 3,
                "data": function(row, aoData, fnCallback) {
                    return row['amount'] * row['price'];
                }
            }
        ],

        "dom": 'Bfrtip',
        "initComplete": function(settings, json) {
            var total = 0;
            saleTable.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var data = this.data();
                total = total + data['amount'] * data['price'];
                $("#total").val(total);
            });
        }
    });

});