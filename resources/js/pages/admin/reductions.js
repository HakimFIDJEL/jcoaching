$(document).ready(function() {
    var inputCode = $('#code');
    var generateCode = $('#generate-code');
    var clearCode = $('#clear-code');
    
    $(document).on('click', '#generate-code', function() {
        // generates a random string with 10 characters, numbers and capital letters
        var code = Math.random().toString(36).substring(2, 12).toUpperCase();
        inputCode.val(code);
        inputCode.focus();

        $(this).hide();
        clearCode.show();
    });

    $(document).on('click', '#clear-code', function() {
        inputCode.val('');
        inputCode.focus();

        $(this).hide();
        generateCode.show();
    });

    inputCode.on('input', function() {
        if ($(this).val() === '') {
            clearCode.hide();
            generateCode.show();
        } else {

            // Mettre en majuscule et enlever les espaces
            var code = $(this).val().toUpperCase().replace(/\s/g, '');
            $(this).val(code);

            generateCode.hide();
            clearCode.show();
        }
    });

    
});