import './bootstrap';
import $ from 'jquery';
import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';
import Swal from 'sweetalert2';
// CkeEditor5
import { ClassicEditor, Essentials, Bold, Italic, Font, Paragraph } from 'ckeditor5';
import 'ckeditor5/ckeditor5.css';


// Configuration de ckEditor5
ClassicEditor
    .create(document.querySelector('textarea.editor'), {
        plugins: [ Essentials, Bold, Italic, Font, Paragraph ],
        toolbar: {
            items: [
                'undo', 'redo', '|', 'bold', 'italic', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
            ]
        },
        // Font color is var(--bs-body-color)
        fontColor: {
            colors: [
                {
                    color: 'var(--bs-body-color)',
                    label: 'Body Color'
                }
            ]
        },
        // Font background color is var(--bs-body-bg)
        fontBackgroundColor: {
            colors: [
                {
                    color: 'transparent',
                    label: 'Body Background'
                }
            ]
        },
        // Configuration de la police
        fontFamily: {
            options: [
                'Raleway, sans-serif',
            ]
        },
    }).then(editor => {
        window.editor = editor;

        const ckeditor = editor.ui.view.element;
        const editorElement = editor.ui.getEditableElement();

        editorElement.addEventListener('focus', () => {
            ckeditor.classList.add('border-primary');
        });

        editorElement.addEventListener('blur', () => {
            ckeditor.classList.remove('border-primary');
        });

    }).catch(error => {
        console.error(error);
    });


// Configuration de Notyf
const notyf = new Notyf({
    duration: 3000, 
    position: {
        x: 'right', 
        y: 'top',  
    },
    ripple: false,
    dismissible: true,  
    types: [
        {
            type: 'success',
            background: '#090909',
            className: 'notyf-success border-success border', 
            icon: false, 
            color: '#dddddd',
        },
        {
            type: 'error',
            background: '#090909',
            className: 'notyf-error border-danger border', 
            icon: false,
            color: '#dddddd',
        },
    ],
    background: '#090909',  // Couleur de fond par défaut (sera remplacée par les types)
    icon: {
        className: 'custom-icon', 
        tagName: 'span',  
        color: '#dddddd'    
    }
});

// Configuration de SweetAlert2
const swal = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-outline-secondary',
    },
    showCancelButton: true,
    background: 'var(--bs-body-bg)',
    color: 'var(--bs-body-color)',
    // text
    confirmButtonText: 'Je valide',
    cancelButtonText: 'Annuler',
    focusConfirm: false,
    focusCancel: true,
});

$(document).on('click', '.delete-row', function(e) {

    e.preventDefault();

    let url = $(this).attr('href');

    swal.fire({
        title: 'Êtes-vous sûr(e) de vouloir supprimer cet élément ?',
        text: "Cette action est irréversible !",
        icon: 'warning',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });

});

window.Swal = Swal;
window.notyf = notyf;




