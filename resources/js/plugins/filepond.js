// FilePond
import * as FilePond from 'filepond';
import 'filepond/dist/filepond.min.css';
// FilePond plugins
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import FilePondPluginImageExifOrientation from 'filepond-plugin-image-exif-orientation';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginImageEdit from 'filepond-plugin-image-edit';
import { error } from 'jquery';

// Configuration de FilePond
FilePond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginImageExifOrientation,
    FilePondPluginFileValidateSize,
    FilePondPluginImageEdit
)

document.addEventListener('DOMContentLoaded', function() {
    const inputElement = document.querySelector('input[type="file"].filepond');
    const mediaPath = inputElement.dataset.mediaPath;
    const mediaFilename = inputElement.dataset.mediaFilename;

    
    var pond = FilePond.create(document.querySelector('input[type="file"].filepond'), {
        instantUpload: false,
        server: {
            load: (source, load, error, progress, abort, headers) => {
                fetch(mediaPath)
                    .then(res => res.blob())
                    .then(blob => {
                        // Créer un File object à partir du Blob
                        const file = new File([blob], mediaFilename, { type: blob.type });
                        load(file);
                    });
            },
        },
        files: mediaPath ? [{
            source: mediaPath,
        }] : [],
        allowMultiple: false,
        maxFiles: 1,
        storeAsFile: true,
        allowImagePreview: true,
        allowImageEdit: true,


        labelIdle: `Déposez vos fichiers ou <span class="filepond--label-action"> Parcourir </span>`,
        labelInvalidField: "Le champ contient des fichiers invalides",
        labelFileWaitingForSize: "En attente de taille",
        labelFileSizeNotAvailable: "Taille non disponible",
        labelFileLoading: "Chargement",
        labelFileLoadError: "Erreur pendant le chargement",
        labelFileProcessing: "Chargement",
        labelFileProcessingComplete: "Chargement terminé",
        labelFileProcessingAborted: "Chargement annulé",
        labelFileProcessingError: "Erreur pendant le chargement",
        labelFileProcessingRevertError: "Erreur pendant la restauration",
        labelFileRemoveError: "Erreur pendant la suppression",
        labelTapToCancel: "appuyez pour annuler",
        labelTapToRetry: "appuyez pour réessayer",
        labelTapToUndo: "appuyez pour annuler",
        labelButtonRemoveItem: "Supprimer",
        labelButtonAbortItemLoad: "Annuler",
        labelButtonRetryItemLoad: "Réessayer",
        labelButtonAbortItemProcessing: "Annuler",  
        labelButtonUndoItemProcessing: "Annuler",
        labelButtonRetryItemProcessing: "Réessayer",
        labelButtonProcessItem: "Charger",
    });

    pond.on('processfile', (error, file) => {
        if (error) {
            console.error('File processing failed', error);
        } else {
            console.log('File processing complete', file);
        }
    });

    // Écouteur d'événement pour le formulaire
    document.querySelector('form').addEventListener('submit', function(e) {
        // Assurez-vous que FilePond a terminé le traitement du fichier
        if (pond.getFile()) {
            // Le fichier est prêt à être envoyé
        } else {
            e.preventDefault(); // Empêche la soumission du formulaire si le fichier n'est pas prêt
            console.error('Aucun fichier n\'a été sélectionné');
        }

        const pondFiles = pond.getFiles();

        // Vérifier si le fichier est marqué pour être ignoré lors de la soumission
        if (pondFiles.length > 0 && pondFiles[0].getMetadata('skipSubmit')) {
            
        }

    });
});


