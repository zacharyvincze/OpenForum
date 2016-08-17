<?php

/*
Registration script
*/

include 'header.php';
include 'includes/strings.php';
include 'includes/connect.php';

echo '<div class="form-container">';
echo '<div class="header">';
echo '<h3 class="title title-text-color center">' . SHORT_USER_SIGNUP . '</h3>';
echo '<p class="description faded-text-color center">' . MESSAGE_WELCOME_SIGNUP . '</p>';
echo '</div>';

echo '<form method="post" onsubmit="return false" autocomplete="off" id="register-form">
    <p class="small-text title-text-color bold left">' . SHORT_USER_USERNAME . '</p>
    <input class="page text-field small-text title-text-color" type="text" name="user_name" />
    <p class="small-text title-text-color bold left">' . SHORT_USER_PASSWORD . '</p>
    <input class="page text-field small-text title-text-color" type="password" name="user_pass">
    <p class="small-text title-text-color bold left">' . SHORT_USER_CONFIRM . '</p>
    <input class="page text-field small-text title-text-color" type="password" name="user_pass_check">
    <p class="small-text title-text-color bold left">' . SHORT_USER_EMAIL . '</p>
    <input class="page text-field small-text title-text-color" type="email" name="user_email">
    <input class="button small primary-button-color" type="submit" value="' . SHORT_USER_REGISTER . '"';

echo '</div>';
include 'footer.php';
?>
