<?php

/*
Login script
*/

include 'header.php';
include 'includes/strings.php';
include 'includes/connect.php';

echo '<div class="form-container">';
echo '<div class="title">';
echo '<h3 class="center big-text lightblack">' . SHORT_USER_SIGNIN . '</h3>';
echo '<p class="text-small gray center">' . MESSAGE_NOT_REGISTERED . '</p>';
echo '</div>';

echo '<div class="form-container">';
if($_SESSION['signed_in']) {
    echo MESSAGE_USER_SIGNIN;
} else {
    echo '<form method="post" autocomplete="off" onsubmit="return false" id="login-form">
      <p class="small-text lightblack bold" style="text-align:left">' . SHORT_USER_EITHER . '</p>
      <input class="small-text lightblack text-field page" type="text" name="user_name" />
      <p class="small-text lightblack bold" style="text-align: left">' . SHORT_USER_PASSWORD . '</p>
      <input class="small-text lightblack text-field page" type="password" name="user_pass" />
      <p class="error tiny-text red left"></p>
      <input class="button small red" type="submit" value="' . SHORT_USER_LOGIN . '" />
    </form>';
}

echo '</div>';

include 'footer.php';

?>
