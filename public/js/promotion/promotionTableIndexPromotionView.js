$(document).ready(function() {

    var promotionTable = $('#promotionTable').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
        },
        "processing": true,
        // "serverSide": true,
        "ajax": promotionIndexRoute,
        "deferRender": true,
        "bAutoWidth": false,
        "columns": [{
                sWidth: "50%",
                data: 'name',
                name: 'promotions.name'
            },
            {
                sWidth: "50%",
                data: 'price',
                name: 'promotions.price'
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
    $('#promotionTable tbody').on('click', 'button', function() {
        var button = this;
        var id = promotionTable.row($(this).parents('tr')).data()['id'];
        if (button['id'] == 'deleteBtn') {
            if (confirm("¿Esta seguro que desea eliminar esta promoción?")) {

                deletePromotion(id);
            }
        } else if (button['id'] == 'EditBtn') {
            window.location.href = promotionEditRoute + "/" + id;
        } else if (button['id'] == 'ShowBtn') {
            window.location.href = promotionShowRoute + "/" + id;
        }

    });
});