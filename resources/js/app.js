import './bootstrap';
import $ from 'jquery';
import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';
import Swal from 'sweetalert2';


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




