$(document).ready(function() {

    var id = product.id;

    if (productType['name'] == "Pizza") {
        var token = $(" [name=_token]").val();
        $('#ingredientTable').DataTable({
            "ajax": {
                "url": ingredientsRoute,
                "type": "post",
                "data": {
                    '_token': token,
                    "id": id,
                },
            },
            "columns": [{
                data: 'name',
                name: 'ingredients.name'
            }, ],
        });
        document.getElementById('ingredients').style.display = "block";
    } else {
        document.getElementById('ingredients').style.display = "none";
    }

});