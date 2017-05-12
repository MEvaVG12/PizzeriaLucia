//vector que contendrá los productos a actualizar
productsUpdate = [];

//Recoge los datos para ser actualizados en la bd
function update() {
    var errors = [];
    var token = $(" [name=_token]").val();
    
    //Valida que todos los datos están ingresados
    for (var key in productsUpdate) {
        if (productsUpdate[key]['price']<1 && errors.length<1){
            errors.push('El precio debe ser positivo')
        }
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

        //Guarda los datos en la DB
        for (var key in productsUpdate) {
            $.ajax({
                url: productUpdateRoute + "/" + productsUpdate[key]['id'],
                type: 'PUT',
                data: {
                    "price": productsUpdate[key]['price'],
                    '_token': token
                },
                success: function(data) {
                    $("#success").removeClass('hidden');
                    $('#stockTable').DataTable().ajax.reload();
                },
                error: function(xhr, status) {
                    $("#errorDB").removeClass('hidden')
                }
            });
        }
    }
}