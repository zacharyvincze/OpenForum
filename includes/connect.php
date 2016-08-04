<?php

//psl-config file must be added in the includes/ directory

/*
You must define HOST, USER, PASSWORD, DATABASE, EMAIL and EMAILPASS
*/
include 'psl-config.php';

/*
PHP file to connect to the database
*/

$connect = new mysqli(HOST, USER, PASSWORD, DATABASE);

if ($connect->connect_error) {
    die('Connection failed: ' . $connect->connect_error);
}

$GLOBALS["connect"] = $connect;
?>
