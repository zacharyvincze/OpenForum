<?php

/*
Topic creation
*/

include 'header.php';
include 'includes/strings.php';
include 'includes/connect.php';

echo '<div class="form-container">';
echo '<div class="title">';
echo '<h2 class="big-text lightblack bold center">' . SHORT_TOPIC_CREATE . '</h2>';
echo '</div>';
echo '</div>';

if($_SESSION['signed_in'] == false) {
    echo '<div class="container">';
    echo MESSAGE_TOPIC_SIGNOUT;
    echo '</div>';
} else {
    if($_SERVER['REQUEST_METHOD'] != 'POST') {
        $query = "SELECT cat_id, cat_name, cat_description FROM categories";
        $stmt = $connect->query($query);

        $numrows = $stmt->num_rows;

        if($numrows == 0) {
            if($_SESSION['user_level'] == 1) {
                echo MESSAGE_TOPIC_CATEGORY;
            } else {
                echo MESSAGE_TOPIC_SUPERCATEGORY;
            }
        } else {

            echo '<script>
                    tinymce.init({
                      selector: "#editor",
                      plugins: [
                        "image link"
                      ],
                      object_resizing: false,
                      menubar: false,
                      toolbar: "bold italic | image link | bullist numlist",
                      height: 400,
                      width: "100%",
                      statusbar: false,
                      content_css: "/style/tinymce-style.css"
                    });
                  </script>';

            echo '<div class="form-container">
                    <form method="post" action="">
                    Category: ';

            echo '<select name="topic_cat">';
            while($row = $stmt->fetch_assoc()) {
                echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
            }
            echo '</select>';

            echo '<input autocomplete="off" id="title" class="normal-text lightblack bold" placeholder="' . SHORT_TOPIC_SUBJECT . '" type="text" name="topic_subject" /><br>
                  <textarea id="editor" autocomplete="off" name="post_content"></textarea><br>
                  <input class="button small red" type="submit" value="' . SHORT_TOPIC_BUTTON . '" />
                </form>
                </div>';
        }
    } else if ($_POST['token'] != $_SESSION['token']){
        die(ERROR_INVALID_CSRF);
    } else {
        $query = "BEGIN WORK"; // lol
        $stmt = $connect->query($query);

        if(!$stmt) {
            echo ERROR_CONNECTION_FAILED;
        } else {
            $topic_cat = $_POST['topic_cat'];
            $topic_subject = $_POST['topic_subject'];

            if(!$topic_subject) {
                echo MESSAGE_TOPIC_EMPTY;
            } else {
                $query = "INSERT INTO topics(topic_subject, topic_date, topic_cat, topic_by) VALUES (?, NOW(), ?, ?)";
                $stmt = $connect->prepare($query);
                $stmt->bind_param('sii', $topic_subject, $topic_cat, $_SESSION['user_id']);
                $stmt->execute();

                if(!$stmt) {
                    echo ERROR_CONNECTION_FAILED;
                    $query = "ROLLBACK";
                    $stmt = $connect->query($query);
                } else {
                    $topicid = $stmt->insert_id;
                    $post_content = $_POST['post_content'];

                    if(!$post_content) {
                        echo MESSAGE_TOPIC_EMPTY;
                    } else {
                        $query = "INSERT INTO posts(post_content, post_date, post_topic, post_by) VALUES (?, NOW(), ?, ?)";
                        $stmt = $connect->prepare($query);
                        $stmt->bind_param('sii', $post_content, $topicid, $_SESSION['user_id']);
                        $stmt->execute();

                        if(!$stmt) {
                            echo ERROR_CONNECTION_FAILED;
                            $query = "ROLLBACK";
                            $stmt = $connect->query("ROLLBACK");
                        }

                        else {
                            $query = "COMMIT";
                            $stmt = $connect->query($query);

                            //Yay! the query works!
                            echo str_replace('%topic_id%', $topicid, MESSAGE_TOPIC_SUCCESS); // replace %topic_id% with $topicid
                        }
                    }
                }
            }
        }
    }
}

include 'footer.php';

?>
