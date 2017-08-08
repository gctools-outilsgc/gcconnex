<?php

echo elgg_view('input/text', [
	'name' => 'q',
	'value' => elgg_extract('query', $vars),
]);
echo elgg_view('input/submit', ['value' => elgg_echo('search')]);
	
