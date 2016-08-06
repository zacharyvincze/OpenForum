<?php

/*
Login through AJAX
*/

include 'includes/functions.php';
include 'includes/connect.php';

sec_session_start();

if($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo 'Cannot access file directly.';
} else {
    $error = array();
    $username = $_POST['user_name'];
    $password = $_POST['user_pass'];

    if(!$username || !$password) {
        $error[] = 'no_enter';
    }

    if(!empty($error)) {
        echo $error[0];
    } else {
        //Get usernames
        $query = "SELECT * FROM temp_users WHERE temp_user_name=?";
        $stmt = $connect->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        $temp_user_rows = $result->num_rows;

        $query = "SELECT * FROM users WHERE user_name=?";
        $stmt = $connect->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        $user_rows = $result->num_rows;

        if($temp_user_rows != 0) {
            $user_type = 'temp_user';
        }

        else if($user_rows != 0) {
            $user_type = 'user';
        }

        else {
            $error[] = 'incorrect';
        }

        if(!empty($error)) {
            echo $error[0];
        } else {
            //Check password
            $query = "SELECT " . $user_type . "_pass FROM " . $user_type . "s WHERE " . $user_type . "_name=?";
            $stmt = $connect->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($db_pass);
            $stmt->fetch();

            if(!password_verify($password, $db_pass)) {
                $error[] = 'incorrect';
            } else {
                if($user_type == 'temp_user') {
                    echo 'not_confirmed';
                } else {
                    echo 'true';
                    $query = "SELECT * FROM users WHERE user_name=?";
                    $stmt = $connect->prepare($query);
                    $stmt->bind_param('s', $username);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while($row = $result->fetch_assoc()) {
                        $username = $row['user_name'];
                        $email = $row['user_email'];
                        $icon = $row['user_icon'];
                        $level = $row['user_level'];
                        $id = $row['user_id'];
                    }

                    $_SESSION['user_name'] = $username;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_icon'] = $icon;
                    $_SESSION['user_level'] = $level;
                    $_SESSION['user_id'] = $id;
                    $_SESSION['signed_in'] = true;
                }
            }

            if(!empty($error)) {
                echo $error[0];
            }
        }
    }
}

?>
