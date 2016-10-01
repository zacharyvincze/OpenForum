<?php

/*
Logout script
*/

include_once '../resources/configuration/config.php';
include LIBRARY_PATH . '/functions.php';

sec_session_start();

session_destroy();

?>
