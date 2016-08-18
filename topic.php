<?php

/*
List posts from a topic
*/

include 'header.php';
include 'includes/connect.php';
include 'includes/query-functions.php';

date_default_timezone_set(TIMESTAMP);

$query = "SELECT * FROM topics WHERE topic_id=?";
$stmt = $connect->prepare($query);
$stmt->bind_param('i', $_GET['topic_id']);
$stmt->execute();
$result = $stmt->get_result();

if(!$stmt) {
    echo ERROR_CONNECTION_FAILED;
} else {
    $topic_id = $_GET['topic_id'];
    $numrows = $result->num_rows;

    if($numrows == 0) {
        echo MESSAGE_TOPIC_NONEXISTANT;
    } else {
        echo '<div class="container">';

        while($row = $result->fetch_assoc()) {
            if($row['topic_visible'] || (isset($_SESSION['signed_in']) && $_SESSION['signed_in'] && $_SESSION['user_level'] == 1) || DEVELOPMENT_MODE) {

                // `Delete` button. Put in separate variable because otherwise, the `if` statement would be wayyyy too long, even with indents.
                $buttondata = '<button onclick="deleteTopic(\'' . $row['topic_id'] . '\', \'' . $row['topic_by'] . '\', \'' . $_SESSION['csrf_token'] . '\', \'' . $row['topic_cat'] . '\')" class="button small primary-button-color" style="float: right !important;">' . SHORT_TOPIC_DELETE . '</button>';
                // Really complicated `if` statement in one line to check if the button is allowed to echo
                echo ($row['topic_visible'] && (DEVELOPMENT_MODE || (isset($_SESSION['signed_in']) && $_SESSION['signed_in'] && $_SESSION['user_id'] == $row['topic_by']) || (isset($_SESSION['signed_in']) && $_SESSION['signed_in'] && $_SESSION['user_level'] == 1)) ? $buttondata : '');
                echo '<div class="header">';
                echo '<p class="title title-text-color">' . $row['topic_subject'] . '</p>';
                echo '<br><p class="description faded-text-color">' . str_replace('%time%', '' . date('g:i A', strtotime($row['topic_date'])), str_replace('%date%', '' . date('j F, Y', strtotime($row['topic_date'])), str_replace('%username%', '' . getTopicUsername($row['topic_by']), MESSAGE_TOPIC_DESCRIPTION))) . '</p>';
                echo '</div>';
            } else {
                die(MESSAGE_TOPIC_NONEXISTANT);
            }
        }

        if(isset($_GET['page'])) {
            $currentPage = $_GET['page'] - 1;
            $totalPerPage = 5;
            $intStart = ($currentPage * $totalPerPage);
            $limit = $totalPerPage;
        } else {
            die(MESSAGE_TOPIC_NONE);
        }

        //Get amount of posts in topic
        $totalPosts = getPostCount($_GET['topic_id']);

        //Get total amount of pages needed
        $totalPages = ceil($totalPosts / $totalPerPage);

        //List page index
        for($i = 1; $i <= $totalPages; $i++) {
            if($currentPage + 1 == $i) $class = "current-page-index top";
            else $class = "page-index top";

            echo "<a class='$class' href='topic.php?topic_id=$topic_id&page=$i'>$i</a>";
        }

        echo '</div>';

        $query = "SELECT
                    posts.post_id,
                    posts.post_topic,
                    posts.post_content,
                    posts.post_date,
                    posts.post_by,
                    posts.post_visible,
                    users.user_id,
                    users.user_name,
                    users.user_icon,
                    users.user_level
                  FROM
                    posts
                  LEFT JOIN
                    users
                  ON
                    posts.post_by = users.user_id
                  WHERE
                    posts.post_topic=?" . (DEVELOPMENT_MODE || (isset($_SESSION['signed_in']) && $_SESSION['signed_in'] && $_SESSION['user_level'] == 1) ? '' : " AND topic_visible='TRUE'" ) . "
                  ORDER BY
                    posts.post_date
                  LIMIT ?, ?";

        $stmt = $connect->prepare($query);
        $stmt->bind_param('iii', $_GET['topic_id'], $intStart, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        if(!$stmt) {
            echo ERROR_CONNECTION_FAILED;
        } else {
            $numrows = $result->num_rows;

            if($numrows == 0) {
                die(MESSAGE_TOPIC_NONE); // later, redirect to last page of posts.
            } else {

                //Determine
                if($totalPosts == 1) $posts = SHORT_POST_SINGULAR;
                else $posts = SHORT_POST_PLURAL;

                echo '<div class="status-bar post-header primary-color">
                        <p>' . str_replace('%noun%', $posts, str_replace('%posts%', $totalPosts, MESSAGE_TOPIC_POSTS)) . '</p>
                      </div>';
                echo '<div class="topic-box faded-color">';

                while($row = $result->fetch_assoc()) {
                    if($row['post_visible'] == 'TRUE' || (isset($_SESSION['signed_in']) && $_SESSION['signed_in'] && $_SESSION['user_level'] == 1) || DEVELOPMENT_MODE) {
                        //Get user title
                        if($row['user_level'] == 0) $user_level = SHORT_USER_MEMBER;
                        else $user_level = SHORT_USER_ADMIN;

                        echo '<div class="post inverted-color">';
                                        // `Delete` button. Put in separate variable because otherwise, the `if` statement would be wayyyy too long, even with indents.
                        $buttondata = '<button onclick="deletePost(\'' . $row['post_id'] . '\', \'' . $row['post_by'] . '\', \'' . $_SESSION['csrf_token'] . '\', \'' . $row['post_cat'] . '\')" class="button small primary-button-color" style="float: right">' . SHORT_TOPIC_DELETE . '</button>';
                        // Really complicated `if` statement in one line to check if the button is allowed to echo
                        echo '<div class="mobile-profile-info">
                                  <img class="profile-picture tiny" src="/assets/profile-pictures/' . $row['user_icon'] . '">
                                  <span class="big-text title-text-color"><strong>' . $row['user_name'] . '</strong></span>
                                  <span class="small-text faded-text-color">' . $user_level . '</span>
                                </div>
                                <div class="profile-info">
                                  <p class="big-text title-text-color"><strong>' . $row['user_name'] . '</strong></p>
                                  <p class="small-text faded-text-color">' . $user_level . '</p>
                                  <div class="profile-picture small center" style="background-image: url(/assets/profile-pictures/' . $row['user_icon']. ')"></div>
                                  <p class="tiny-text faded-text-color">' . str_replace('%posts%', '' . getUserPosts($row['user_id']), MESSAGE_USER_POSTS) . ' ' . $posts . '</p>
                                </div><div class="post-content">';
                                  echo '<p class="tiny-text faded-text-color">' . str_replace('%time%', '' . date('g:i A', strtotime($row['post_date'])), str_replace('%date%', '' . date('j F, Y', strtotime($row['post_date'])), MESSAGE_TOPIC_DATE)) . '</p>';
                                  echo '<div class="tiny-text primary-text-color">' . $row['post_content'];
                                  if($row['post_visible'] != 'TRUE') echo '<p class="text-tiny bold error-text-color">This post is hidden!</p>';
                                  // echo ($row['post_visible'] && (DEVELOPMENT_MODE || (isset($_SESSION['signed_in']) && $_SESSION['signed_in'] && $_SESSION['user_id'] == $row['post_by']) || (isset($_SESSION['signed_in']) && $_SESSION['signed_in'] && $_SESSION['user_level'] == 1)) ? $buttondata : '');
                                  //echo '<img class="icon icon-tiny icon-more-options" src="/assets/icons/more-options.svg">';
                                  echo '</div>
                                </div>
                              </div>
                              <div class="post-options inverted-color">
                                <div class="icon-toolbar">
                                  <img class="icon icon-tiny icon-like ' . (isPostLiked($row['post_id'], $_SESSION['user_id']) ? 'icon-like-active' : 'icon-like-unactive') . '" onclick="likePost(\'' . $_SESSION['user_id'] . '\', \'' . $row['post_id'] . '\', \'' . $_SESSION['csrf_token'] . '\')">
                                  <img class="icon icon-tiny icon-more-options">
                                </div>
                              </div>';
                    }
                }

                echo '</div>';

                echo '<div class="container">';

                //List page index
                for($i = 1; $i <= $totalPages; $i++) {
                    if($currentPage + 1 == $i) $class = "current-page-index bottom";
                    else $class = "page-index bottom";

                    echo "<a class='$class' href='topic.php?topic_id=$topic_id&page=$i'>$i</a>";
                }

                echo '</div>';
            }

            if(!isset($_SESSION['signed_in']) && !$_SESSION['signed_in']) {
                echo '<div class="container">
                        <p class="small-text faded-text-color">' . MESSAGE_REPLY_SIGNOUT . '</p>
                      </div>';
            } else {

                //Initialize tinymce text editor
                echo '<script>
                        tinymce.init({
                          selector: "#editor",
                          menubar: false,
                          plugins: [
                            "image link"
                          ],
                          toolbar: "bold italic | image link | bullist numlist",
                          height: 200,
                          width: "100%",
                          statusbar: false,
                          force_br_newlines: true,
                          force_p_newlines: false,
                          force_root_block: "",
                          content_css: "/style/tinymce-style.css",
                          object_resizing: false
                        });
                      </script>';

                //Reply form
                echo '<div class="form-container" style="margin-top: 20px">
                        <p class="error-text-color small-text error">Test</p>
                        <form id="reply-form" method="post" onsubmit="return false" autocomplete="false">
                          <textarea id="editor" autocomplete="off" name="reply-content"></textarea>
                          <input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '" />
                          <input type="hidden" name="topic-id" value="' . $_GET['topic_id'] . '">
                          <p class="error-noenter tiny-text error-text-color"></p>
                          <input id="submit" class="button primary-button-color normal" type="submit" value="' . SHORT_REPLY_BUTTON . '" />
                        </form>
                      </div>';
            }
        }
    }
}

include 'footer.php';
?>
