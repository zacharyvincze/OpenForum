<?php

include_once '../resources/configuration/config.php';
include_once 'verification-email.php';
include_once LIBRARY_PATH . '/strings.php';

$email = $_GET['email'];
$key = $_GET['key'];
$error = array();

if(!$email || !$key) {
	$error[] = MESSAGE_USER_NONEXISTANT;
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
		$error[] = ERROR_CONNECTION_FAILED;
	}

	if($result->num_rows == 0) {
		$error[] = MESSAGE_USER_NONEXISTANT;
	}

	if(!empty($error)) {
		echo '<p class="small-text lightblack">'.$error[0].'</p>';
	} else {
		$key = md5(rand(0, 1000000) . $email . rand(0, 1000000));

		while($row = $result->fetch_assoc()) {
			$username = $row['temp_user_name'];
		}

		sendEmail($email, $key, $username) or die(ERROR_VERIFICATION_FAILED);

		echo '<p class="small-text lightblack">' . MESSAGE_USER_SENT . '</p>';
	}
}

?>
