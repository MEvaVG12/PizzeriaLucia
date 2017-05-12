 var total = 0;

 $(document).ready(function() {

     var saleDetailsTable = $('#saleDetailsTable').DataTable({
         "language": {
             "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
         },
         "columnDefs": [{
                 "targets": [0],
                 "visible": false,
                 "searchable": false
             },
             {
                 "sWidth": "8%",
                 "targets": [5],
                 "defaultContent": " <p data-placement='top' data-toggle='tooltip' title='Borrar'><button type='button' id='deleteBtn' class='btn btn-danger btn-xs' data-title='Delete' data-toggle='modal' data-target='#delete'><span class='glyphicon glyphicon-trash'></span></button></p>",
                 "searchable": false
             }
         ],
         "deferRender": true,
         "bAutoWidth": false,
         "rowId": 'name',
         "dom": 'Bfrtip',
     });

     $.ajax({
         type: "POST",
         data: {
             '_token': $(" [name=_token]").val(),
             "id": id,
         },
         url: saleDetailsRoute,
     }).done(function(data) {
         productsExists = data['data'];
         //Agrega productos existentes a tabla 
         for (var key in productsExists) {
            var productColumn = '';
            var priceBig = new Big(productsExists[key]['price']);
            var amountBig = new Big(productsExists[key]['amount']);
            var subtotal = priceBig.times(amountBig);

             if (productsExists[key]['productName'] != null) {
                 productColumn = productsExists[key]['typeProduct'] + ' ' + productsExists[key]['productName'];
             } else {
                 productColumn = 'Promoción' + ' ' + productsExists[key]['promotionName'];
             }
             saleDetailsTable.row.add([productsExists[key]['id'],
                 productColumn, productsExists[key]['amount'], productsExists[key]['price'], subtotal.toString()
             ]).draw(false);
             total = total + productsExists[key]['price'] * productsExists[key]['amount'];
             $("#total").val(total);
         }
     });

     var productTable = $('#productTable').DataTable({
         "language": {
             "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
         },
         "processing": true,
         //"serverSide": true,
         "ajax": productsRoute,
         "deferRender": true,
         "bAutoWidth": false,
         "columns": [{
                 "targets": 0,
                 "data": function(row, aoData, fnCallback) {
                     return row['typeProduct'] + ' ' + row['name'];
                 }
             },
             {
                 data: 'price',
                 name: 'products.price'
             },
             {
                 visible: false,
                 data: 'id',
                 name: 'products.id'
             },
         ],
         "rowId": 'name',
         "select": true,
         "dom": 'Bfrtip',

     });

     var promotionTable = $('#promotionTable').DataTable({
         "language": {
             "url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
         },
         "processing": true,
         //"serverSide": true,
         "ajax": promotionsRoute,
         "deferRender": true,
         "bAutoWidth": false,
         "columns": [{
                 data: 'name',
                 name: 'promotion.name'
             },
             {
                 data: 'price',
                 name: 'promotion.price'
             },
             {
                 visible: false,
                 data: 'id',
                 name: 'promotion.id'
             }
         ],
         "rowId": 'name',
         "select": true,
         "dom": 'Bfrtip',
     });

     saleDetailsTable.MakeCellsEditable({
         "onUpdate": updateSale,
         "inputCss": 'my-input-class',
         "columns": [2],
         "allowNulls": {
             "columns": [2],
             "errorClass": 'error'
         },
         "confirmationButton": {
             "confirmCss": 'my-confirm-class',
             "cancelCss": 'my-cancel-class'
         },
         "inputTypes": [{
             "column": 2,
             "type": "number",
             "options": null
         }]
     });

     //Borra la fila en la tabla
     $('#saleDetailsTable tbody').on('click', 'button', function() {
         if (confirm("¿Esta seguro que desea eliminar esta promoción?")) {
             var data = saleDetailsTable.row($(this).parents('tr')).data();
             var id = data[0];
             var priceBig = new Big(data[3]);
             var amountBig = new Big(data[2]);
             var subtotal = priceBig.times(amountBig);
             var totalBig = new Big($("#total").val());
             total = total - data[2] * data[3];
             $("#total").val(totalBig.minus(subtotal).toString());

             //ve si el objeto que elimino es uno nuevo o ya existente
             var isNew = false;
             for (var key in promotionsNew) {
                 if ((promotionsNew[key]['id'] == id) && (isNew == false)) {
                     isNew = true;
                     delete promotionsNew[key];
                 }
             }
             for (var key in productsNew) {
                 if ((productsNew[key]['id'] == id) && (isNew == false)) {
                     isNew = true;
                     console.log(productsNew);
                     delete productsNew[key];
                     console.log(productsNew);
                 }
             }
             if (!isNew) {
                 var product = {
                     id: id
                 };
                 //Ver este código se repite TODO
                 if (data[1].substring(0, 9) == 'Promoción') {
                     promotionsDelete.push(product);
                 } else {
                     productsDelete.push(product);
                 }
             }
             saleDetailsTable.row($(this).parents('tr')).remove().draw();
         }
     });

    $('#closeProduct').on('click', function() {
        //limpia modelo
        $("#amountProduct").val('');
        productTable.rows('tr.selected').deselect();
        $("#errorModalProduct").addClass('hidden');
        $('#modalAddProduct').modal('toggle');
    });

    $('#closePromotion').on('click', function() {
        //limpia modelo
        $("#amountPromotion").val('');
        promotionTable.rows('tr.selected').deselect();
        $("#errorModalPromotion").addClass('hidden');
        $('#modalAddPromotion').modal('toggle');
    });

     $('#addProduct').on('click', function() {
         var errorsProduct = [];
         var rowData = productTable.rows('.selected').data()[0];
         //Valida que todos los datos están ingresados
        if (parseInt($("#amountProduct").val()) < 1) {
            errorsProduct.push('El campo cantidad debe ser positivo')
        }
         if ($("#amountProduct").val() === '') {
             errorsProduct.push('El campo cantidad es requerido')
         }
         if ($('#productTable tbody tr.selected').length < 1) {
             errorsProduct.push('Seleccione un producto en la tabla')
         }
         if (errorsProduct.length > 0) {
             $('#listErrorModalProduct').empty();
             $("#errorModalProduct").removeClass('hidden');
             for (var i in errorsProduct) {
                 $("#errorModalProduct ul").append('<li><span>' + errorsProduct[i] + '</span></li>');
             }
         } else {
             $("#errorModalProduct").addClass('hidden');
             //Agrega en la tabla de detalle de promoción los datos seleccionados
            var priceBig = new Big(rowData['price']);
            var amountProductBig = new Big($("#amountProduct").val());
            var subtotal = priceBig.times(amountProductBig);
             saleDetailsTable.row.add([
                 rowData['id'],
                 rowData['typeProduct'] + ' ' + rowData['name'],
                 $("#amountProduct").val(),
                 rowData['price'], subtotal.toString()
             ]).draw(false);
             var product = {
                 id: rowData['id'],
                 amount: $("#amountProduct").val(),
                 price: rowData['price']
             };
             productsNew.push(product);

             //limpia modelo
             $("#amountProduct").val('');
             productTable.rows('tr.selected').deselect();
             $('#modelAddProduct').modal('toggle');
             var totalBig = new Big($("#total").val());
             $("#total").val(subtotal.plus(totalBig).toString());
         }
     });

     $('#addPromotion').on('click', function() {
         var errorsPromotion = [];
         var rowData = promotionTable.rows('.selected').data()[0];
         //Valida que todos los datos están ingresados
        if (parseInt($("#amountPromotion").val()) < 1) {
            errorsPromotion.push('El campo cantidad debe ser positivo')
        }
         if ($("#amountPromotion").val() === '') {
             errorsPromotion.push('El campo cantidad es requerido')
         }
         if ($('#promotionTable tbody tr.selected').length < 1) {
             errorsPromotion.push('Seleccione un producto en la tabla')
         }
         console.log(errorsPromotion);
         if (errorsPromotion.length > 0) {
             $('#listErrorModalPromotion').empty();
             $("#errorModalPromotion").removeClass('hidden');
             for (var i in errorsPromotion) {
                 $("#errorModalPromotion ul").append('<li><span>' + errorsPromotion[i] + '</span></li>');
             }
         } else {
             $("#errorModalPromotion").addClass('hidden');

             //Agrega en la tabla de detalle de promoción los datos seleccionados
             var priceBig = new Big(rowData['price']);
             var amountPromotionBig = new Big($("#amountPromotion").val());
             var subtotal = priceBig.times(amountPromotionBig);
             saleDetailsTable.row.add([
                 rowData['id'],
                 'Promoción' + ' ' + rowData['name'],
                 $("#amountPromotion").val(),
                 rowData['price'], subtotal.toString()
             ]).draw(false);
             var product = {
                 id: rowData['id'],
                 amount: $("#amountPromotion").val(),
                 price: rowData['price']
             };
             promotionsNew.push(product);

             //limpia modelo
             $("#amountPromotion").val('');
             productTable.rows('tr.selected').deselect();
             $('#modelAddPromotion').modal('toggle');
             var totalBig = new Big($("#total").val());
             $("#total").val(subtotal.plus(totalBig).toString());
         }
     });

 });

 function updateSale(updatedCell, updatedRow, oldValue) {
     var id = updatedRow.data()[0];
     var amount = updatedRow.data()[2];
     var data = updatedRow.data();
     var priceBig = new Big(data[3]);
     var amountBig = new Big(amount);
     var oldValueBig = new Big(oldValue);
     var subtotal = priceBig.times(amountBig);

     //Actualiza el subtotal
     data[4] = subtotal.toString();
     updatedRow.data(data).draw();

     //Actualiza el total
     var incrementBig = new Big(amountBig.minus(oldValueBig));
     var subtotal = incrementBig.times(priceBig);
     var totalBig = new Big($("#total").val());
     $("#total").val(subtotal.plus(totalBig).toString());

     if (updatedRow.data()[1].substring(0, 9) == 'Promoción') {
         //Si no existe en el array promotionsUpdate, lo agrega. Caso contrario, solo actualiza el precio
         var isNew = false;
         for (var key in promotionsUpdate) {
             if (promotionsUpdate[key]['id'] == id) {
                 isNew = true;
                 promotionsUpdate[key]['newValue'] = amount;
             }
         }
         if (!isNew) {
             var product = {
                 newValue: amount,
                 id: id
             };
             promotionsUpdate.push(product);
         }

         //En caso que exista en una nueva promoción agregada, actualiza su valor
         for (var key in promotionsNew) {
             if (promotionsNew[key]['id'] == id) {
                 promotionsNew[key]['amount'] = amount;
             }
         }
     } else {
         //Si no existe en el array productsUpdate, lo agrega. Caso contrario, solo actualiza el precio
         var isNew = false;
         for (var key in productsUpdate) {
             if (productsUpdate[key]['id'] == id) {
                 isNew = true;
                 productsUpdate[key]['newValue'] = amount;
             }
         }
         if (!isNew) {
             var product = {
                 newValue: amount,
                 id: id
             };
             productsUpdate.push(product);
         }

         //En caso que exista en un nuevo producto agregada, actualiza su valor
         for (var key in productsNew) {
             if (productsNew[key]['id'] == id) {
                 productsNew[key]['amount'] = amount;
             }
         }
     }
 }