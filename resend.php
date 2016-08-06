<?php

include 'verification-email.php';

$email = $_GET['email'];
$key = $_GET['key'];
$error = array();

if(!$email || !$key) {
    $error[] = 'This user does not exist.';
}

if(!empty($error)) {
    echo '<p class="small-text lightblack">'.$error[0].'</p>';
} else {
    //Check is the user exists
    $query = "SELECT * FROM temp_users WHERE temp_user_email=? AND temp_user_key=?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('ss', $email, $key);
    $stmt->execute();
    $result = $stmt->get_result();

    if($stmt->error) {
        $error[] = 'Database error, try again later.';
    }

    if($result->num_rows == 0) {
        $error[] = 'That user does not exist.';
    }

    if(!empty($error)) {
        echo '<p class="small-text lightblack">'.$error[0].'</p>';
    } else {
        $key = md5(rand(0, 1000000) . $email . rand(0, 1000000));

        while($row = $result->fetch_assoc()) {
            $username = $row['temp_user_name'];
        }

        sendEmail($email, $key, $username);

        echo '<p class="small-text lightblack">Email was sent.</p>';
    }
}

?>
