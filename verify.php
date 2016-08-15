<?php

/*
Page for user verification
*/

include 'header.php';
include 'includes/connect.php';

echo '<div class="container">';

$error = array();
$email = $_GET['email'];
$key = $_GET['key'];

//Check if email and userkey matches
$query = "SELECT * FROM temp_users WHERE temp_user_key=? AND temp_user_email=?";
$stmt = $connect->prepare($query);
$stmt->bind_param('ss', $key, $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0) {
    $error[] = ERROR_VERIFICATION_FAILED;
}

if($stmt->error) {
    $error[] = ERROR_CONNECTION_FAILED;
}

if(!empty($error)) {
    foreach ($error as $value) {
        echo $value . '<br>';
    }
} else {
    while($row = $result->fetch_assoc()) {
        $username = $row['temp_user_name'];
        $password = $row['temp_user_pass'];
        $email = $row['temp_user_email'];
        $icon = $row['temp_user_icon'];
        $date = $row['temp_user_date'];
    }

    //Insert temp user into users
    $query = "INSERT INTO users(
            user_name,
            user_pass,
            user_email,
            user_icon,
            user_level,
            user_date,
            user_about)
        VALUES (?, ?, ?, ?, default, ?, '" . MESSAGE_USER_DESCRIPTION . "')";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('sssss', $username, $password, $email, $icon, $date);
    $stmt->execute();

    //Delete temp user row
    $query = "DELETE FROM temp_users WHERE temp_user_key=?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('s', $key);
    $stmt->execute();

    echo str_replace('%user%', $username, MESSAGE_USER_VERIFIED);

}

echo '</div>';

include 'footer.php';

?>
