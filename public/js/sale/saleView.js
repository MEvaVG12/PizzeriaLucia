var id = sale.id;

var productsUpdate = [];
var promotionsUpdate = [];
var productsDelete = [];
var promotionsDelete = [];
var productsNew = [];
var promotionsNew = [];
var productsExists = [] ;

function deleteSale(id) {

    var token = $(" [name=_token]").val();

    $("#errorMain").addClass('hidden');
    $("#errorDB").addClass('hidden');
    $("#success").addClass('hidden')

    $.ajax({
        url: saleDeleteRoute + "/" + id,
        type: 'PUT',
        data: {
            '_token': token
        },
        success: function(data) {
            $("#success").removeClass('hidden');
            $('#saleTable').DataTable().ajax.reload();
        },
        error: function(xhr, status) {
            $("#errorDB").removeClass('hidden')
        }
    });
}

//Recoge los datos para ser actualizados en la bd
function update() {
    var errors = [];
    var saleDetailTable = $('#saleDetailsTable').DataTable();
    var productsId = [];
    var amounts = [];
    var token = $(" [name=_token]").val();

    //Valida que todos los datos están ingresados
    if (saleDetailTable.rows().data().length < 1) {
        errors.push('Ingrese al menos un producto en la tabla')
    }
    if ($("#price").val() === '') {
        errors.push('El campo precio es requerido')
    }

    if (errors.length > 0) {
        $("#success").addClass('hidden');
        $("#errorDB").addClass('hidden');
        $('#listErrorMain').empty();
        $("#errorMain").removeClass('hidden');
        for (var i in errors) {
            $("#errorMain ul").append('<li><span>' + errors[i] + '</span></li>');
        }
    } else {
        $("#errorMain").addClass('hidden');
        $("#errorDB").addClass('hidden');
        $("#success").addClass('hidden')

        console.log(productsUpdate);
        console.log(productsDelete);
        console.log(productsNew);
        console.log(promotionsUpdate);
        console.log(promotionsDelete);
        console.log(promotionsNew);
        $.ajax({
            url: saleUpdateRoute + '/' + id,
            type: 'PUT',
            data: {
                "price": $("#price").val(),
                '_token': token,
                'productsUpdate': productsUpdate,
                'productsDelete': productsDelete,
                'productsNew': productsNew,
                'promotionsUpdate': promotionsUpdate,
                'promotionsDelete': promotionsDelete,
                'promotionsNew': promotionsNew,
                "deliveryTime": $("#time").val(),
                "deliveryDate": $("#deliveryDate").val()
            },
            success: function(data) {
                $("#success").removeClass('hidden')
                //Vacía arrays
                productsUpdate.length=0;
                productsDelete.length=0;
                productsNew.length=0;
                promotionsUpdate.length=0;
                promotionsDelete.length=0;
                promotionsNew.length=0;
            },
            error: function(xhr, status) {
                $("#errorDB").removeClass('hidden')
            }
        });
    }
}

//Recoge los datos para ser guardados en la bd
function save() {
    var errors = [];
    var saleDetailTable = $('#saleDetailTable').DataTable();
    var products = [];
    var promotions = [];
    var token = $(" [name=_token]").val();
    //Valida que todos los datos están ingresados
    if ($("#name").val() === '') {
        errors.push('El campo nombre es requerido')
    }
    if (saleDetailTable.rows().data().length < 1) {
        errors.push('Ingrese al menos un producto en la tabla')
    }
    if (errors.length > 0) {
        $("#success").addClass('hidden');
        $("#errorDB").addClass('hidden');
        $('#listErrorMain').empty();
        $("#errorMain").removeClass('hidden');
        for (var i in errors) {
            $("#errorMain ul").append('<li><span>' + errors[i] + '</span></li>');
        }
    } else {
        $("#errorMain").addClass('hidden');
        $("#errorDB").addClass('hidden');
        $("#success").addClass('hidden')

        saleDetailTable.rows().every(function(rowIdx, tableLoop, rowLoop) {
            var data = this.data();

            if (data[5] == 'product') {
                var product = {
                    amount: data[2],
                    id: data[1],
                    price: data[3]
                };
                products.push(product);
            } else if (data[5] == 'promotion') {
                var promotion = {
                    amount: data[2],
                    id: data[1],
                    price: data[3]
                };
                promotions.push(promotion);
            }
        });

        $.ajax({
            url: saleCreateRoute,
            type: 'POST',
            data: {
                "client": $("#name").val(),
                "orderDate": $("#date").val(),
                "orderTime": $("#timeP").val(),
                "deliveryDate": $("#deliveryDate").val(),
                "deliveryTime": $("#time").val(),
                "products": products,
                "promotions": promotions,
                '_token': token
            },
            success: function(data) {
                $("#success").removeClass('hidden')
            },
            error: function(xhr, status) {
                $("#errorDB").removeClass('hidden')
            }
        });
        //limpia pantalla
        $("#name").val('');
        $("#total").val('0');
        saleDetailTable.clear().draw();
    }
}