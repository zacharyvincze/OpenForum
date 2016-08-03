<?php

/*
Logout script
*/

include 'header.php';

session_destroy();

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
