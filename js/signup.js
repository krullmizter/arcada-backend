$(document).ready(function(){

    $('#navbar__login, #navbar__signup, #post__create, #post__edit').hide();
    
    $('#navbar__loginBtn').click(function() {
        $('#navbar__login').fadeIn();
        $('.overlay-login').width('100%');
    });

    $('.navbar__login-close').click(function() {
        $('#navbar__login').fadeOut();
        $('.overlay-login').width('0%');
    });

    $('#navbar__signupBtn').click(function() {
        $('#navbar__signup').fadeIn();
        $('.overlay-signup').width('100%');
    });

    $('.navbar__signup-close').click(function() {
        $('#navbar__signup').fadeOut();
        $('.overlay-signup').width('0%');
    });
});