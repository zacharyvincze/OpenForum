$(document).ready(function() {

    $("#register-form").on('submit', function(e) {
        $.ajax({
            type: 'post',
            url: '/ajax_register.php',
            data: $("#register-form").serialize(),
            success: function(html) {
                if(html == 'true') {
                    alert('Email was sent!');
                } else if(html == 'username_long') {
                    alert('The username must be less than 30 characters.');
                } else if(html == 'email_exists') {
                    alert('That email is already being used!');
                } else if(html == 'noenter') {
                    alert('Please fill in all fields.');
                } else if(html == 'username_exists') {
                    alert('The username already exists.');
                } else if(html == 'invalid_pass') {
                    alert('Passwords do not match.');
                } else if(html == 'recaptcha') {
                    alert('reCAPTCHA must be completed.');
                } else {
                    alert('There was a problem processing your request, try again later.');
                }
            }
        });
    });

});
