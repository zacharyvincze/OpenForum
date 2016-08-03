<?php

/*
Registration script
*/

include 'header.php';
include 'includes/connect.php';

echo '<h3>Sign up</h3>';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo '<form method="post" onsubmit="return false" autocomplete="off" id="register-form">
        Username: <input autocomplete="off" type="text" name="user_name" />
        Password: <input autocomplete="off" type="password" name="user_pass">
        Password Confirm: <input autocomplete="off" type="password" name="user_pass_check">
        Email: <input autocomplete="off" type="email" name="user_email">
        <input type="submit" value="Add category"';
} else {
    $username = htmlspecialchars($_POST['user_name']);
    $password = htmlspecialchars($_POST['user_pass']);
    $email = htmlspecialchars($_POST['user_email']);
    $passwordConfirm = htmlspecialchars($_POST['user_pass_check']);

    if($username && $password && $email && $passwordConfirm) {
        if(strlen($username) > 30) {
            echo "Username must not be more than 30 characters! <a href='/register'>Return to registration.</a>";
        } else {
            if($password === $passwordConfirm) {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $query = "INSERT INTO users(user_name, user_pass, user_email, user_date, user_level) VALUES (?, ?, ?, NOW(), 0)";
                $stmt = $connect->prepare($query);
                $stmt->bind_param('sss', $username, $passwordHash, $email);
                $stmt->execute();
                echo 'You have successfully registered, you can now <a href="/login">sign in</a> and start posting!';
                $stmt->close();
                $connect->close();
            } else {
                echo "Passwords do not match!";
            }
        }
    } else {
        echo "Please fill in all the fields!";
    }
}

include 'footer.php';
?>
