document.addEventListener('DOMContentLoaded', function () {
    var caloriesTotalField = document.querySelector('.total-calories-field');
    var dureeTotalField = document.querySelector('.total-duree-field');

    function validateRegEx(field, regex) {
        return regex.test(field.value.trim());
    }

    function updateFieldValidity(field, isValid) {
        if (isValid) {
            field.style.borderColor = 'green';
            field.style.borderWidth = '3px';
        } else {
            field.style.borderColor = 'red';
            field.style.borderWidth = '3px';
        }
    }

    
    function validatecaloriesTotalField() {
        var regex = /^\d+$/;
        var isValid = validateRegEx(caloriesTotalField, regex);
        updateFieldValidity(caloriesTotalField, isValid);
    }

    function validatedureeTotalField() {
        var regex = /^\d+$/;
        var isValid = validateRegEx(dureeTotalField, regex);
        updateFieldValidity(dureeTotalField, isValid);
    }

    caloriesTotalField.addEventListener('input',validatecaloriesTotalField);
    dureeTotalField.addEventListener('input',validatedureeTotalField);
});