var promotionsUpdate = [];
var promotionsDelete = [];
var promotionsNew = [];
var promotionsExists = [];

//Recoge los datos para ser eliminados en la bd
function deletePromotion(id) {

    var token = $(" [name=_token]").val();


    $("#errorMain").addClass('hidden');
    $("#errorDB").addClass('hidden');
    $("#success").addClass('hidden')

    $.ajax({
        url: promotionDeleteRoute + '/' + id + '',
        type: 'PUT',
        data: {
            '_token': token
        },
        success: function(data) {
            $("#success").removeClass('hidden');
            $('#promotionTable').DataTable().ajax.reload();
        },
        error: function(xhr, status) {
            $("#errorDB").removeClass('hidden')
        }
    });
}

//Recoge los datos para ser actualizados en la bd
function update() {
    var errors = [];

    var token = $(" [name=_token]").val();

    //Valida que todos los datos están ingresados
    for (var key in promotionsUpdate) {
        if (promotionsUpdate[key]['newValue'] < 1 && errors.length < 1) {
            errors.push('La cantidad de producto debe ser positivo')
        }
    }
    for (var key in promotionsNew) {
        if (promotionsNew[key]['newValue'] < 1 && errors.length < 1) {
            errors.push('La cantidad de producto debe ser positivo')
        }
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
        $("#success").addClass('hidden');
        console.log(promotionsDelete);
        $.ajax({
            url: promotionUpdateRoute + '/' + id + '',
            type: 'PUT',
            data: {
                "price": $("#price").val(),
                '_token': token,
                'promotionsUpdate': promotionsUpdate,
                'promotionsDelete': promotionsDelete,
                'promotionsNew': promotionsNew
            },
            success: function(data) {
                $("#success").removeClass('hidden')
            },
            error: function(xhr, status) {
                $("#errorDB").removeClass('hidden')
            }
        });
    }
}

//Recoge los datos para ser creados en la bd
function save() {
    var errors = [];
    var promotionDetailTable = $('#promotionDetailTable').DataTable();
    var productsId = [];
    var amounts = [];
    var token = $(" [name=_token]").val();

    promotionDetailTable.rows().every(function(rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        if (parseInt(data[2]) < 1 && errors.length < 1) {
            //primera validación que se hace
            errors.push('El campo cantidad debe ser positivo')
        } else {
            productsId.push(data[1]);
            amounts.push(parseInt(data[2]));
        }

    });

    //Valida que todos los datos están ingresados
    if ($("#name").val() === '') {
        errors.push('El campo nombre es requerido')
    }
    if ($("#price").val() === '') {
        errors.push('El campo precio es requerido')
    }
    if (!(parseFloat($("#price").val()) > 0)) {
        errors.push('El campo precio debe ser positivo')
    }

    if (promotionDetailTable.rows().data().length < 1) {
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

        $.ajax({
            url: promotionCreateRoute,
            type: 'POST',
            data: {
                "amounts": amounts,
                "productsId": productsId,
                "name": $("#name").val(),
                "price": $("#price").val(),
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
        $("#price").val('');
        promotionDetailTable.clear().draw();
    }
}