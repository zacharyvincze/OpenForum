<?php

/*
   Ajax script for replying to posts
 */
include_once '../resources/configuration/config.php';
include_once LIBRARY_PATH . '/functions.php';
include_once CONFIGURATION_PATH . '/strings.php';
include_once LIBRARY_PATH . '/connect.php';

sec_session_start();

if($_SERVER['REQUEST_METHOD'] != 'POST') {
	echo ERROR_INVALID_ACCESS;
} else {
	if(!$_SESSION['signed_in']) {
		echo MESSAGE_REPLY_SIGNOUT;
	} else if ($_POST['csrf_token'] != $_SESSION['csrf_token']){
		die(ERROR_INVALID_CSRF);
	} else {

		$reply_content = $_POST['reply-content'];
		$topic_id = $_POST['topic-id'];
		if($reply_content !== '' && $topic_id !== '') {
			$query = "INSERT INTO
				posts(post_content,
						post_date,
						post_topic,
						post_by)
				VALUES (?, NOW(), ?, ?)";
			$stmt = $connect->prepare($query);
			$stmt->bind_param('sii', $reply_content, $topic_id, $_SESSION['user_id']);
			$stmt->execute();

			if(!$stmt) {
				echo ERROR_CONNECTION_FAILED;
			} else {
				echo 'true';
				$stmt->close();
				$connect->close();
			}
		} else {
			echo MESSAGE_REPLY_EMPTY;
		}
	}
}
?>
