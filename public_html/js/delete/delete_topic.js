function deleteTopic(value, topic_id, user_id, csrf_token, topic_cat) {
    $.ajax( {
        type: 'post',
        url: 'delete.php',
        data: {
            type: 1, // refer to /delete.php for information about this POST data.
            value: value,
            topic_id: topic_id,
            user_id: user_id,
            csrf_token: csrf_token
        },
        success: function(html) {
            if(html == 'true') {
                window.location.replace('category.php?cat_id=' + topic_cat);
            } else {
                alert(html);
            }
        }

    });
}
