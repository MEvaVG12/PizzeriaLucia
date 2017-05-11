//Definición de la configuración del datapicker
$('#dp').datepicker({
    format: "dd/mm/yy",
    language: "es",
    daysOfWeekDisabled: "0",
    autoclose: true,
    todayHighlight: true,
    startDate: '+0d'
});

//mostrar fecha actual
var today = new Date();
document.getElementById('date').value = today.getDate() + "/" + (today.getMonth() + 1) + "/" + today.getFullYear();
$("#dp").datepicker().datepicker("setDate", today);

//mostrar hora actual
h = "" + today.getHours();
if (h < 10) {
    h = "0" + h
}
m = "" + today.getMinutes();
if (m < 10) {
    m = "0" + m
}
document.getElementById('time').value = h + ":" + m;
document.getElementById('timeP').value = h + ":" + m;