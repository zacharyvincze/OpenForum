<?php

/*
List categories (Home page)
*/

include 'includes/connect.php';
include 'inlcudes/psl-config.php';
include 'inlcudes/strings.php';
include 'includes/query-functions.php';
include 'header.php';

date_default_timezone_set(TIMEZONE);

$query = "SELECT cat_id, cat_description, cat_name, topic_subject, topic_id, latest as topic_date
FROM categories c
LEFT JOIN (
    SELECT topic_subject, topic_id, topic_cat, MAX(topic_date) latest
    FROM topics
    GROUP BY topic_date, topic_cat, topic_id, topic_subject
    LIMIT 1
     ) as t
ON c.cat_id = t.topic_cat";
$stmt = $connect->query($query);

echo (DEVELOPMENT_MODE ? $connect->error : ERROR_CONNECTION_FAILED);

echo '<div class="container">';
echo '<table>';

$x = 0;

while($row = $stmt->fetch_assoc()) {

    if(getTopicCount($row['cat_id']) == 1) $topic = SHORT_TOPIC_SINGULAR;
    else $topic = SHORT_TOPIC_PLURAL;
    $x++;

    $class = ($x%2 == 0)? 'inverted-color' : 'faded-color';

    echo "<tr class='$class'>";
        echo '<td class="leftpart">';
            echo '<h3><a href="/category.php?cat_id=' . $row['cat_id'] . '">' . $row['cat_name'] . '</a></h3><p class="small-text">' . ($row['cat_description']) . '</p>';
        echo '</td>';
        echo '<td class="middle" id="last-topic">';
            echo '<p class="big-number">' . getTopicCount($row['cat_id']) . '</p><p class="small-text-gray"> ' . $topic . '</p>';
        echo '</td>';
        echo '<td class="rightpart" id="last-topic">';
            if(isset($row['topic_id'])) {
                echo '<a href="topic.php?topic_id=' . $row['topic_id'] . '&page=1">' . $row['topic_subject'] . '<br></a><p class="small-text"> at ' . date('g:i a', strtotime($row['topic_date'])) . ' on ' . date('d M, Y', strtotime($row['topic_date'])) . '</p>';
            }
        echo '</td>';
    echo '</tr>';
}

echo '</table>';
echo '</div>';
include 'footer.php';
?>
