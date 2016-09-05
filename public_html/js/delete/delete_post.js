function deletePost(post_id, user_id, csrf_token) {
    $.ajax( {
        type: 'post',
        url: '/delete.php',
        data: {
            type: 2, // refer to /delete.php for information about this POST data.
            topic_id: post_id,
            user_id: user_id,
            csrf_token: csrf_token
        },
        success: function(html) {
            if(html == 'true') {
                // Later make it remove the comment from the page WITHOUT reloading?
            } else {
                alert(html);
            }
        }

    });
}
