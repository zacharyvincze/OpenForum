<?php

/*
Login script
*/

include 'header.php';
include 'includes/connect.php';

echo '<h3>Sign in</h3>';

if($_SESSION['signed_in']) {
    echo 'You are already signed in, you can <a href="/logout">sign out</a> if you want to switch users.';
} else {
    if($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo '<form method="post" action="">
            Username: <input autocomplete="off" type="text" name="user_name" />
            Password: <input autocomplete="off" type="password" name="user_pass">
            <input type="submit" value="Sign In" />
            </form>';
    } else {
        $username = htmlspecialchars($_POST['user_name']);
        $password = htmlspecialchars($_POST['user_pass']);

        if($username && $password) {
            $query = "SELECT user_icon, user_id, user_pass, user_email, user_level FROM users WHERE user_name=?";
            $stmt = $connect->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->bind_result($db_icon, $db_id, $db_pass, $db_email, $db_level);
            $stmt->store_result();
            $stmt->fetch();

            $numrows = $stmt->num_rows;

            if($numrows != 0) {
                if(password_verify($password, $db_pass)) {
                    $_SESSION['signed_in'] = true;
                    $_SESSION['user_id'] = $db_id;
                    $_SESSION['user_name'] = $username;
                    $_SESSION['user_email'] = $db_email;
                    $_SESSION['user_level'] = $db_level;
                    $_SESSION['user_icon'] = $db_icon;

                    echo 'Welcome, ' . $_SESSION['user_name'] . '. <a href="/home">Proceed to the forum overview</a>.';
                } else {
                    echo "Password incorrect!";
                }
            } else {
                echo "Username was not found!";
            }
        } else {
            echo "Please enter all fields!";
        }
    }
}

include 'footer.php';

?>
