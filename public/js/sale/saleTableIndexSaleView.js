$(document).ready(function() {

    var saleTable = $('#saleTable').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
        },
        "processing": true,
        // "serverSide": true,
        "ajax": saleIndexRoute,
        "deferRender": true,
        "bAutoWidth": false,
        "columns": [{
                sWidth: "40%",
                data: 'client',
                name: 'sale.client'
            },
            {
                sWidth: "30%",
                data: 'orderDateTime',
                name: 'sale.orderDateTime'
            },
            {
                sWidth: "30%",
                data: 'deliveryDateTime',
                name: 'sale.deliveryDateTime'
            },
            {
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": " <p data-placement='top' data-toggle='tooltip' title='Editar'><button  id='EditBtn' class='btn btn-primary btn-xs' data-title='Edit' data-toggle='modal' data-target='#edit' ><span class='glyphicon glyphicon-pencil'></span></button></p>"
            },
            {
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": " <p data-placement='top' data-toggle='tooltip' title='Borrar'><button id='deleteBtn' class='btn btn-danger btn-xs' data-title='Delete' data-toggle='modal' data-target='#delete'><span class='glyphicon glyphicon-trash'></span></button></p>"
            },
            {
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": " <p data-placement='top' data-toggle='tooltip' title='Cosultar'><button id='ShowBtn' class='btn btn-info btn-xs' data-title='Show' data-toggle='modal' data-target='#show'><span class='glyphicon glyphicon-search'></span></button></p>"
            }
        ],
    });

    //Se ejecuta cuando se aprieta un botón
    $('#saleTable tbody').on('click', 'button', function() {
        var button = this;
        var id = saleTable.row($(this).parents('tr')).data()['id'];
        if (button['id'] == 'deleteBtn') {
            if (confirm("¿Esta seguro que desea eliminar esta venta?")) {
                deleteSale(id);
            }
        } else if (button['id'] == 'EditBtn') {
            window.location.href = saleEditRoute + "/" + id;
        } else if (button['id'] == 'ShowBtn') {
            window.location.href = saleShowRoute + "/" + id;
        }

    });
});