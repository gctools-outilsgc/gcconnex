<?php

$params = array(
	'name' => 'q', // GSA name so the query goes through gsa
    //'action'=>'/search',
    'id' => 'member_query',
	'class' => 'mbm TESTING',
	'required' => true,
);
echo '<label for="member_query" class="wb-inv">'.elgg_echo('members:search').'</label>'.elgg_view('input/text', $params);
echo elgg_view('input/hidden', array('name'=>'gcconnex[]', 'value'=>'Members',)); //hidden input to filter search results to only gcconnex members 
echo elgg_view('input/submit', array('value' => elgg_echo('search')));

echo "<p class='mtl elgg-text-help timeStamp'>" . elgg_echo('members:total', array(get_number_users())) . "</p>";