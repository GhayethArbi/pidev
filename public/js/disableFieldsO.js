document.addEventListener('DOMContentLoaded', function () {
    var totalcaloriesField = document.querySelector('.total-calories-field');
    var totaldureeField = document.querySelector('.total-duree-field');

    function validateRegEx(field, regex) {
        return regex.test(field.value.trim());
    }

    function updateFieldValidity(field, isValid) {
        if (isValid) {
            field.style.borderColor = 'green';
            field.style.borderWidth = '2px';
        } else {
            field.style.borderColor = 'red';
            field.style.borderWidth = '2px';
        }
    }

    function validatecaloriesField() {
        var regex = /^\d+$/;
        var isValid = validateRegEx(totalcaloriesField, regex);
        updateFieldValidity(totalcaloriesField, isValid);
    }

    function validatedureeField() {
        var regex = /^\d+$/;
        var isValid = validateRegEx(totaldureeField, regex);
        updateFieldValidity(totaldureeField, isValid);
    }

    totalcaloriesField.addEventListener('input', validatecaloriesField);
    totaldureeField.addEventListener('input', validatedureeField);
});
