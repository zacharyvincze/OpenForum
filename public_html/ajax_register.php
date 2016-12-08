<?php

/*
Registration through AJAX
*/

include_once '../resources/configuration/config.php';
include_once LIBRARY_PATH . '/connect.php';
include_once LIBRARY_PATH . '/functions.php';
include_once CONFIGURATION_PATH . '/strings.php';
include_once 'verification-email.php';

sec_session_start();

if($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo ERROR_INVALID_ACCESS;
} else {
    $error = array();
    $username = $_POST['user_name'];
    $password = $_POST['user_pass'];
    $confirm_password = $_POST['user_pass_check'];
    $email = $_POST['user_email'];
    if(FORCE_RECAPTCHA) {
        $captcha = $_POST['g-recaptcha-response'];
        if(!$captcha) {
                $error[] = "recaptcha";
            } else {
                $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . RECAPTCHA_PRIVATE . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']), true);
                if($response['success'] == false)
                    $error[] = "recaptcha";
            }
        }
    }
    
    //Check if all fields are entered
    if(!$password || !$username || !$confirm_password || !$email) {
        $error[] = 'noenter';
    }

    //Check if username is more than 30 characters
    if(isset($username)) {
        if(strlen($username) > 30) {
            $error[] = 'username_long';
        }
    }

    //Check if username exists
    $query = "SELECT * FROM users WHERE user_name=?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('s', $user_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows != 0) {
        $error[] = "username_exists";
    }

    //Check if temp username exists
    $query = "SELECT * FROM temp_users WHERE temp_user_name=?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows != 0) {
        $error[] = "username_exists";
    }

    //Check if email exsits
    $query = "SELECT * FROM users WHERE user_email=?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows != 0) {
        $error[] = "email_exists";
    }

    //Check if temp email exists
    $query = "SELECT * FROM temp_users WHERE temp_user_email=?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows != 0) {
        $error[] = "email_exists";
    }

    if(!empty($error)) {
        //There have been some errors, echo the first one
        echo $error[0];
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        if(DEVELOPMENT_MODE || !VERIFY_EMAIL) {
            $query = "
                INSERT INTO users(
                    user_name,
                    user_pass,
                    user_email,
                    user_icon,
                    user_level,
                    user_date,
                    user_about)
                VALUES (?, ?, ?, 'default.png', default, NOW(), '" . MESSAGE_USER_DESCRIPTION . "')";
            $stmt = $connect->prepare($query);
            $stmt->bind_param('sss', $username, $password_hash, $email);
            $stmt->execute();

            //Delete temp user row
            $query = "DELETE FROM temp_users WHERE temp_user_key=?";
            $stmt = $connect->prepare($query);
            $stmt->bind_param('s', $key);
            $stmt->execute();

            //Everything is good
            echo 'true';
        } else {
            //All is good, insert into temp_users table
            $key = md5(rand(0, 100000) . $email . rand(0, 1000000));

            $query = "INSERT INTO temp_users(
                        temp_user_name,
                        temp_user_pass,
                        temp_user_email,
                        temp_user_date,
                        temp_user_level,
                        temp_user_icon,
                        temp_user_key)
                      VALUES (?, ?, ?, NOW(), default, 'default.png', ?)";
            $stmt = $connect->prepare($query);
            $stmt->bind_param('ssss', $username, $password_hash, $email, $key);
            $stmt->execute();

            echo $stmt->error;

            sendEmail($email, $key, $username) or die(ERROR_VERIFICATION_FAILED);

            //Everything is good
            echo 'true';
        }
    }


?>
