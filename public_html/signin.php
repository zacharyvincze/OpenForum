<?php

/*
   Login script
 */

include_once '../resources/configuration/config.php';
include_once CONFIGURATION_PATH . '/strings.php';
include_once LIBRARY_PATH . '/connect.php';
include_once TEMPLATES_PATH . '/header.php';

if($_SESSION['signed_in']) 
die(MESSAGE_USER_SIGNIN);

echo '<div class="form-container">';
echo '<div class="header">';
echo '<h3 class="title center">' . SHORT_USER_SIGNIN . '</h3>';
echo '<p class="description center">' . MESSAGE_NOT_REGISTERED . '</p>';
echo '</div>';

echo '<form method="post" autocomplete="off" onsubmit="return false" id="login-form">
<p class="small-text title-text-color bold" style="text-align:left">' . SHORT_USER_EITHER . '</p>
<input class="small-text title-text-color text-field page" type="text" name="user_name" />
<p class="small-text title-text-color bold" style="text-align: left">' . SHORT_USER_PASSWORD . '</p>
<input class="small-text title-text-color text-field page" type="password" name="user_pass" />
<p class="error tiny-text red left"></p>
<input class="button small primary-button-color" type="submit" value="' . SHORT_USER_LOGIN . '" />
</form>';


echo '</div>';

include_once TEMPLATES_PATH . '/footer.php';

?>
