// public/js/disableFields.js

document.addEventListener('DOMContentLoaded', function() {
    var typeActiviteField = document.querySelector('.type-activite-field');
    var caloriesField = document.querySelector('.calories-field');
    var dureeField = document.querySelector('.duree-field');
    var nbSerieField = document.querySelector('.nb-series-field');
    var nbRepSerieField = document.querySelector('.nb-rep-series-field');
    var poidsSerieField = document.querySelector('.poids-par-serie-field');

    function validateRegEx(field, regex) {
       return regex.test(field.value.trim()) ; 
    }

    function updateFieldValidity(field, isValid) {
        if (isValid) {
            field.style.borderColor = 'green';
        } else {
            field.style.borderColor = 'red';
        }
    }

    function validateAndStyleField() {
        var regex =/^\d+$/ ; 
        var isValid = validateRegEx(caloriesField,regex) ;
        updateFieldValidity(caloriesField, isValid);
    }

    caloriesField.addEventListener('input', validateAndStyleField);

    function disableFieldsBasedOnActivityType(){
        var selectedType = typeActiviteField.value;
        if (selectedType === 'musculation') {
            caloriesField.value = "" ;
            dureeField.value="" ; 
            caloriesField.disabled = true;
            dureeField.disabled = true;
            nbSerieField.disabled = false; 
            nbRepSerieField.disabled=false; 
            poidsSerieField.disabled = false; 
        } else {  
            caloriesField.disabled = false;
            dureeField.disabled = false;
            nbSerieField.value="";
            nbRepSerieField.value="";
            poidsSerieField.value="";
            nbSerieField.disabled = true; // don    
            nbRepSerieField.disabled=true; 
            poidsSerieField.disabled = true; 
        }
    };
    typeActiviteField.addEventListener('change', disableFieldsBasedOnActivityType);
});
