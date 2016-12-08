<?php
/*
 * This file contains the majority of the backend code used for deleting topics/posts/categories/users
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once '../resources/configuration/config.php';
include_once LIBRARY_PATH . '/connect.php';
include LIBRARY_PATH . '/functions.php';

sec_session_start();

date_default_timezone_set(TIMEZONE);

/*
 * type is the object that is deleted
 *
 * 1 = topics
 * 2 = posts
 * 3 = categories
 * 4 = users
 */

$type = $_POST['type'];
$value = $_POST['value'];
if(!(isset($value) || ($value != "TRUE" && $value != "FALSE")))
    $value = "TRUE";
if($value == "TRUE")
    $value = "FALSE";
else
    $value = "TRUE";
$a_very_painful_death = ERROR_INVALID_DATA;

if(!(isset($type) && is_numeric($type) && $type >= 1 && $type <= 4)) // change to set the range
    /*I'm probably going to*/die($a_very_painful_death);//because I did this

switch($type) {
    case 1:
        $type = 'topic';
        break;
    case 2:
        $type = 'post';
        break;
    case 3:
        die('This function is currently unavailable.'); // will be removed later
        break;
    case 4:
        die('This function is currently unavailable.'); // will be removed later
        // $type = 'user'; // support later
        break;
}

$stmt = $connect->prepare('SELECT * FROM ' . $type . 's WHERE ' . $type . '_id=?');
$stmt->bind_param('i', $_POST[$type . '_id']);
$stmt->execute();
$result = $stmt->get_result();
if(!$stmt) {
    echo ERROR_CONNECTION_FAILED;
} else if(!$_SESSION['signed_in']) {
    echo MESSAGE_USER_SIGNOUT;
} else if($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo ERROR_INVALID_ACCESS;
} else if(!isset($_POST['csrf_token']) || $_SESSION['csrf_token'] != $_POST['csrf_token']) {
    echo ERROR_INVALID_CSRF;
} else {
    $type_id = $_POST[$type . '_id'];
    $numrows = $result->num_rows;
    if($numrows == 0) {
        echo str_replace('%type%', $type, MESSAGE_MISC_NONEXISTANT);
    } else {
        while($row = $result->fetch_assoc()) {
            if($_SESSION['user_level'] == 1 || $_SESSION['user_id'] == $row['user_id']) {
                $query = 'UPDATE `' . $type . 's` SET `' . $type . '_visible`="' . $value . '" WHERE `' . $type . '_id`=?';
                $stmt = $connect->prepare($query);
                $stmt->bind_param('i', $_POST[$type . '_id']);
                $stmt->execute();

                echo "true";
            } else {
                echo 'unauthorized';
            }
        }
    }
}

?>
