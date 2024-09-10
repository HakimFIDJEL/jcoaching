$(document).ready(function() {
    $(document).on('change', '#workout-all', function() {
        if ($(this).is(':checked')) {
            $('.workout').prop('checked', true);
        } else {
            $('.workout').prop('checked', false);
        }
    });
});