<?php

/*
List topics from a category
*/

include 'header.php';
include 'includes/strings.php'
include 'includes/connect.php';
include 'includes/psl-config.php';
include 'includes/query-functions.php';

date_default_timezone_set(TIMEZONE);

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
        echo ERROR_CATEGORY_NONEXISTANT;
    } else {

        echo "<div class='container title'>";

        while($row = $result->fetch_assoc()) {
            echo '<h2>' . $row['cat_name'] . '</h2><br><h4>' . $row['cat_description'] . '</h4>';
        }



        echo '</div>';

        $query = "SELECT
                    t.topic_id,
                    t.topic_subject,
                    t.topic_date,
                    t.topic_cat,
                    u.user_id,
                    u.user_name
                  FROM
                    topics t
                  LEFT JOIN
                    users u
                  ON
                    t.topic_by = u.user_id
                  WHERE
                    topic_cat=?
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
                echo MESSAGE_CATEGORY_EMPTY;
            } else {

                if(getTopicCount($_GET['cat_id']) == 1) $topic = 'topic';
                else $topic = 'topics';

                echo '<div class="status-bar"><p class="small-text white">' . getTopicCount($_GET['cat_id']) . ' ' . $topic . ' in this category</p></div>';
                echo '<div class="container">';
                echo '<table>';

                $x = 0;

                while($row = $result->fetch_assoc()) {

                    if((getPostCount($row['topic_id']) - 1) == 1) $reply = 'reply';
                    else $reply = 'replies';

                    $x++;

                    $class = ($x%2 == 0)? 'grayBackground' : 'whiteBackground';

                    echo "<tr class='$class'>";
                        echo '<td class="leftpart">';
                            echo '<h3><a href="/topic.php?topic_id=' . $row['topic_id'] . '&page=1">' . $row['topic_subject'] . '</a></h3>';
                            echo '<p class="small-text gray">By ' . $row['user_name'] . ', ' . date('F j', strtotime($row['topic_date'])) . ' at ' . date('g:i A', strtotime($row['topic_date'])) . '</p>';
                        echo '</td>';
                        echo '<td class="rightpart">';
                            echo '<p class="small-text gray">' . (getPostCount($row['topic_id']) - 1) . ' ' . $reply . "</p>";
                        echo '</td>';
                    echo '</tr>';
                }

                echo '</table>';
                echo '</div>';
            }
        }
    }
}

include 'footer.php';
?>
