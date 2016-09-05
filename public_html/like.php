<?php
include_once '../resources/configuration/config.php';
include_once LIBRARY_PATH . '/connect.php';
include LIBRARY_PATH . '/functions.php';

sec_session_start();

$user_id = $_POST['like_user_id'];
$post_id = $_POST['like_post_id'];
$csrf_token = $_POST['csrf_token'];

$error = array();

if($_SERVER['REQUEST_METHOD'] != 'POST') {
    $error[] = ERROR_INVALID_ACCESS;
}

if(!$_SESSION['signed_in']) {
    $error[] = MESSAGE_USER_SIGNOUT;
}

if(!isset($user_id) || !isset($post_id) || !isset($csrf_token)) {
    $error[] = ERROR_INVALID_DATA;
}

if(!isset($_POST['csrf_token']) || $_SESSION['csrf_token'] != $_POST['csrf_token']) {
    $error[] = ERROR_INVALID_CSRF;
}

if(!empty($error)) {
    die($error[0]);
}

$query = "SELECT * FROM likes WHERE like_user_id=? AND like_post_id=?";
$stmt = $connect->prepare($query);
$stmt->bind_param('ii', $user_id, $post_id);
$stmt->execute();
$result = $stmt->get_result();

if($stmt->error) {
    $error[] = ERROR_CONNECTION_FAILED;
    die($error[0]);
}

if($result->num_rows == 0) {
    $query = "INSERT INTO likes (like_user_id, like_post_id) VALUES (?, ?)";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('ii', $user_id, $post_id);
    $stmt->execute();

    if($stmt->error) {
        $error[] = ERROR_CONNECTION_FAILED;
        die($error[0]);
    }

    echo 'true';
} else {
    $query = "DELETE FROM likes WHERE like_user_id=? AND like_post_id=?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('ii', $user_id, $post_id);
    $stmt->execute();

    if($stmt->error) {
        $error[] = ERROR_CONNECTION_FAILED;
        die($error[0]);
    }

    echo 'true';
}

?>
