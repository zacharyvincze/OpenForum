$(document).ready(function() {
    
    $("#reply-form").on("submit", function(e) {
        
        var editorContent = tinyMCE.get('editor').getContent({format: 'text'});
        
        if($.trim(editorContent) == '') {
            alert('empty!');
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
                        alert("Something went wrong.  Please try again later.");
                    }
                }  
            
            });
        }
        
    });
    
});