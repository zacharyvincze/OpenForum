$(document).ready(function() {

    $("#login-form").submit(function(e) {

        $.ajax({
            type: 'post',
            url: '/ajax_signin.php',
            data: $('#login-form').serialize(),
            success: function(html) {
                if(html == true) {
                    window.location.reload();
                }

                else if(html == 'no_enter') {
                    $(".error").fadeIn(10);
                    $(".error").text("Fill in all fields.");
                }

                else if(html == 'incorrect') {
                    $(".error").fadeIn(10);
                    $(".error").text("Invalid username or password.");
                }

                else if(html == 'not_confirmed') {
                    $(".error").fadeIn(10);
                    $(".error").text("You are not confirmed yet.");
                }

                else {
                    $(".error").fadeIn(10);
                    $(".error").text("Database error.");
                }
            }
        });
    });

   $("#dropdown-login-form").submit(function(e) {

       $.ajax({
           type: 'post',
           url: '/ajax_signin.php',
           data: $('#dropdown-login-form').serialize(),
           success: function(html) {
               if(html == true) {
                   window.location.reload();
               }

               else if(html == 'no_enter') {
                   $(".error").fadeIn(10);
                   $(".error").text("Fill in all fields.");
               }

               else if(html == 'incorrect') {
                   $(".error").fadeIn(10);
                   $(".error").text("Invalid username or password.");
               }

               else if(html == 'not_confirmed') {
                   $(".error").fadeIn(10);
                   $(".error").text("You are not confirmed yet.");
               }

               else {
                   $(".error").fadeIn(10);
                   $(".error").text("Database error.");
               }
           }
       });
   });
});
