<?php

/*
Page for user verification
*/

include 'header.php';
include 'includes/connect.php';

echo '<div class="container">';

$email = $_GET['email'];
$key = $_GET['key'];

$query = "SELECT * FROM users WHERE user_email=? AND user_key=?";
$stmt = $connect->prepare($query);
$stmt->bind_param('ss', $email, $key);
$stmt->execute();
$result = $stmt->get_result();

$numrows = $result->num_rows;

if($numrows == 0) {
    echo '<p class="normal-text bold lightblack">Verification failed.  Please try again later or resend the email.</p>';
} else {

    while($row = $result->fetch_assoc()) {
        $username = $row['user_name'];
        $confirmed = $row['user_confirmed'];
    }
    if($confirmed != 0) {
        echo '<p class="normal-text bold lightblack">You\'ve already been confirmed.  What are you doing here?</p>';
    } else {
        $query = "UPDATE users
                  SET user_confirmed = 1
                  WHERE user_key=?";
        $stmt = $connect->prepare($query);
        $stmt->bind_param('s', $key);
        $stmt->execute();

        if(!$stmt) {
            echo '<p class="normal-text bold lightblack">Verification failed.  Please try again later or resend the email.</p>';
        } else {
            echo '<p class="normal-text bold lightblack">Verification successful.  Welcome to the forums '.$username.'!</p>';
        }
    }
}

echo '</div>';

include 'footer.php';

?>
