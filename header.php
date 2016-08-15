<?php
include 'includes/strings.php';
include 'includes/psl-config.php';
include 'includes/functions.php';

sec_session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
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
        <link rel="stylesheet" href="/style/main.css" type="text/css">
        <link rel="stylesheet" href="/style/navbar.css">
        <link rel="stylesheet" href="/style/table.css">
        <link rel="stylesheet" href="/style/editors.css">
        <link rel="stylesheet" href="/style/post.css">
        <link rel="stylesheet" href="/style/profile.css">
        <link rel="stylesheet" href="/style/text.css">
        <link rel="stylesheet" href="/style/button.css">
        <link rel="stylesheet" href="/style/dropdown.css">
        <link rel="stylesheet" href="/style/page-index.css">

        <!-- Javascript -->
        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>
        <script src="/js/dropdown.js"></script>
        <script src="/js/login.js"></script>
        <script src="/js/editor-validation.js"></script>
        <script src="/js/register.js"></script>
    </head>

    <body>
        <div id="background-style">
        </div>
        <div id="wrapper">
            <div id="menu">
                <div id="userbar">
                <?php
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in']) {
    echo '<img class="profile-picture icon" src="/assets/profile-pictures/' . $_SESSION['user_icon'] . '">
          <div class="dropdown">
            <button class="dropbtn">' . $_SESSION['user_name'] . '</button>
            <div id="user-dropdown" class="dropdown-content">
              <a class="block-link" href="#">' . SHORT_USER_DESCRIPTION . '</a>
              <a class="block-link" href="/profile.php?user_id='.$_SESSION['user_id'].'">' . SHORT_USER_OVERVIEW . '</a>
              <a class="block-link" href="/signout.php">' . SHORT_USER_SIGNOUT . '</a>
            </div>
          </div>';
} else {
    echo '<div class="dropdown">
            <button class="dropbtn">' . SHORT_USER_SIGNIN . '</button>
            <div id="user-dropdown" class="dropdown-content">
              <p class="big-text lightblack"><strong>' . SHORT_USER_SIGNIN . '</strong></p>
              <form method="post" autocomplete="off" onsubmit="return false" id="dropdown-login-form">
                <input class="small-text lightblack text-field dropdown-form" placeholder="' . SHORT_USER_USERNAME . '" type="text" name="user_name" />
                <input class="small-text lightblack text-field dropdown-form" placeholder="' . SHORT_USER_PASSWORD . '" type="password" name="user_pass" />
                <p class="error tiny-text red"></p>
                <input class="button small red" type="submit" value="Login" />
              </form>
              <p class="tiny-text gray" style="margin-top:10px">' . MESSAGE_NOT_REGISTERED . '</p>
            </div>
          </div>
        <a href="/signup.php" class="item">' . SHORT_USER_REGISTER . '</a>';
}
                ?>
                </div>
                <h1 class="logo"><?php echo FORUM_NAME . (DEVELOPMENT_MODE ? ' / <font color="red">Development Mode</font>' : ''); ?></h1>
            </div>
            <div class="content">
                <div class="content-nav">
                    <a class="item" href="/index.php"><?php echo SHORT_NAV_HOME; ?></a>
                    <a class="item" href="<?php if(isset($_SESSION['signed_in']) && $_SESSION['signed_in']) echo '/create_topic.php'; else echo '/signin.php' ?>"><?php ?></a>
                    <?php if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] && $_SESSION['user_level'] == 1) echo '<a class="item" href="/create_cat.php">' . SHORT_CATEGORY_CREATE . '</a>'; ?>
                </div>
                <div class="under-content-nav">
                </div>
