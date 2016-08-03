$(document).ready(function() {
   $("#login-form").on('submit', function(e) {
       
       $.ajax({
           type: 'post',
           url: '/ajax_signin.php',
           data: $('#login-form').serialize(),
           success: function(html) {
               if(html == 'true') {
                   window.location.reload();
               }
               
               else if(html == 'no_enter') {
                   $(".error-noenter").fadeIn(10);
                   $(".error-invalid").fadeOut(10);
               }
               
               else {
                   $(".error-invalid").fadeIn(10);
                   $(".error-noenter").fadeOut(10);
               }
           }
       });
       
   }); 
});