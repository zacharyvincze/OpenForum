<?php

/*
Function to send verification email
*/

function sendEmail($user_email, $user_key, $user_name) {
    require 'includes/PHPMailerAutoload.php';
    require 'includes/class.phpmailer.php';

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
    $mail->Username = "zacharyvincze@gmail.com";
    $mail->Password = EMAILPASS;
    $mail->setFrom(EMAIL, 'Forum Confirmation');
    $mail->addAddress($user_email);
    $mail->Subject = "Forum Email Confirmation";
    $mail->Body = '<html>
                     <p>Thanks for signing up '.$user_name.'!</p>
                     <p>Confirm your email here:</p>
                     <a href="http://zachsforum.ddns.net:8800/verify.php?email='.$user_email.'&key='.$user_key.'">
                       http://zachsforum.ddns.net:8800/verify.php?email='.$user_email.'&key='.$user_key.'
                     </a>
                   </html>';

    if(!$mail->Send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Email sent!';
    }

}

?>
