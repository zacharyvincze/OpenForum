<?php

/*
   List categories (Home page)
 */

include_once '../resources/configuration/config.php';
include_once LIBRARY_PATH . '/connect.php';
include_once CONFIGURATION_PATH . '/strings.php';
include_once LIBRARY_PATH . '/query-functions.php';
include_once LIBRARY_PATH . '/functions.php';
include_once TEMPLATES_PATH . '/header.php';

date_default_timezone_set(TIMEZONE);

$query = "SELECT cat_id, cat_description, cat_name, topic_subject, topic_id, latest as topic_date
FROM categories c
LEFT JOIN (
		SELECT topic_subject, topic_id, topic_cat, MAX(topic_date) latest
		FROM topics
		WHERE topic_visible=\"TRUE\"
		GROUP BY topic_id DESC
		LIMIT 1
	  ) as t
ON c.cat_id = t.topic_cat
ORDER BY c.cat_id";
$stmt = $connect->query($query) or die((DEVELOPMENT_MODE ? $connect->error : ERROR_CONNECTION_FAILED));

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
	echo '<h3><a href="category.php?cat_id=' . $row['cat_id'] . '">' . htmlspecialchars($row['cat_name']) . '</a></h3><p class="small-text primary-text-color">' . htmlspecialchars($row['cat_description']) . '</p>';
	echo '</td>';
	echo '<td class="middle" id="last-topic">';
	echo '<p class="big-number">' . getTopicCount($row['cat_id']) . '</p><p class="small-text-gray"> ' . $topic . '</p>';
	echo '</td>';
	echo '<td class="rightpart" id="last-topic">';
	if(isset($row['topic_id'])) {
		echo '<a href="topic.php?topic_id=' . $row['topic_id'] . '&page=1">' . htmlspecialchars($row['topic_subject']) . '<br></a><p class="small-text"> at ' . date('g:i A', strtotime($row['topic_date'])) . ' on ' . date('M d', strtotime($row['topic_date'])) . '</p>';
	}
	echo '</td>';
	echo '</tr>';
}

echo '</table>';
echo '</div>';
include TEMPLATES_PATH . '/footer.php';
?>
