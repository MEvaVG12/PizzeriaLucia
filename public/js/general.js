//Permite ingresar solo números
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}


function isDecimal(key, value) {
    //getting key code of pressed key
    var keycode = (key.which) ? key.which : key.keyCode;
    //comparing pressed keycodes
    if (keycode > 31 && (keycode < 48 || keycode > 57) && keycode != 46) {
        return false;
    } else {
        if (keycode === 46) {
            if (value.split('.').length > 1) {
                return false;
            }
        }
    }
    return true;
}