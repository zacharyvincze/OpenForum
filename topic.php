<?php

/*
List posts from a topic
*/

include 'header.php';
include 'includes/connect.php';
include 'includes/query-functions.php';

date_default_timezone_set('America/Toronto');

$query = "SELECT topic_id, topic_subject FROM topics WHERE topic_id=?";
$stmt = $connect->prepare($query);
$stmt->bind_param('i', $_GET['topic_id']);
$stmt->execute();
$result = $stmt->get_result();

if(!$stmt) {
    echo 'There was a problem showing the topic, please try again later.';
} else {
    $topic_id = $_GET['topic_id'];
    $numrows = $result->num_rows;

    if($numrows == 0) {
        echo 'This topic does not exist.';
    } else {

        echo '<div class="container">';

        while($row = $result->fetch_assoc()) {
                echo '<h2 class="title">' . $row['topic_subject'] . '</h2>';
        }

        if(isset($_GET['page'])) {
            $currentPage = $_GET['page'] - 1;
            $totalPerPage = 5;
            $intStart = ($currentPage * $totalPerPage);
            $limit = $totalPerPage;
        } else {
            die("This page does not exist!");
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
                    posts.post_topic,
                    posts.post_content,
                    posts.post_date,
                    posts.post_by,
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
                    posts.post_topic=?
                  ORDER BY
                    posts.post_date
                  LIMIT ?, ?";

        $stmt = $connect->prepare($query);
        $stmt->bind_param('iii', $_GET['topic_id'], $intStart, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        if(!$stmt) {
            echo 'There was an error showing the posts.  Please try again later.';
        } else {
            $numrows = $result->num_rows;

            if($numrows == 0) {
                die('There are no posts on this page.');
            } else {

                //Determine
                if($totalPosts == 1) $posts = 'post';
                else $posts = 'posts';

                echo '<div class="status-bar post-header">
                        <p>' . $totalPosts . ' ' . $posts . ' in this topic</p>
                      </div>';
                echo '<div class="topic-box">';

                while($row = $result->fetch_assoc()) {

                    //Get user title
                    if($row['user_level'] == 0) $user_level = 'Member';
                    else $user_level = "Admin";

                    echo '<div class="post">
                            <div class="mobile-profile-info">
                              <img class="profile-picture tiny" src="/assets/profile-pictures/' . $row['user_icon'] . '">
                              <span class="big-text black"><strong>' . $row['user_name'] . '</strong></span>
                              <span class="small-text gray">' . $user_level . '</span>
                            </div>
                            <div class="profile-info">
                              <p class="big-text black"><strong>' . $row['user_name'] . '</strong></p>
                              <p class="small-text gray">' . $user_level . '</p>
                              <div class="profile-picture small center" style="background-image: url(/assets/profile-pictures/' . $row['user_icon']. ')"></div>
                              <p class="tiny-text gray">' . getUserPosts($row['user_id']) . ' posts</p>
                            </div><div class="post-content">
                              <p class="tiny-text gray">Posted on ' . date('j F, Y', strtotime($row['post_date'])) . ' at ' . date('g:i A', strtotime($row['post_date'])) . '</p>
                              <div class="tiny-text black">' . $row['post_content'] . '</div>
                            </div>
                          </div>';
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
                        <p class="small-text gray">You must be <a href="/signin.php">signed in</a> to reply.</p>
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
                        <form id="reply-form" method="post" onsubmit="return false" autocomplete="false">
                          <textarea id="editor" autocomplete="off" name="reply-content"></textarea>
                          <input type="hidden" name="topic-id" value="' . $_GET['topic_id'] . '">
                          <p class="error-noenter tiny-text red"></p>
                          <input id="submit" class="button red normal" type="submit" value="Reply" />
                        </form>
                      </div>';
            }
        }
    }
}
include 'footer.php';
?>
