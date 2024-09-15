import './bootstrap';
import $ from 'jquery';

$(document).ready(function() {
    $(document).on('click', '.show-pass', function() {
        var input = $(this).parent().find('input');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            $(this).addClass('active');
        } else {
            input.attr('type', 'password');
            $(this).removeClass('active');
        }
    });
});














