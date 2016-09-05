$(document).ready(function() {

    $("#reply-form").on("submit", function(e) {

        var editorContent = tinyMCE.get('editor').getContent({format: 'text'});

        if($.trim(editorContent) == '') {
            $(".error").fadeIn(10);
            $(".error").text("The text field is empty!");
        } else {
            $.ajax({
                type: 'post',
                url: '/reply.php',
                data: $("#reply-form").serialize(),
                success: function(html) {
                    if(html == 'true') {
                        window.location.reload();
                    }

                    else {
                        $(".error").fadeIn(10);
                        $(".error").text(html);
                    }
                }

            });
        }

    });

});
