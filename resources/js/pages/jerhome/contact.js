$(document).ready(function() {    

    $(document).on('submit', '#contactForm', function(e) {
        let button = $(this).find('button[type="submit"]');

        button.prop('disabled', true);
        button.find('#btnText').remove();
        button.find('#btnSpinner').show();
    });
});