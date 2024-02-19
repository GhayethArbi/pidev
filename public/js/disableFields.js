

document.addEventListener('DOMContentLoaded', function () {
    var nomActiviteField = document.querySelector('.nom-activite-field')
    var typeActiviteField = document.querySelector('.type-activite-field');
    var caloriesField = document.querySelector('.calories-field');
    var dureeField = document.querySelector('.duree-field');
    var nbSerieField = document.querySelector('.nb-series-field');
    var nbRepSerieField = document.querySelector('.nb-rep-series-field');
    var poidsSerieField = document.querySelector('.poids-par-serie-field');
    var originalBorderColorCalories = window.getComputedStyle(caloriesField).borderColor;
    var originalBorderColorDuree = window.getComputedStyle(dureeField).borderColor;
    var totalCaloriesField = document.querySelector('.total-calories-field');
    var totalDureeField = document.querySelector('.total-duree-field');

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
    function validateTotalCaloriesField() {
        var regex = /^\d+$/;
        var isValid = validateRegEx(totalCaloriesField, regex);
        updateFieldValidity(totalCaloriesField, isValid);
    }

    function validateTotalDureeField() {
        var regex = /^\d+$/;
        var isValid = validateRegEx(totalDureeField, regex);
        updateFieldValidity(totalDureeField, isValid);
    }
    function validatecaloriesField() {
        var regex = /^\d+$/;
        var isValid = validateRegEx(caloriesField, regex);
        updateFieldValidity(caloriesField, isValid);
    }

    function validatedureeField() {
        var regex = /^\d+$/;
        var isValid = validateRegEx(dureeField, regex);
        updateFieldValidity(dureeField, isValid);
    }

    function validatenomField() {
        var regex = /^[a-zA-Z]+$/;
        var isValid = validateRegEx(nomActiviteField, regex);
        updateFieldValidity(nomActiviteField, isValid);
    }

    function validateNbSerieField() {
        var regex = /^\d+$/;
        var isValid = validateRegEx(nbSerieField, regex);
        updateFieldValidity(nbSerieField, isValid);
    }

    function validateNbRepSerieField() {
        var regex = /^\d+$/;
        var isValid = validateRegEx(nbRepSerieField, regex);
        updateFieldValidity(nbRepSerieField, isValid);
    }

    function validatePoidsSerieField() {
        var regex = /^\d+$/;
        var isValid = validateRegEx(poidsSerieField, regex);
        updateFieldValidity(poidsSerieField, isValid);
    }

    caloriesField.addEventListener('input', validatecaloriesField);
    nomActiviteField.addEventListener('input', validatenomField);
    dureeField.addEventListener('input', validatedureeField);
    nbSerieField.addEventListener('input', validateNbSerieField);
    nbRepSerieField.addEventListener('input', validateNbRepSerieField);
    poidsSerieField.addEventListener('input', validatePoidsSerieField);
    totalCaloriesField.addEventListener('input', validateTotalCaloriesField);
    totalDureeField.addEventListener('input', validateTotalDureeField);

    function disableFieldsBasedOnActivityType() {
        var selectedType = typeActiviteField.value;
        if (selectedType === 'musculation') {
            caloriesField.value = "";
            caloriesField.style.borderColor = originalBorderColorCalories;
            dureeField.value = "";
            dureeField.style.borderColor = originalBorderColorDuree;
            caloriesField.disabled = true;
            dureeField.disabled = true;
            nbSerieField.disabled = false;
            nbRepSerieField.disabled = false;
            poidsSerieField.disabled = false;
        } else {
            caloriesField.disabled = false;
            dureeField.disabled = false;
            nbSerieField.value = "";
            nbRepSerieField.value = "";
            poidsSerieField.value = "";
            nbSerieField.disabled = true; // don    
            nbRepSerieField.disabled = true;
            poidsSerieField.disabled = true;
        }
    };
    typeActiviteField.addEventListener('change', disableFieldsBasedOnActivityType);
});
