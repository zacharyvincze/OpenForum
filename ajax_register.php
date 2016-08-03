<?php

/*
Registration through AJAX
*/

include 'includes/connect.php';
include 'includes/functions.php';
include 'verification-email.php';

sec_session_start();

if($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo 'This file cannot be accessed directly.';
} else {
    $username = $_POST['user_name'];
    $password = $_POST['user_pass'];
    $confirm_password = $_POST['user_pass_check'];
    $email = $_POST['user_email'];

    if($password && $confirm_password && $email && $username) {
        if($password != $confirm_password) {
            echo 'invalid_pass';
        } else {
            $query = "SELECT * FROM users WHERE user_name=?";
            $stmt = $connect->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if(!$stmt) {
                echo 'false';
            } else {
                $numrows = $result->num_rows;
                if($numrows != 0) {
                    echo 'username_exists';
                } else {

                    $query = "SELECT * FROM users WHERE user_email=?";
                    $stmt = $connect->prepare($query);
                    $stmt->bind_param('s', $email);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if(!$stmt) {
                        echo 'false';
                    } else {
                        $numrows = $result->num_rows;
                        if($numrows != 0) {
                            echo 'email_exists';
                        } else {
                            $user_key = md5(rand(0, 100000));
                            $password_hash = password_hash($password, PASSWORD_DEFAULT);

                        $query = "INSERT INTO users(
                                    user_name,
                                    user_pass,
                                    user_email,
                                    user_key,
                                    user_level,
                                    user_date,
                                    user_icon,
                                    user_confirmed,
                                    user_about)
                                  VALUES (?, ?, ?, ?, 0, NOW(), 'default.png', default, 'Tell us a little about yourself.')";
                            $stmt = $connect->prepare($query);
                            $stmt->bind_param('ssss', $username, $password_hash, $email, $user_key);
                            $stmt->execute();

                            echo $stmt->error;

                        sendEmail($email, $user_key, $username);

                        }
                    }
                }
            }
        }
    } else {
        echo 'noenter';
    }
}

?>
