function deletePost(value, post_id, user_id, csrf_token) {
    $.ajax( {
        type: 'post',
        url: 'delete.php',
        data: {
            type: 2, // refer to /delete.php for information about this POST data.
            value: value,
            post_id: post_id,
            user_id: user_id,
            csrf_token: csrf_token
        },
        success: function(html) {
            if(html == 'true') {
                $("body").load(window.location.href);
            } else {
                alert(html);
            }
        }

    });
}
