<?php

//psl-config.php file must be added in the includes/ directory

include 'psl-config.php';
include 'strings.php';

/*
PHP file to connect to the database
*/

$connect = new mysqli(HOST, USER, PASSWORD, DATABASE);

if ($connect->connect_error) {
    die((DEVELOPMENT_MODE ? 'Connection failed: ' . $connect->connect_error : ERROR_CONNECTION_FAILED));
}

$GLOBALS["connect"] = $connect;
?>
