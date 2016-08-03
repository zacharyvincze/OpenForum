<?php

/*
List categories (Home page)
*/

include 'includes/connect.php';
include 'header.php';
include 'includes/query-functions.php';

date_default_timezone_set('America/Toronto');

$query = "SELECT
            c.cat_name, c.cat_description, t.topic_subject, t.topic_date, c.cat_id, t.topic_id
          FROM categories c
          LEFT JOIN topics t ON c.cat_id = t.topic_cat
          WHERE topic_date = (
            SELECT MAX(t2.topic_date)
            FROM topics t2
            WHERE t2.topic_cat = t.topic_cat
          )
          ORDER BY c.cat_id";
$stmt = $connect->query($query);

echo $connect->error;

echo '<div class="container">';
echo '<table>';

$x = 0;

while($row = $stmt->fetch_assoc()) {

    if(getTopicCount($row['cat_id']) == 1) $topic = 'topic';
    else $topic = 'topics';
    $x++;

    $class = ($x%2 == 0)? 'whiteBackground' : 'grayBackground';

    echo "<tr class='$class'>";
        echo '<td class="leftpart">';
            echo '<h3><a href="/category.php?cat_id=' . $row['cat_id'] . '">' . $row['cat_name'] . '</a></h3><p class="small-text">' . ($row['cat_description']) . '</p>';
        echo '</td>';
        echo '<td class="middle" id="last-topic">';
            echo '<p class="big-number">' . getTopicCount($row['cat_id']) . '</p><p class="small-text-gray"> ' . $topic . '</p>';
        echo '</td>';
        echo '<td class="rightpart" id="last-topic">';
            echo '<a href="topic.php?topic_id=' . $row['topic_id'] . '&page=1">' . $row['topic_subject'] . '<br></a><p class="small-text"> at ' . date('g:i a', strtotime($row['topic_date'])) . ' on ' . date('d M, Y', strtotime($row['topic_date'])) . '</p>';
        echo '</td>';
    echo '</tr>';
}

echo '</table>';
echo '</div>';
include 'footer.php';
?>
