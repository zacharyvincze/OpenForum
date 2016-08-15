<?php

/*
Display user profile information
*/

include 'header.php';
include 'includes/strings.php';
include 'includes/psl-config.php';
include 'includes/connect.php';
include 'includes/query-functions.php';

date_default_timezone_set(TIMEZONE);

$user_id = $_GET['user_id'];

echo '<div class="container">';

//Check if the user exists
$query = "SELECT * FROM users WHERE user_id=?";
$stmt = $connect->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$numrows = $result->num_rows;

if($numrows == 0) {
    //User doesn't exist
    echo '<p class="small-text lightblack">' . MESSAGE_USER_NONEXISTANT . '</p>';
} else {
    //Fetching user data
    while($row = $result->fetch_assoc()) {
        $user_name = $row['user_name'];
        $user_email = $row['user_email'];
        $user_level = $row['user_level'];
        $user_icon = $row['user_icon'];
        $user_about = $row['user_about'];
        $user_confirmed = $row['user_confirmed'];
        $user_date = $row['user_date'];
    }

    //Basic user page setup
    echo '<div class="profile-banner">
            <img class="profile-picture big" src="/assets/icons/'.$user_icon.'">
          </div>
          <div class="profile-statistics">
            <div class="posts">
              <p class="small-text white bold">' . SHORT_USER_POSTS . '</p>
              <p class="small-text white">'.getUserPosts($user_id).'</p>
            </div>
            <div class="joined">
              <p class="small-text white bold">' . SHORT_USER_JOINED . '</p>
              <p class="small-text white">'.date('j F, Y', strtotime($user_date)).'</p>
            </div>
          </div>';

}

echo '</div>';

include 'footer.php';

?>
