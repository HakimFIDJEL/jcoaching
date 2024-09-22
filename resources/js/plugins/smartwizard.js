$(document).ready(function() {
    $("#smartwizard").smartWizard({
        selected : 0,  // Première étape sélectionnée
        showStepURLhash: false,  // Désactiver le hash dans l'URL
        toolbarSettings: {
            toolbarPosition: 'bottom',  // Position des boutons (top, bottom, both)
            toolbarButtonPosition: 'right',  // Position des boutons (left, right)
            showNextButton: true,  // Montrer le bouton Suivant
            showPreviousButton: true,  // Montrer le bouton Précédent
            toolbarExtraButtons: []  // Pas de boutons supplémentaires ici
        },
        lang: {  // Personnalisation des textes des boutons
            next: 'Suivant',  // Texte pour le bouton Suivant
            previous: 'Précédent'  // Texte pour le bouton Précédent
        },
        anchorSettings: {
            anchorClickable: false,  // Désactiver la navigation par clic sur les onglets
            enableAllAnchors: false,  // Empêcher la navigation vers les étapes non validées
        },
    });
});