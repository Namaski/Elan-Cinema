// AJUST SELECT NAME

let inputs = document.querySelector('.form-select');

inputs.onchange = function() {

    let empty = false;

    if (inputs.value == '') {
        empty = true;

    }

    if (!empty) {
        console.log('submitting');

        // ADJUST FORM NAME
        // document.forms[0].submit();
    }

}
