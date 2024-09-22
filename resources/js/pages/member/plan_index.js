import swal from '../../plugins/swal';

let pricing_id;
let nutrition_option = 0;

$(document).ready(function() {

    // On retourne à la première étape du wizard #wizard-selection
    setTimeout(function() {
        $('#smartwizard').smartWizard("goToStep", 0);
        $("#smartwizard").find('.nav-link').removeClass('done');
    }, 0);
        

    // Sélection d'un abonnement
    $(document).on('click', '.pricing-selection button', function() {
        let card = $(this).closest('.pricing-selection');
        
        // Ajouter la classe 'border-primary' à la card sélectionnée et la retirer des autres
        card.addClass('border-primary').siblings().removeClass('border-primary');
        
        // Récupérer l'ID du pricing sélectionné
        pricing_id = card.data('pricing-id');
        
        // Désactiver le bouton cliqué
        $(this).prop('disabled', true);
        
        // Réactiver les autres boutons dans toutes les autres cards
        $('.pricing-selection').not(card).find('button').prop('disabled', false);
    });

    // Sélection et désélection de l'option nutrition
    $(document).on('click', '.nutrition-selection button', function() {
        let card = $(this).closest('.nutrition-selection');

        if(nutrition_option == 0) {
            card.addClass('border-primary');
            $(this).text('Déselectionner');
            $(this).removeClass('btn-primary').addClass('btn-danger');
            nutrition_option = 1;
        } else {
            card.removeClass('border-primary');
            $(this).text('Sélectionner');
            $(this).removeClass('btn-danger').addClass('btn-primary');
            nutrition_option = 0;
        }
    });

    // Validation avant de changer d'étape
    $('#smartwizard').on("leaveStep", function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
        // Si on essaie de quitter la première étape sans avoir sélectionné d'abonnement
        if (currentStepIndex === 0 && !pricing_id) {
            swal.fire({
                icon: 'error',
                title: 'Sélection d\'abonnement',
                text: 'Veuillez sélectionner un abonnement avant de continuer.',
                showConfirmButton: false,
                showCancelButton: false,
                timer: 2500
            });
            return false;  // Bloquer la navigation si aucune sélection
        }
    });
    
});