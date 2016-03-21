<?php

$params = array(
	'name' => 'member_query',
    'id' => 'member_query',
	'class' => 'mbm',
	'required' => true,
);
echo '<label for="member_query" class="wb-inv">'.elgg_echo('members:search').'</label>'.elgg_view('input/text', $params);

echo elgg_view('input/submit', array('value' => elgg_echo('search')));

echo "<p class='mtl elgg-text-help timeStamp'>" . elgg_echo('members:total', array(get_number_users())) . "</p>";