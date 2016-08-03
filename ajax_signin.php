<?php

/*
Login through AJAX
*/

include 'includes/functions.php';
include 'includes/connect.php';

sec_session_start();

if($_SERVER['REQUEST_METHOD'] != 'POST') {
    die('Cannot access file directly.');
}

$username = $_POST['user_name'];
$password = $_POST['user_pass'];

if($username && $password) {

    $query = 'SELECT user_icon, user_id, user_pass, user_email, user_level, user_name FROM users WHERE user_name=?';
    $stmt = $connect->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($db_icon, $db_id, $db_pass, $db_email, $db_level, $db_name);
    $stmt->store_result();
    $stmt->fetch();

    $numrows = $stmt->num_rows;

    if($numrows != 0) {
        if(password_verify($password, $db_pass)) {
            echo 'true';
            $_SESSION['signed_in'] = true;
            $_SESSION['user_icon'] = $db_icon;
            $_SESSION['user_id'] = $db_id;
            $_SESSION['user_name'] = $db_name;
            $_SESSION['user_level'] = $db_level;
            $_SESSION['user_email'] = $db_email;
        } else {
            echo 'false';
        }
    } else {
        echo 'false';
    }

} else {
    echo 'no_enter';
}

?>
