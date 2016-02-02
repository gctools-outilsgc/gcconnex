<?php



$gcf_new_category = elgg_view('input/submit', array(
'value' => elgg_echo('gcforums:submit'),
'name' => 'gcf_category',
));

// hidden field for title
$gcf_ = elgg_view('input/hidden', array(
	'name' => 'gcf_title',
	'value' => "RE: $object_guid",
	));


echo <<<___HTML



___HTML;
