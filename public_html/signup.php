<?php

    /*
    Registration script
    */

    include_once '../resources/configuration/config.php';
    include_once CONFIGURATION_PATH . '/strings.php';
    include_once LIBRARY_PATH . '/connect.php';
    include_once TEMPLATES_PATH . '/header.php';

    if($_SESSION['signed_in']) 
        die(MESSAGE_USER_SIGNIN);

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
        <input class="page text-field small-text title-text-color" type="email" name="user_email">';
    if(FORCE_RECAPTCHA) 
        echo '<div name="captcha" id="captcha" class="g-recaptcha" data-sitekey="' . RECAPTCHA_PUBLIC . '"></div>';
    echo '<input class="button small primary-button-color" type="submit" value="' . SHORT_USER_REGISTER . '"';

    echo '</div>';
    include_once TEMPLATES_PATH . '/footer.php';
?>
