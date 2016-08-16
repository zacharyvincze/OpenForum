<?php

/*
Category creation
*/

include 'header.php';
include 'includes/strings.php';
include 'includes/connect.php';

echo '<div class="form-container">';
echo '<h2 class="title">' . SHORT_CATEGORY_CREATE . '</h2>';

if(!$_SESSION['signed_in']) {
    echo MESSAGE_CATEGORY_SIGNOUT;
} else {

    if($_SESSION['user_level'] != 1 && !DEVELOPMENT_MODE) {
        echo MESSAGE_CATEGORY_UNAUTHORIZED;
    } else {
        if($_SERVER['REQUEST_METHOD'] != 'POST') {

            /**
            ** Execute tinymce
            **/
            echo '<script>
                    tinymce.init({
                      selector: "#editor",
                      menubar: false,
                      toolbar: "bold italic",
                      width: "100%",
                      height: 200,
                      statusbar: false,
                      content_css: "/style/tinymce-style.css"
                    });
                  </script>';

            /**
            ** Create the form
            **/
            echo '
                    <form method="post" action="">
                      <input id="title" class="normal-text lightblack bold" placeholder="' . SHORT_CATEGORY_NAME . '" autocomplete="off" type="text" name="cat_name" /><br>
                      <textarea id="editor" autocomplete="off" name="cat_description"></textarea><br>
                      <input class="button small red" type="submit" value="' . SHORT_CATEGORY_ADD . '" />
                    </form>';
        } else if ($_POST['token'] != $_SESSION['token']){
            die(ERROR_INVALID_CSRF);
        } else {
            $cat_name = $_POST['cat_name'];
            $cat_description = $_POST['cat_description'];

            if($cat_name && $cat_description) {

                $query = "SELECT * FROM categories WHERE cat_name=?";
                $stmt = $connect->prepare($query);
                $stmt->bind_param('s', $cat_name);
                $stmt->execute();
                $stmt->store_result();
                $stmt->fetch();

                $numrows = $stmt->num_rows;

                if($numrows != 0) {
                    echo MESSAGE_CATEGORY_EXISTS;
                } else {
                    $query = "INSERT INTO categories(cat_name, cat_description) VALUES (?, ?)";
                    $stmt = $connect->prepare($query);
                    $stmt->bind_param('ss', $cat_name, $cat_description);
                    $stmt->execute();

                    echo MESSAGE_CATEGORY_SUCCESS;
                }
            } else {
                echo MESSAGE_CATEGORY_EMPTY;
            }
        }
    }
}

echo '</div>';
include 'footer.php';
?>
