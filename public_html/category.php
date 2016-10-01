<?php

/*
List topics from a category
*/

include_once '../resources/configuration/config.php';
include_once LIBRARY_PATH . '/connect.php';
include_once LIBRARY_PATH . '/query-functions.php';
include_once LIBRARY_PATH . '/functions.php';
include_once TEMPLATES_PATH . '/header.php';

date_default_timezone_set(TIMEZONE);

echo '<div class="container">';

$query = "SELECT cat_id, cat_name, cat_description FROM categories WHERE cat_id=?";
$stmt = $connect->prepare($query);
$stmt->bind_param('i', $_GET['cat_id']);
$stmt->execute();
$result = $stmt->get_result();

if(!$stmt) {
    echo ERROR_CONNECTION_FAILED;
} else {
    $numrows = $result->num_rows;

    if($numrows == 0) {
        echo MESSAGE_CATEGORY_NONEXISTANT;
    } else {

        echo "<div class='header'>";

        while($row = $result->fetch_assoc()) {
            echo '<p class="title title-text-color">' . htmlspecialchars($row['cat_name']) . '</p><br><p class="description">' . htmlspecialchars($row['cat_description']) . '</p>';
        }

        echo '</div>';

        $query = "SELECT *
                  FROM
                    topics
                  WHERE
                    topic_cat=?" . (DEVELOPMENT_MODE || (isset($_SESSION['signed_in']) && $_SESSION['signed_in'] && $_SESSION['user_level'] == 1) ? '' : " AND topic_visible='TRUE'" ) . "
                  ORDER BY topic_date DESC";
        $stmt = $connect->prepare($query);
        $stmt->bind_param('i', $_GET['cat_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if(!$stmt) {
            echo ERROR_CONNECTION_FAILED;
        } else {
            $numrows = $result->num_rows;

            if($numrows == 0) {
                echo MESSAGE_CATEGORY_NONE;
            } else {

                if(getTopicCount($_GET['cat_id']) == 1) $topic = 'topic';
                else $topic = 'topics';

                echo '<div class="status-bar"><p class="small-text white">' . getTopicCount($_GET['cat_id']) . ' ' . $topic . ' in this category</p></div>';
                echo '<table>';

                $x = 0;

                while($row = $result->fetch_assoc()) {

                    if((getPostCount($row['topic_id']) - 1) == 1) $reply = 'reply';
                    else $reply = 'replies';

                    $x++;

                    $class = ($x%2 == 0)? 'faded-color' : 'inverted-color';

                    echo "<tr class='$class'" . ($row['topic_visible'] ? '' : ' style="background-color: #ffa1a1 !important"') . ">";
                        echo '<td class="leftpart">';
                            echo '<h3><a href="/topic.php?topic_id=' . $row['topic_id'] . '&page=1">' . $row['topic_subject'] . '</a></h3>';
                            echo '<p class="small-text faded-text-color">By ' . getTopicUsername($row['topic_by']) . ', ' . date('F j', strtotime($row['topic_date'])) . ' at ' . date('g:i A', strtotime($row['topic_date'])) . '</p>';
                        echo '</td>';
                        echo '<td class="rightpart">';
                            echo '<p class="small-text faded-text-color">' . (getPostCount($row['topic_id']) - 1) . ' ' . $reply . "</p>";
                        echo '</td>';
                    echo '</tr>';
                }

                echo '</table>';
                echo '</div>';
                echo '</div>';
            }
        }
    }
}

include_once TEMPLATES_PATH . '/footer.php';
?>
