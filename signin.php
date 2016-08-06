<?php

/*
Login script
*/

include 'header.php';
include 'includes/connect.php';

echo '<div class="form-container">';
echo '<div class="title">';
echo '<h3 class="center big-text lightblack">Sign in</h3>';
echo '<p class="text-small gray center">Haven\'t registered yet?  Do it <a href="signup.php">here</a>.</p>';
echo '</div>';

echo '<div class="form-container">';
if($_SESSION['signed_in']) {
    echo 'You are already signed in, you can <a href="/signout.php">sign out</a> if you want to switch users.';
} else {
    echo '<form method="post" autocomplete="off" onsubmit="return false" id="login-form">
      <p class="small-text lightblack bold" style="text-align:left">Username or Email</p>
      <input class="small-text lightblack text-field page" type="text" name="user_name" />
      <p class="small-text lightblack bold" style="text-align: left">Password</p>
      <input class="small-text lightblack text-field page" type="password" name="user_pass" />
      <p class="error tiny-text red left"></p>
      <input class="button small red" type="submit" value="Login" />
    </form>';
}

echo '</div>';

include 'footer.php';

?>
