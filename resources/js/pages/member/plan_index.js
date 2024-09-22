import swal from '../../plugins/swal';
import notyf from '../../plugins/notyf';

let pricing;
let reduction;
let nutrition_price = $("#wizard_nutrition").data('nutrition-price');
let nutrition_option = 0;

let cartContainer = $("#wizard-cart-list");
let cartPricing = cartContainer.find('#cart-pricing');
let cartNutrition = cartContainer.find('#cart-nutrition');
let cartReduction = cartContainer.find('#cart-reduction');
let cartTotal = cartContainer.find('#cart-total');

let cartReductionForm = $('#cart-reduction-form');

let cartPaymentForm = $('#cart-payment-form');

let cartPaymentFormInputPricing = cartPaymentForm.find('input[type="hidden"]#pricing_id');
let cartPaymentFormInputNutrition = cartPaymentForm.find('input[type="hidden"]#nutrition_option');
let cartPaymentFormInputReduction = cartPaymentForm.find('input[type="hidden"]#reduction_id');
let cartPaymentFormInputTotalPrice = cartPaymentForm.find('input[type="hidden"]#total_price');

let cartPricingValue = 0;

$(document).ready(function() {

    // On retourne à la première étape du wizard #wizard-selection
    setTimeout(function() {
        $('#smartwizard').smartWizard("goToStep", 0);
        $("#smartwizard").find('.nav-link').removeClass('done');
    }, 0);
        
    // Sélection d'un abonnement - DONE
    $(document).on('click', '.pricing-selection button', function() {
        let card = $(this).closest('.pricing-selection');
        
        // Ajouter la classe 'border-primary' à la card sélectionnée et la retirer des autres
        card.addClass('border-primary').siblings().removeClass('border-primary');
        
        // Récupérer l'ID du pricing sélectionné
        pricing = card.data('pricing');
        
        // Désactiver le bouton cliqué
        $(this).prop('disabled', true);
        
        // Réactiver les autres boutons dans toutes les autres cards
        $('.pricing-selection').not(card).find('button').prop('disabled', false);

        updateCartPricingList(card.data('pricing'));
    });

    // Sélection et désélection de l'option nutrition - DONE
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

        updateCartNutritionList();
    });

    // Suppression de la réduction - DONE
    $(document).on('click', '#cart-reduction-remove', function() {
        reduction = null;
        updateCartReductionList();
        $("#cart-reduction-form").css('display', 'block');
        $(this).css('display', 'none');
    })

    // Soumission du formulaire de réduction - DONE
    $(document).on('submit', '#cart-reduction-form', function(e) {
        e.preventDefault();

        let form = $(this);
        let data = form.serialize();

        let button = form.find('button[type="submit"]');
        disableReductionButton();

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: data,
        })
        .done(function(response) {
            switch(response.status) {
                case 'success' :
                    reduction = response.reduction;
                    updateCartReductionList();
                    form.css('display', 'none');
                    $("#cart-reduction-remove").css('display', 'block');   
                break;
                case 'error' :
                        notyf.error(response.message);
                break;
                default :
                    notyf.error('Une erreur est survenue lors de la validation du code promo.');
                break;
            }
        })
        .fail(function(response) {
            if(response.responseJSON) {
                notyf.error(response.responseJSON.message ?? 'Une erreur est survenue !');
            } else {
                notyf.error('Une erreur est survenue !');
            }
        })
        .always(function() {
            form.find('input').val('');
            enableReductionButton();
        });

    });

    // Validation avant de changer d'étape
    $('#smartwizard').on("leaveStep", function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
        // Si on essaie de quitter la première étape sans avoir sélectionné d'abonnement
        if (currentStepIndex === 0 && !pricing) {
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

function updateCartPricingList(pricing) {
    cartPricing.find('.title').text(pricing.title);
    cartPricing.find('.subtitle').text(pricing.subtitle);
    cartPricing.find('.price').text(pricing.price + ' €');
    cartPricing.css('display', 'flex');

    updatePrice();
}

function updateCartNutritionList() {
    if(nutrition_option == 1) {
        cartNutrition.css('display', 'flex');
    } else {
        cartNutrition.hide();
    }

    updatePrice();
}


function updateCartReductionList() {
    if(reduction) {
        cartReduction.find('.subtitle').text(reduction.code);
        cartReduction.find('.price').text('-' + reduction.percentage + ' %');
        cartReduction.css('display', 'flex');
    } else {
        cartReduction.hide();
    }

    updatePrice();
}

function disableReductionButton() {
    cartReductionForm.find('button[type="submit"]').prop('disabled', true);
    cartReductionForm.find('span.cart-form-text').hide();
    cartReductionForm.find('span.cart-form-loader').show();
}

function enableReductionButton() {
    cartReductionForm.find('button[type="submit"]').prop('disabled', false);
    cartReductionForm.find('span.cart-form-text').show();
    cartReductionForm.find('span.cart-form-loader').hide();
}


function updatePrice() {
    if(nutrition_option == 1) {
        cartPricingValue = pricing.price + nutrition_price;
    } else {
        cartPricingValue = pricing.price;
    }
    
    if(reduction) {
        cartPricingValue = cartPricingValue - (cartPricingValue * reduction.percentage / 100);
    }

    // Mise à jour du prix total à deux décimales
    cartPricingValue = Math.round(cartPricingValue * 100) / 100;

    let total = cartPricingValue;
    cartTotal.find('.price').text(total + ' €');

    // Mise à jour des valeurs du formulaire de paiement
    cartPaymentFormInputPricing.val(pricing.id);
    cartPaymentFormInputNutrition.val(nutrition_option);
    cartPaymentFormInputReduction.val(reduction ? reduction.id : '');
    cartPaymentFormInputTotalPrice.val(total);
}