function deleteTopic(topic_id, user_id, csrf_token, topic_cat) {
    $.ajax( {
        type: 'post',
        url: '/delete_topic.php',
        data: {
            topic_id: topic_id,
            user_id: user_id,
            csrf_token: csrf_token
        },
        success: function(html) {
            if(html == 'true') {
                window.location.replace('/category.php?cat_id=' + topic_cat);
            } else {
                alert('Fail!');
            }
        }

    });
}
