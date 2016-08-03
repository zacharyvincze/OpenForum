$(document).ready(function() {
    
    $("#register-form").on('submit', function(e) {
        $.ajax({
            type: 'post',
            url: '/ajax_register.php',
            data: $("#register-form").serialize(),
            success: function(html) {
                if(html == 'true') {
                    alert('Email was sent!');
                }
                
                else if(html == 'email_exists') {
                    alert('That email is already being used!');
                }
                
                else if(html == 'noenter') {
                    alert('Please fill in all fields.');
                }
                
                else if(html == 'username_exists') {
                    alert('The username also exists.');
                }
                
                else if(html == 'invalid_pass') {
                    alert('Passwords do not match.');
                }
                
                else {
                    alert(html);
                }
            }
        });
    });
    
});