<?php

 $params = array(
 	'name' => 'q', // GSA name so the query goes through gsa
//     //'action'=>'/search',
//     'id' => 'member_query',
// 	'class' => 'mbm',
// 	'required' => true,
 );
echo '<label for="member_query" class="wb-inv">'.elgg_echo('members:search').'</label>'.elgg_view('input/text', $params);
//echo elgg_view('input/hidden', array('name'=>'gcconnex[]', 'value'=>'Members',)); //hidden input to filter search results to only gcconnex members 

// cyu - patched so that the member search will use the gsa (gcintranet)
echo elgg_view('input/hidden', array('name'=>'a', 'value'=>'s'));
echo elgg_view('input/hidden', array('name'=>'s', 'value'=>'3'));
echo elgg_view('input/hidden', array('name'=>'chk4', 'value'=>'on'));
echo elgg_view('input/hidden', array('name'=>'gcc', 'value'=>'2')); 


echo elgg_view('input/submit', array('value' => elgg_echo('search')));

echo "<p class='mtl elgg-text-help timeStamp'>" . elgg_echo('members:total', array(get_number_users())) . "</p>";