//vector que contendrá los stocks a actualizar
stocksUpdate = [];

//Recoge los datos para ser guardados en la bd
function save() {
    var token = $(" [name=_token]").val();

    $("#errorMain").addClass('hidden');
    $("#errorDB").addClass('hidden');
    $("#success").addClass('hidden')


    for (var key in stocksUpdate) {
        $.ajax({
            url: "api/stock/update/" + stocksUpdate[key]['id'] + '',
            type: 'PUT',
            data: {
                "amount": stocksUpdate[key]['amount'],
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