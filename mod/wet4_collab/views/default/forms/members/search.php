<?php
/*
* GC_MODIFICATION
* Description: Added accessible labels + GSA tie in
* Author: GCTools Team
*/

echo '<label for="member_query" class="wb-inv">'.elgg_echo('members:search').'</label>';
echo elgg_view('input/text', array(
    'id' => 'member_query',
	'name' => 'q',
	'placeholder' => elgg_echo('wet:searchgctools'),
	'required' => true
));

$user_types = array(
	'' => elgg_echo('gcRegister:make_selection'),
	'academic' => elgg_echo('gcRegister:occupation:academic'),
	'student' => elgg_echo('gcRegister:occupation:student'),
	'federal' => elgg_echo('gcRegister:occupation:federal'),
	'provincial' => elgg_echo('gcRegister:occupation:provincial'),
	'municipal' => elgg_echo('gcRegister:occupation:municipal'),
	'international' => elgg_echo('gcRegister:occupation:international'),
	'ngo' => elgg_echo('gcRegister:occupation:ngo'),
	'community' => elgg_echo('gcRegister:occupation:community'),
	'business' => elgg_echo('gcRegister:occupation:business'),
	'media' => elgg_echo('gcRegister:occupation:media'),
	'retired' => elgg_echo('gcRegister:occupation:retired'),
	'other' => elgg_echo('gcRegister:occupation:other')
);
echo "<label class='mtm' for='user_type'>" . elgg_echo('gcRegister:membertype') . "</label>" . elgg_view('input/dropdown', array('id' => 'user_type', 'class' => 'mbm', 'name' => 'user_type', 'options_values' => $user_types));

echo elgg_view('input/hidden', array('name' => 'entity_type', 'value' => 'user'));
echo elgg_view('input/hidden', array('name' => 'search_type', 'value' => 'entities'));
echo elgg_view('input/submit', array('value' => '<span class="glyphicon-search glyphicon"></span> ' . elgg_echo('search')));

echo "<p class='mtl elgg-text-help timeStamp'>" . elgg_echo('members:total', array(get_number_users())) . "</p>";
