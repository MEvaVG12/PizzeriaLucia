//Definición de la configuración del datapicker
$('#dp').datepicker({
    language: "es",
    daysOfWeekDisabled: "0",
    autoclose: true,
    todayHighlight: true,
    startDate: '+0d'
});

var currentDate = new Date(deliveryDateTime);

//mostrar hora actual
h = "" + currentDate.getHours();
if (h < 10) {
    h = "0" + h
}
m = "" + currentDate.getMinutes();
if (m < 10) {
    m = "0" + m
}

document.getElementById('time').value = h + ":" + m;
$("#dp").datepicker().datepicker("setDate", currentDate);