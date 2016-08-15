<?php

/*
Ajax script for replying to posts
*/

include 'includes/functions.php';
include 'includes/strings.php';
include 'includes/connect.php';

sec_session_start();

if($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo ERROR_INVALID_ACCESS;
} else {
    if(!$_SESSION['signed_in']) {
        echo MESSAGE_REPLY_SIGNOUT;
    } else {

        $reply_content = $_POST['reply-content'];
        $topic_id = $_POST['topic-id'];
        if($reply_content !== '' && $topic_id !== '') {
            $query = "INSERT INTO
                        posts(post_content,
                              post_date,
                              post_topic,
                              post_by)
                      VALUES (?, NOW(), ?, ?)";
            $stmt = $connect->prepare($query);
            $stmt->bind_param('sii', $reply_content, $topic_id, $_SESSION['user_id']);
            $stmt->execute();
    
            if(!$stmt) {
                echo 'false';
            } else {
                echo 'true';
                $stmt->close();
                $connect->close();
            }
        } else {
            echo MESSAGE_REPLY_EMPTY;
        }
    }
}
?>
