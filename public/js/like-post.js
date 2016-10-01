$(document).ready(function() {
    // Toggle like button
    $('.icon-like').click(function() {
        $(".icon-like").animate({height: "300px"});
        if($(this).hasClass('icon-like-unactive')) {
            $(this).removeClass('icon-like-unactive');
            $(this).addClass('icon-like-active');
        } else {
            $(this).removeClass('icon-like-active');
            $(this).addClass('icon-like-unactive');
        }
    });
});

//Like post button!
function likePost(user_id, post_id, csrf_token) {
    $.ajax( {
        type: 'post',
        url: '/like.php',
        data: {
            like_user_id: user_id,
            like_post_id: post_id,
            csrf_token: csrf_token
        },
        success: function(html) {
            if(!(html == 'true')) {
                alert(html);
            }
        }

    });
}
