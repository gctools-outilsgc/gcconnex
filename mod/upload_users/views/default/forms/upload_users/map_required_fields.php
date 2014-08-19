<?php

$guid = get_input('guid');
$file = get_entity($guid);

if (!elgg_instanceof($file, 'object', 'upload_users_file')) {
	register_error(elgg_echo('upload_users:error:file_open_error'));
	forward("admin/users/upload");
}

$mapped_required = $file->getRequiredFieldMapping();
if (!$mapped_required) {
	$mapped_required = array();
}

$mapped_headers = $file->getHeaderMapping();
$options = array('' => elgg_echo('upload_users:mapping:select'));
foreach ($mapped_headers as $header => $metadata_name) {
	$options[] = $header;
}

echo '<div class="elgg-loud"><strong>' . elgg_echo('upload_users:mapping:instructions_required') . '</strong></div>';

echo '<table class="elgg-table-alt upload-users-attributes mam">';
echo '<thead>';
echo '<tr>';
echo '<th>' . elgg_echo('upload_users:mapping:attribute') . '</th>';
echo '<th>' . elgg_echo('upload_users:mapping:components') . '</th>';
echo '</tr>';
echo '</thead>';

echo '<tbody>';

if (!array_key_exists('email', $mapped_required)) {
	echo '<tr>';
	echo '<td>';
	echo '<label>email</label>';
	echo '</td>';
	echo '<td>';
	echo elgg_view('input/dropdown', array(
		'name' => 'required[email][]',
		'options' => $options
	));
	echo '</td>';
	echo '</tr>';
}

if (!array_key_exists('name', $mapped_required)) {
	echo '<tr>';
	echo '<td>';
	echo '<label>name</label>';
	echo '</td>';
	echo '<td>';
	for ($i = 0; $i < 3; $i++) {
		echo elgg_view('input/dropdown', array(
			'required' => ($i == 0),
			'name' => 'required[name][]',
			'options' => $options
		));
	}
	echo '</td>';
	echo '</tr>';
}

if (!array_key_exists('name', $mapped_required)) {
	echo '<tr>';
	echo '<td>';
	echo '<label>username</label>';
	echo '</td>';
	echo '<td>';
	for ($i = 0; $i < 3; $i++) {
		echo elgg_view('input/dropdown', array(
			'name' => 'required[username][]',
			'options' => $options
		));
	}
	echo '</td>';
	echo '</tr>';
}

if (!array_key_exists('password', $mapped_required)) {
	echo '<tr>';
	echo '<td>';
	echo '<label>password</label>';
	echo '</td>';
	echo '<td>';
	echo elgg_echo('upload_users:random_cleartext_passowrd');
	echo '</td>';
	echo '</tr>';
}

echo '</tbody>';
echo '</table>';

echo '<div class="elgg-foot">';
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $file->guid));
echo elgg_view('input/submit', array('value' => elgg_echo('next')));
echo '</div>';