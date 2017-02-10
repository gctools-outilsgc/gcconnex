<?php


if (!elgg_is_xhr()) {
	register_error('Sorry, Ajax only!');
	forward();
}


$username = get_input('username');






echo json_encode([
	'num_content' => $number_of_content,
]);


