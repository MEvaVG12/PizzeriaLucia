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
                    var priceBig = new Big(row['price']);
                    var amountBig = new Big(row['amount']);
                    var subtotal = priceBig.times(amountBig);
                    return subtotal.toString();
                }
            }
        ],

        "dom": 'Bfrtip',
        "initComplete": function(settings, json) {
            var total = 0;
            saleTable.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var data = this.data();
                var priceBig = new Big(data['price']);
                var amountBig = new Big(data['amount']);
                var subtotal = priceBig.times(amountBig);
                var totalBig = new Big($("#total").val());
                $("#total").val(subtotal.plus(totalBig).toString());
            });
        }
    });

});