<?php

include 'includes/connect.php';

date_default_timezone_set(TIMESTAMP);

$query = "SELECT * FROM topics WHERE topic_id=?";
$stmt = $connect->prepare($query);
$stmt->bind_param('i', $_POST['topic_id']);
$stmt->execute();
$result = $stmt->get_result();
if(!$stmt) {
    echo ERROR_CONNECTION_FAILED;
} else if(!$_SESSION['signed_in']) { 
    echo 'signed_in';
} else if($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo ERROR_INVALID_ACCESS;
} else if(!isset($_POST['csrf_token']) || $_SESSION['csrf_token'] != $_POST['csrf_token']) {
    echo ERROR_INVALID_CSRF;
} else {
    $topic_id = $_POST['topic_id'];
    $numrows = $result->num_rows;
    if($numrows == 0) {
        echo MESSAGE_TOPIC_NONEXISTANT;
    } else {
        while($row = $result->fetch_assoc()) {
            if($_SESSION['user_level'] == 1 && DEVELOPMENT_MODE && $_SESSION['user_id'] == $row['user_id']) {
                $query = "UPDATE topics SET topic_visible='FALSE' WHERE topic_id=?"; // It doesn't *actually* delete them, just hides them.
                $stmt = $connect->prepare($query);
                $stmt->bind_param('i', $_POST['topic_id']);
                $stmt->execute();
                
                echo "success";
            } else {
                echo 'unauthorized';
            }
        }
    }
}
?>
