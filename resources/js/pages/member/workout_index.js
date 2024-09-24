import swal from '../../plugins/swal';
import notyf from '../../plugins/notyf';

let reduction;
let workout_price = $("#wizard_selection").data('workout-price');
let workouts = 1;

let cartContainer = $("#wizard-cart-list");
let cartWorkouts = cartContainer.find('#cart-workouts');
let cartReduction = cartContainer.find('#cart-reduction');
let cartTotal = cartContainer.find('#cart-total');

let AddWorkoutButton = $('#wizard-workout-increment');
let RemoveWorkoutButton = $('#wizard-workout-decrement');
let WorkoutDisplayText = $("#workout-display-text");
let WorkoutDisplayPrice = $("#workout-display-price");

let cartReductionForm = $('#cart-reduction-form');
let cartPaymentForm = $('#cart-payment-form');

let cartPaymentFormInputWorkouts = cartPaymentForm.find('input[type="hidden"]#workouts');
let cartPaymentFormInputReduction = cartPaymentForm.find('input[type="hidden"]#reduction_id');
let cartPaymentFormInputTotalPrice = cartPaymentForm.find('input[type="hidden"]#total_price');

let cartPricingValue = 0;

$(document).ready(function() {

    // On retourne à la première étape du wizard #wizard-selection
    setTimeout(function() {
        $('#smartwizard').smartWizard("goToStep", 0);
        $("#smartwizard").find('.nav-link').removeClass('done');
        RemoveWorkoutButton.prop('disabled', true);
        enableFormButton();
        enableReductionButton();
    }, 0);
        
 
    // Ajout d'une séance 
    $(document).on('click', '#wizard-workout-increment', function() {
        workouts++;
        updateCartWorkoutList();

        if(workouts > 1) {
            RemoveWorkoutButton.prop('disabled', false);
        }
    });

    // Suppression d'une séance
    $(document).on('click', '#wizard-workout-decrement', function() {
        if(workouts > 1) {
            workouts--;
            updateCartWorkoutList();

            if(workouts === 1) {
                RemoveWorkoutButton.prop('disabled', true);
            }

        } else {
            notyf.error('Vous devez sélectionner au moins une séance.');
        }
    });
    
   

    // Ajout de la réduction - DONE
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

    // Suppression de la réduction - DONE
    $(document).on('click', '#cart-reduction-remove', function() {
        reduction = null;
        updateCartReductionList();
        $("#cart-reduction-form").css('display', 'block');
        $(this).css('display', 'none');
    })

    // Validation du formulaire de paiement
    $(document).on('submit', '#cart-payment-form', function(e) {
        disableFormButton();
        disableReductionButton();
    });

    // Validation avant de changer d'étape
    $('#smartwizard').on("leaveStep", function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
        // Si on essaie de quitter la première étape sans avoir sélectionné d'abonnement
        if (currentStepIndex === 0 && workouts === 0) {
            swal.fire({
                icon: 'error',
                title: 'Sélection de séance',
                text: 'Veuillez sélectionner au moins une séance pour continuer.',
                showConfirmButton: false,
                showCancelButton: false,
                timer: 2500
            });
            return false;  // Bloquer la navigation si aucune sélection
        }

        updateCartWorkoutList();
    });
    
});


function updateCartWorkoutList() {
    WorkoutDisplayText.text(workouts);
    WorkoutDisplayPrice.text(workouts * workout_price + ' €');
    cartWorkouts.find('.subtitle').text(workouts + ' séance' + (workouts > 1 ? 's' : ''));
    cartWorkouts.find('.price').text(workouts * workout_price + ' €');
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

function enableFormButton() {
    cartPaymentForm.find('button[type="submit"]').prop('disabled', false);
    cartPaymentForm.find('span.span-form-text').css('display', 'flex');
    cartPaymentForm.find('span.span-form-loader').hide();
}

function disableFormButton() {
    cartPaymentForm.find('button[type="submit"]').prop('disabled', true);
    cartPaymentForm.find('span.span-form-text').hide();
    cartPaymentForm.find('span.span-form-loader').show();
}

function updatePrice() {
    cartPricingValue = workouts * workout_price;
    
    if(reduction) {
        cartPricingValue = cartPricingValue - (cartPricingValue * reduction.percentage / 100);
    }

    // Mise à jour du prix total à deux décimales
    cartPricingValue = Math.round(cartPricingValue * 100) / 100;

    let total = cartPricingValue;
    cartTotal.find('.price').text(total + ' €');

    // Mise à jour des valeurs du formulaire de paiement
    cartPaymentFormInputWorkouts.val(workouts);
    cartPaymentFormInputReduction.val(reduction ? reduction.id : '');
    cartPaymentFormInputTotalPrice.val(total);
}