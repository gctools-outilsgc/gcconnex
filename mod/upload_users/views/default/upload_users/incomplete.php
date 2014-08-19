<?php

$files = elgg_get_entities(array(
	'types' => 'object',
	'subtypes' => 'upload_users_file',
	'limit' => 0
		));

if (!$files) {
	return;
}

$title = elgg_echo('upload_users:incomplete');

foreach ($files as $file) {

	$filename = $file->originalfilename;

	switch ($file->status) {

		default :
		case 'uploaded' :
		case 'premapped' :
			$filename .= '<div class="elgg-loud pll">' . elgg_echo('upload_users:status:mapping_pending') . '</div>';
			$actions = elgg_view('output/url', array(
				'text' => elgg_echo('upload_users:continue:map'),
				'href' => "admin/users/upload?guid=$file->guid",
				'class' => 'elgg-button elgg-button-action',
			));

			break;

		case 'mapped' :

			$filename .= '<span class="elgg-loud pll">' . elgg_echo('upload_users:status:ready_for_import') . '</span>';

			$actions = elgg_view('output/url', array(
				'text' => elgg_echo('upload_users:continue:import'),
				'href' => "admin/users/upload?guid=$file->guid",
				'class' => 'elgg-button elgg-button-action upload-users-warning',
				'rel' => elgg_echo('upload_users:continue:import:warning')
			));

			break;

		case 'imported' :

			$actions = elgg_view('output/url', array(
				'text' => elgg_echo('upload_users:continue:download_report'),
				'href' => "upload_users/report?guid=$file->guid",
				'class' => 'elgg-button elgg-button-action',
			));

			$actions .= elgg_view('output/url', array(
				'text' => elgg_echo('upload_users:continue:view_report'),
				'href' => "admin/users/upload?guid=$file->guid",
				'class' => 'elgg-button elgg-button-action',
			));

			$filename .= '<span class="elgg-loud pll">' . elgg_echo('upload_users:status:imported') . '</span>';
			break;
	}

	$actions .= elgg_view('output/url', array(
		'text' => elgg_echo('upload_users:delete'),
		'href' => "action/upload_users/delete?guid=$file->guid",
		'is_action' => true,
		'class' => 'elgg-button elgg-button-action',
	));

	$body .= elgg_view_image_block('', $filename, array(
		'image_alt' => $actions,
		'class' => 'mam pam elgg-divide-top elgg-divide-bottom'
	));
}


echo elgg_view_module('aside', $title, $body, array(
	'class' => 'mam'
));