<?php

elgg_require_js('group_tools/members_search');

$result = elgg_view('input/text', [
	'name' => 'members_search',
	'value' => get_input('members_search'),
	'placeholder' => elgg_echo('group_tools:forms:members_search:members_search:placeholder'),
]);

$result .= elgg_view('input/submit', [
	'class' => 'elgg-button-submit hidden',
	'value' => elgg_echo('search'),
]);

echo $result;
