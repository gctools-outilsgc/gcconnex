<?php


if (!elgg_is_xhr()) {
	register_error('Sorry, Ajax only!');
	forward();
}

$offset = (int)get_input('list_offset');

$url = "http://192.168.0.26/gcconnex/services/api/rest/json/?method=get.user_list&api_key=b9e52e09cb8c5df4d5ac1eb6adb0ab6d4507fc00&offset={$offset}";

$items = json_decode(file_get_contents($url), true);


$items = $items['result'];
$num = 50;
$pages = ceil($num / 10);
$tbody = array();
foreach ($items as $item) {

    error_log("item: {$item['guid']}");

    $tbody[] = "<tr> <td>{$item['name']['en']}</td> <td>{$item['date_created']}</td> </tr>";
}

error_log("sup.");

echo json_encode([
	'member_list' => $tbody,
]);