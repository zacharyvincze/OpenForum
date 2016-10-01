<?php

/*
Display user profile information
*/

include_once '../resources/configuration/config.php';
include_once CONFIGURATION_PATH . '/strings.php';
include_once LIBRARY_PATH . '/connect.php';
include_once LIBRARY_PATH . '/query-functions.php';
include_once TEMPLATES_PATH . '/header.php';

date_default_timezone_set(TIMEZONE);

$user_id = $_GET['user_id'];

echo '<div class="container">';

//Check if the user existss
$query = "SELECT * FROM users WHERE user_id=?";
$stmt = $connect->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$numrows = $result->num_rows;

if($numrows == 0) {
    //User doesn't exist
    echo '<p class="small-text primary-text-color">' . MESSAGE_USER_NONEXISTANT . '</p>';
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
    echo '<div class="profile-banner faded-color">
            <img class="profile-picture inverted-color big" src="/assets/profile-pictures/'.$user_icon.'">' . htmlspecialchars($user_about) . '
          </div>
          <div class="profile-statistics primary-color">
            <div class="posts">
              <p class="small-text inverted-text-color bold">' . SHORT_USER_POSTS . '</p>
              <p class="small-text inverted-text-color">'.getUserPosts($user_id).'</p>
            </div>
            <div class="joined">
              <p class="small-text inverted-text-color bold">' . SHORT_USER_JOINED . '</p>
              <p class="small-text inverted-text-color">'.date('j F, Y', strtotime($user_date)).'</p>
            </div>
          </div>';

}

echo '</div>';

include_once TEMPLATES_PATH . '/footer.php';

?>
