document.addEventListener('DOMContentLoaded', function () {
    // Définition des variables pour les champs de formulaire
    var nomActiviteField = document.querySelector('.nom-activite-field');
    var typeActiviteField = document.querySelector('.type-activite-field');
    var caloriesField = document.querySelector('.calories-field');
    var dureeField = document.querySelector('.duree-field');
    var nbSerieField = document.querySelector('.nb-series-field');
    var nbRepSerieField = document.querySelector('.nb-rep-series-field');
    var poidsSerieField = document.querySelector('.poids-par-serie-field');
    
    // Définition des couleurs de bordure initiales pour les champs de calories et de durée
    var originalBorderColorCalories = window.getComputedStyle(caloriesField).borderColor;
    var originalBorderColorDuree = window.getComputedStyle(dureeField).borderColor;

    // Fonction pour valider le champ avec une expression régulière
    function validateRegEx(field, regex) {
        return regex.test(field.value.trim());
    }

    // Fonction pour mettre à jour la validité du champ
    function updateFieldValidity(field, isValid) {
        if (isValid) {
            field.style.borderColor = 'green';
            field.style.borderWidth = '3px';
        } else {
            field.style.borderColor = 'red';
            field.style.borderWidth = '3px';
        }
    }
   
    // Fonctions de validation pour chaque champ
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

    // Ajout des écouteurs d'événements pour chaque champ
    caloriesField.addEventListener('input', validatecaloriesField);
    nomActiviteField.addEventListener('input', validatenomField);
    dureeField.addEventListener('input', validatedureeField);
    nbSerieField.addEventListener('input', validateNbSerieField);
    nbRepSerieField.addEventListener('input', validateNbRepSerieField);
    poidsSerieField.addEventListener('input', validatePoidsSerieField);

    // Fonction pour désactiver les champs basés sur le type d'activité sélectionné
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
            nbSerieField.disabled = true;   
            nbRepSerieField.disabled = true;
            poidsSerieField.disabled = true;
        }
    }

    // Appel de la fonction lors du chargement de la page pour vérifier le type d'activité
    disableFieldsBasedOnActivityType();

    // Ajout de l'écouteur d'événement pour détecter les changements dans le type d'activité
    typeActiviteField.addEventListener('change', disableFieldsBasedOnActivityType);
});
