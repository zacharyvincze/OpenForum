<?php
include "includes/functions.php";

sec_session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <!-- Document information -->
        <meta http-equiv="content-language" content="en">
        <meta http-equiv="content-type" content="text/html"; charset="UTF-8" />
        <meta name="description" content="Welcome to the test forum!" />
        <meta name="keywords" content="forum, computer, html, css, javascript, php" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Zach's Forum</title>

        <!-- Stylesheets -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,700,500' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="/style/main.css" type="text/css">
        <link rel="stylesheet" href="/style/navbar.css">
        <link rel="stylesheet" href="/style/table.css">
        <link rel="stylesheet" href="/style/editors.css">
        <link rel="stylesheet" href="/style/titles.css">
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
    echo '<img class="profile-picture icon" src="/assets/icons/' . $_SESSION['user_icon'] . '">
          <div class="dropdown">
            <button class="dropbtn">' . $_SESSION['user_name'] . '</button>
            <div id="user-dropdown" class="dropdown-content">
              <a class="block-link" href="#">Edit Profile</a>
              <a class="block-link" href="/profile.php?user_id='.$_SESSION['user_id'].'">Profile Overview</a>
              <a class="block-link" href="/signout.php">Sign Out</a>
            </div>
          </div>';
} else {
    echo '<div class="dropdown">
            <button class="dropbtn">Sign In</button>
            <div id="user-dropdown" class="dropdown-content">
              <p class="big-text lightblack"><strong>Sign In</strong></p>
              <form method="post" autocomplete="off" onsubmit="return false" id="login-form">
                <input class="small-text lightblack text-field" placeholder="Username" type="text" name="user_name" />
                <input class="small-text lightblack text-field" placeholder="Password" type="password" name="user_pass" />
                <p class="error-noenter tiny-text red">Please fill in all fields!</p>
                <p class="error-invalid tiny-text red">Invalid username or password!</p>
                <input class="button small red" type="submit" value="Login" />
              </form>
              <p class="tiny-text gray" style="margin-top:10px">Haven\'t registered yet?  Do it <a href="signup.php">here</a>!</p>
            </div>
          </div>
        <a href="/signup.php" class="item">Register</a>';
}
                ?>
                </div>
                <h1 class="logo">Forum Logo</h1>
            </div>
            <div class="content">
                <div class="content-nav">
                    <a class="item" href="/index.php">Home</a>
                    <a class="item" href="/create_topic.php">Create a topic</a>
                    <a class="item" href="/create_cat.php">Create a category</a>
                </div>
                <div class="under-content-nav">
                </div>
