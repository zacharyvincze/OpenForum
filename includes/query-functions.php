<?php

/*
Functions for getting results from database
*/

//Getting topic count using cat_id
function getTopicCount($cat_id) {
    $query = "SELECT COUNT(*) FROM topics WHERE topic_cat=?";
    $stmt = $GLOBALS["connect"]->prepare($query);
    $stmt->bind_param('i', $cat_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($topiccount);
    $stmt->fetch();

    return $topiccount;
}

//Getting post count using topic_id
function getPostCount($topic_id) {
    $query = "SELECT COUNT(*)
                FROM posts
                WHERE post_topic=?";
    $stmt = $GLOBALS["connect"]->prepare($query);

    $stmt->bind_param('i', $topic_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($postcount);
    $stmt->fetch();

    return $postcount;
}

//Getting user post count using user_id
function getUserPosts($user_id) {
    $query = "SELECT COUNT(post_id)
              FROM posts
              WHERE post_by=?";
    $stmt = $GLOBALS['connect']->prepare($query);

    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_post_count);
    $stmt->fetch();

    return $user_post_count;
}

//Getting username from topic_by
function getTopicUsername($topic_id) {
    $query = "SELECT user_name
              FROM users
              WHERE user_id=?";
    $stmt = $GLOBALS['connect']->prepare($query);

    $stmt->bind_param('i', $topic_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($username);
    $stmt->fetch();

    return $username;
}
?>
