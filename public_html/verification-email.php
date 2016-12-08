<?php

/*
   Function to send verification email
 */

function sendEmail($user_email, $user_key, $user_name) {
	require_once '../resources/configuration/config.php';
	require_once LIBRARY_PATH . '/phpmailer/PHPMailerAutoload.php';
	require_once LIBRARY_PATH . '/phpmailer/class.phpmailer.php';

	date_default_timezone_set('America/Toronto');

	$mail = new PHPMailer;

	$mail->IsSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;
	$mail->IsHTML(true);
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAuth = true;
	$mail->Username = EMAIL;
	$mail->Password = EMAILPASS;
	$mail->setFrom(EMAIL, 'Forum Confirmation');
	$mail->addAddress($user_email);
	$mail->Subject = "Forum Email Confirmation";
	$mail->Body = '<html>
		<p>Thanks for signing up '.$user_name.'!</p>
		<p>Confirm your email here:</p>
		<a href="http://10.0.1.31:8000/verify.php?email='.$user_email.'&key='.$user_key.'">
		http://10.0.1.31:8000/verify.php?email='.$user_email.'&key='.$user_key.'
		</a>
		</html>';

	$mail->send();
}

?>
