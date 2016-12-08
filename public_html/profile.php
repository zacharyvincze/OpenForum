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
$query = "SELECT * FROM `users` WHERE `user_id`=?";
$stmt = $connect->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$numrows = $result->num_rows;

if($numrows == 0) {
	// User doesn't exist
	echo '<p class="small-text primary-text-color">' . MESSAGE_USER_NONEXISTANT . '</p>';
} else {
	// Fetching user data
	while($row = $result->fetch_assoc()) {
		$user_name = $row['user_name'];
		$user_email = $row['user_email'];
		$user_level = $row['user_level'];
		$user_icon = $row['user_icon'];
		$user_about = $row['user_about'];
		$user_confirmed = $row['user_confirmed'];
		$user_date = $row['user_date'];
	}

	if($_SERVER['REQUEST_METHOD'] == 'POST')
		if($_SESSION['signed_in'] && $user_name == $_SESSION['user_name']) {
			if($_POST['csrf_token'] != $_SESSION['csrf_token']) {
				die('<p class="center bold error-text-color">' . ERROR_INVALID_CSRF . '</p>');
			} else {
				$query = 'UPDATE `users` SET `user_about`=? WHERE `user_id`=?';
				$stmt = $connect->prepare($query);
				$stmt->bind_param('si', $_POST['about_t'], $user_id);
				$stmt->execute();

				$user_about = $_POST['about_t'];
			}
		} else {
			echo '<div class="container">' . MESSAGE_TOPIC_SIGNOUT . '</div>';
		}


	// Basic user page setup 
	echo '<h1>' . htmlspecialchars($user_name) . '</h1><div class="profile-banner faded-color"><img class="profile-picture inverted-color big" src="/img/content/profile-pictures/'.$user_icon.'">';

	if($user_name == $_SESSION['user_name'])
		echo '<form action="profile.php?user_id=' . htmlspecialchars($_GET['user_id']) . '" method="POST"><input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '" /><textarea class="small-text" id="about_t" name="about_t" style="border-width:0px;background-color:transparent;">' . htmlspecialchars($user_about) . '</textarea>✎</form><script>$("#about_t").keypress(function (e) {if(e.which == 13 && !e.shiftKey) {$(this).closest("form").submit();e.preventDefault();return false;}});</script>';
	else
		echo '<p class="small-text">' . htmlspecialchars($user_about) . '</p>';

	echo '</div>
		<div class="profile-statistics primary-color">
		<div class="posts">
		<p class="small-text inverted-text-color bold">' . SHORT_USER_POSTS . '</p>
		<p class="small-text inverted-text-color">'.getUserPosts($user_id).'</p>
		</div>
		<div class="joined">
		<p class="small-text inverted-text-color bold">' . SHORT_USER_JOINED . '</p>
		<p class="small-text inverted-text-color">'.date('F j, Y', strtotime($user_date)).'</p>
		</div>
		</div>';

}

echo '</div>';

include_once TEMPLATES_PATH . '/footer.php';

?>
