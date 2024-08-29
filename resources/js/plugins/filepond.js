// FilePond
import * as FilePond from 'filepond';
import 'filepond/dist/filepond.min.css';
// FilePond plugins
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import FilePondPluginImageExifOrientation from 'filepond-plugin-image-exif-orientation';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginImageEdit from 'filepond-plugin-image-edit';
import 'filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css';
// jQuery
import { error } from 'jquery';

// Configuration de FilePond
FilePond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginImageExifOrientation,
    FilePondPluginFileValidateSize,
    FilePondPluginImageEdit
)

document.addEventListener('DOMContentLoaded', function() {
    // Sélectionner tous les éléments `input[type="file"].filepond`
    const inputElements = document.querySelectorAll('input[type="file"].filepond');

    
    
    // Boucler sur chaque élément pour créer une instance de FilePond
    inputElements.forEach(inputElement => {
        // const mediaPath = inputElement.dataset.mediaPath;
        // const mediaFilename = inputElement.dataset.mediaFilename;

        const preloadedDocuments = inputElement.dataset.documents ? JSON.parse(inputElement.dataset.documents) : [];

        FilePond.create(inputElement, {
            instantUpload: false,
            server: {
                load: (source, load, error, progress, abort, headers) => {
                    // if (mediaPath) {
                    //     fetch(mediaPath)
                    //         .then(res => res.blob())
                    //         .then(blob => {
                    //             const file = new File([blob], mediaFilename, { type: blob.type });
                    //             load(file);
                    //         });
                    // }

                    if(preloadedDocuments.length > 0) {
                        const file = preloadedDocuments.find(file => file.source === source);
                        if (file) {
                            load(file);
                        }
                    }
                },
            },
            files: preloadedDocuments,
            allowMultiple: inputElement.dataset.maxFiles > 1,  // Permettre plusieurs fichiers si spécifié
            maxFiles: inputElement.dataset.maxFiles || 1,
            storeAsFile: true,
            

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
    });
});

// document.addEventListener('DOMContentLoaded', function() {


//     const inputElement = document.querySelector('input[type="file"].filepond');
//     const mediaPath = inputElement.dataset.mediaPath;
//     const mediaFilename = inputElement.dataset.mediaFilename;

    
//     var pond = FilePond.create(document.querySelector('input[type="file"].filepond'), {
//         instantUpload: false,
//         server: {
//             load: (source, load, error, progress, abort, headers) => {
//                 fetch(mediaPath)
//                     .then(res => res.blob())
//                     .then(blob => {
//                         // Créer un File object à partir du Blob
//                         const file = new File([blob], mediaFilename, { type: blob.type });
//                         load(file);
//                     });
//             },
//         },
//         files: mediaPath ? [{
//             source: mediaPath,
//         }] : [],
//         allowMultiple: false,
//         maxFiles: 1,
//         storeAsFile: true,
        
       


//         labelIdle: `Déposez vos fichiers ou <span class="filepond--label-action"> Parcourir </span>`,
//         labelInvalidField: "Le champ contient des fichiers invalides",
//         labelFileWaitingForSize: "En attente de taille",
//         labelFileSizeNotAvailable: "Taille non disponible",
//         labelFileLoading: "Chargement",
//         labelFileLoadError: "Erreur pendant le chargement",
//         labelFileProcessing: "Chargement",
//         labelFileProcessingComplete: "Chargement terminé",
//         labelFileProcessingAborted: "Chargement annulé",
//         labelFileProcessingError: "Erreur pendant le chargement",
//         labelFileProcessingRevertError: "Erreur pendant la restauration",
//         labelFileRemoveError: "Erreur pendant la suppression",
//         labelTapToCancel: "appuyez pour annuler",
//         labelTapToRetry: "appuyez pour réessayer",
//         labelTapToUndo: "appuyez pour annuler",
//         labelButtonRemoveItem: "Supprimer",
//         labelButtonAbortItemLoad: "Annuler",
//         labelButtonRetryItemLoad: "Réessayer",
//         labelButtonAbortItemProcessing: "Annuler",  
//         labelButtonUndoItemProcessing: "Annuler",
//         labelButtonRetryItemProcessing: "Réessayer",
//         labelButtonProcessItem: "Charger",
//     });

//     pond.on('processfile', (error, file) => {
//         if (error) {
//             console.error('File processing failed', error);
//         } else {
//             console.log('File processing complete', file);
//         }
//     });


// });


