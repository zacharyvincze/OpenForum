<?php

include_once LIBRARY_PATH . '/functions.php';

sec_session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>

         <!-- Chrome, Firefox OS and Opera -->
         <meta name="theme-color" content="#FF3B3F">
         <!-- Windows Phone -->
         <meta name="msapplication-navbutton-color" content="#FF3B3F">
         <!-- iOS Safari -->
         <meta name="apple-mobile-web-app-capable" content="yes">
         <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

        <!-- Document information -->
        <meta http-equiv="content-language" content="<?php echo FORUM_LANGUAGE; ?>">
        <meta http-equiv="content-type" content="text/html"; charset="UTF-8" />
        <meta name="description" content="<?php echo FORUM_DESCRIPTION; ?>" />
        <meta name="keywords" content="<?php echo FORUM_KEYWORDS; ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo FORUM_NAME . (DEVELOPMENT_MODE ? ' / Dev Mode' : ''); ?></title>

        <!-- Stylesheets -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,700,500' rel='stylesheet' type='text/css'>
        <?php
            echo '<style>' . htmlspecialchars(file_get_contents('css/main.css'))
                . ' ' . htmlspecialchars(file_get_contents('css/navbar.css'))
                . ' ' . htmlspecialchars(file_get_contents('css/table.css'))
                . ' ' . htmlspecialchars(file_get_contents('css/editors.css'))
                . ' ' . htmlspecialchars(file_get_contents('css/post.css'))
                . ' ' . htmlspecialchars(file_get_contents('css/profile.css'))
                . ' ' . htmlspecialchars(file_get_contents('css/text.css'))
                . ' ' . htmlspecialchars(file_get_contents('css/button.css'))
                . ' ' . htmlspecialchars(file_get_contents('css/dropdown.css'))
                . ' ' . htmlspecialchars(file_get_contents('css/page-index.css'))
                . ' ' . htmlspecialchars(file_get_contents('css/themes/' . COLOR_THEME . '.css')) // vulnerability! to make a simple payload, set COLOR_THEME to: "../../../../../etc/passwd"
                . ' ' . htmlspecialchars(file_get_contents('css/icons/icons.css'))
                . ' ' . htmlspecialchars(file_get_contents('css/icons/icon-toolbar.css')) . '</style>';
        ?>
        
        <!-- Javascript -->
        <?php
            echo '<script>' . file_get_contents('js/dropdown.js')
                . ' ' . htmlspecialchars(file_get_contents('js/library/jquery.min.js'))
                . ' ' . htmlspecialchars(file_get_contents('js/library/angular.min.js'))
                . ' ' . htmlspecialchars(file_get_contents('js/library/tinymce.min.js'))
                . ' ' . htmlspecialchars(file_get_contents('js/authentication/login.js'))
                . ' ' . htmlspecialchars(file_get_contents('js/editor-validation.js'))
                . ' ' . htmlspecialchars(file_get_contents('js/authentication/register.js'))
                . ' ' . htmlspecialchars(file_get_contents('js/authentication/logout.js'))
                . ' ' . htmlspecialchars(file_get_contents('js/delete/delete_topic.js'))
                . ' ' . htmlspecialchars(file_get_contents('js/delete/delete_post.js'))
                . ' ' . htmlspecialchars(file_get_contents('js/like-post.js')) . '</script>';
        ?>
    </head>

    <body>
        <div id="background-style" class="secondary-color">
        </div>
        <div id="wrapper">
            <div id="menu">
                <div id="userbar">
                <?php
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in']) {
    echo '<img class="profile-picture icon" src="/img/content/profile-pictures/' . $_SESSION['user_icon'] . '">
          <div class="dropdown">
            <button class="dropbtn">' . $_SESSION['user_name'] . '</button>
            <div id="user-dropdown" class="dropdown-content">
              <a class="block-link" href="#">' . SHORT_USER_DESCRIPTION . '</a>
              <a class="block-link" href="profile.php?user_id='.$_SESSION['user_id'].'">' . SHORT_USER_OVERVIEW . '</a>
              <a class="block-link" onclick="logout()">' . SHORT_USER_SIGNOUT . '</a>
            </div>
          </div>';
} else {
    echo '<div class="dropdown">
            <button class="dropbtn">' . SHORT_USER_SIGNIN . '</button>
            <div id="user-dropdown" class="dropdown-content">
              <p class="big-text title-text-color"><strong>' . SHORT_USER_SIGNIN . '</strong></p>
              <form method="post" autocomplete="off" onsubmit="return false" id="dropdown-login-form">
                <input class="small-text title-text-color text-field dropdown-form" placeholder="' . SHORT_USER_USERNAME . '" type="text" name="user_name" />
                <input class="small-text title-text-color text-field dropdown-form" placeholder="' . SHORT_USER_PASSWORD . '" type="password" name="user_pass" />
                <p class="error tiny-text error-text-color"></p>
                <input class="button small primary-button-color" type="submit" value="Login" />
              </form>
              <p class="tiny-text faded-text-color" style="margin-top:10px">' . MESSAGE_NOT_REGISTERED . '</p>
            </div>
          </div>
        <a href="signup.php" class="item">' . SHORT_USER_REGISTER . '</a>';
}
                ?>
                </div>
                <h1 class="logo inverted-text-color"><?php echo FORUM_NAME . (DEVELOPMENT_MODE ? ' / <font color="red">Development Mode</font>' : ''); ?></h1>
            </div>
            <div class="content inverted-color">
                <div class="content-nav inverted-text-color primary-color">
                    <a class="item inverted-text-color" href="index.php"><?php echo SHORT_NAV_HOME; ?></a>
                    <a class="item inverted-text-color" href="<?php if(isset($_SESSION['signed_in']) && $_SESSION['signed_in']) echo 'create_topic.php'; else echo 'signin.php' ?>"><?php if(isset($_SESSION['signed_in']) && $_SESSION['signed_in']) echo SHORT_TOPIC_CREATE; else echo 'Login' ?></a>
                    <?php if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] && $_SESSION['user_level'] == 1) echo '<a class="item inverted-text-color" href="create_cat.php">' . SHORT_CATEGORY_CREATE . '</a>'; ?>
                </div>
                <div class="under-content-nav faded-color">
                </div>
