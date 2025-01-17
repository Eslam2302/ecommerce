$(function() {
    'use strict';

    // Hide Placeholder on focus

    $('[placeholder]').focus(function () {

        $(this).attr('data-text', $(this).attr('placeholder'));     // Storage placeholder in data text
        $(this).attr('placeholder', '');                            // Remove placeholder with none

    }).blur(function () {

        $(this).attr('placeholder', $(this).attr('data-text'));     // In Blur we get placeholder again 

    })

    // Convert Password field to text on hover

    var passField = $('.password');

    $('.show-pass').hover(function () {

        passField.attr('type', 'text');

    }, function () {

        passField.attr('type', 'password');

    });

    // Confirmation Message Before Delete User

    $('.confirm').click(function () {

        return confirm('Are U Sure?');

    });

})