import $ from 'jquery';
import Swal from 'sweetalert2';

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

$(document).on('click', '.warning-row', function(e) {

    e.preventDefault();

    let url = $(this).attr('href');

    swal.fire({
        title: 'Êtes-vous sûr(e) de vouloir effectuer cette action ?',
        text: "Cette action est cependant réversible !",
        icon: 'warning',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });

});

window.Swal = Swal;

export default swal;