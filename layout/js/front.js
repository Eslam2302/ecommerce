$(function() {
    'use strict';

    // Login / Signup Selection

    $('.login-page h1 span').click(function() {

        $(this).addClass('selected').siblings().removeClass('selected');

        $('.login-page .card').hide();

        $('.' + $(this).data('class')).fadeIn(100);

    });


    // Hide Placeholder on focus

    $('[placeholder]').focus(function () {

        $(this).attr('data-text', $(this).attr('placeholder'));     // Storage placeholder in data text
        $(this).attr('placeholder', '');                            // Remove placeholder with none

    }).blur(function () {

        $(this).attr('placeholder', $(this).attr('data-text'));     // In Blur we get placeholder again 

    })

    // Confirmation Message Before Delete User

    $('.confirm').click(function () {

        return confirm('Are U Sure?');

    });


    // Item Preview While Create New Ad

    $('.live-name').keyup(function () {

        $('.live-preview .caption h3').text($(this).val());

    });

    $('.live-desc').keyup(function () {

        $('.live-preview .caption p').text($(this).val());

    });

    $('.live-price').keyup(function () {

        $('.live-preview span').text($(this).val() + '$');

    });




})