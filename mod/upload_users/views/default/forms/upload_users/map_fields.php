<?php

$guid = get_input('guid');
$file = get_entity($guid);

if (!elgg_instanceof($file, 'object', 'upload_users_file')) {
	register_error(elgg_echo('upload_users:error:file_open_error'));
	forward("admin/users/upload");
}

$headers = $file->parseCSVHeader();
$header_mapping = $file->getHeaderMapping();

$mapping_options = array(
	'custom' => elgg_echo('upload_users:mapping:custom'),
	'guid' => elgg_echo('upload_users:mapping:guid'),
	'username' => elgg_echo('upload_users:mapping:username'),
	'name' => elgg_echo('upload_users:mapping:name'),
	'email' => elgg_echo('upload_users:mapping:email'),
	'password' => elgg_echo('upload_users:mapping:password'),
);

// Add Profile Manager fields
if (elgg_is_active_plugin('profile_manager')) {
	$options = array(
		'type' => 'object',
		'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
		'limit' => 0,
		'count' => false
	);

	$custom_fields = elgg_get_entities($options);

	if ($custom_fields) {
		foreach ($custom_fields as $field) {
			$option = $field->getTitle();
			if ($category_guid = $field->category_guid) {
				$category = get_entity($category_guid);
				$option = "$option ({$category->getTitle()})";
			}
			$mapping_options[$field->metadata_name] = $option;
		}
	}
}

// Add Roles mapping
if (elgg_is_active_plugin('roles')) {
	$mapping_options["user_upload_role"] = elgg_echo('upload_users:mapping:user_upload_role');
}

// Grab all other user metadata names from the database

$extra_mapping_options = array();
foreach ($mapping_options as $md_name => $readable) {
	$id = get_metastring_id($md_name);
	if ($id) {
		$not_in[] = $id;
	}
}

$dbprefix = elgg_get_config('dbprefix');
$query = "SELECT DISTINCT(md.name_id) FROM {$dbprefix}metadata md
					JOIN {$dbprefix}entities e ON md.entity_guid = e.guid
					WHERE e.type = 'user'";
if (count($not_in)) {
	$not_in_str = implode(',', $not_in);
	$query .= " AND md.name_id NOT IN ($not_in_str)";
}

$md_names = get_data($query);
foreach ($md_names as $md_name) {
	$string = get_metastring($md_name->name_id);
	if ($string && !is_int($string)) {
		$extra_mapping_options[$string] = $string;
	}
}

if ($extra_mapping_options) {
	ksort($extra_mapping_options);
	$mapping_options = array_merge($mapping_options, $extra_mapping_options);
}

echo '<div class="elgg-loud"><strong>' . elgg_echo('upload_users:mapping:instructions') . '</strong></div>';

echo '<table class="elgg-table-alt upload-users-mapping mam">';

echo '<thead>';
echo '<tr>';
echo '<th>' . elgg_echo('upload_users:mapping:csv_header') . '</th>';
echo '<th>' . elgg_echo('upload_users:mapping:elgg_header') . '</th>';
echo '<th>' . elgg_echo('upload_users:mapping:access_id') . '</th>';
echo '<th>' . elgg_echo('upload_users:mapping:value_type') . '</th>';
echo '</tr>';
echo '</thead>';

echo '<tbody>';
foreach ($headers as $header) {
	echo '<tr>';
	echo '<td>';
	echo '<label>' . $header . '</label>';
	echo '</td>';
	echo '<td>';

	$access_id = ACCESS_PRIVATE;
	$value_type = 'text';
	
	if (isset($header_mapping[$header])) {
		if (is_array($header_mapping[$header])) {
			$mapping_value = $header_mapping[$header]['metadata_name'];
			$access_id = $header_mapping[$header]['access_id'];
			$value_type = $header_mapping[$header]['value_type'];
			$custom_input_class = 'hidden';
		} else {
			$mapping_value = $header_mapping[$header];
		}
	} else if (array_key_exists($header, $mapping_options)) {
		$mapping_value = $header;
		$custom_input_class = 'hidden';
	} else {
		$mapping_value = null;
		$custom_input_class = '';
	}

	echo elgg_view('input/dropdown', array(
		'name' => "header[$header][mapping]",
		'options_values' => $mapping_options,
		'value' => $mapping_value
	));

	echo elgg_view('input/text', array(
		'name' => "header[$header][custom]",
		'value' => preg_replace('/[^a-z0-9\-]/i', '_', strtolower($header)),
		'class' => $custom_input_class
	));

	echo '</td>';

	echo '<td>';

	if (!in_array($header, array('guid', 'username', 'name', 'email', 'password'))) {
		echo elgg_view('input/access', array(
			'name' => "header[$header][access_id]",
			'value' => $access_id
		));
	}
	
	echo '</td>';

	echo '<td>';

	if (!in_array($header, array('guid', 'username', 'name', 'email', 'password'))) {
		echo elgg_view('input/dropdown', array(
			'name' => "header[$header][value_type]",
			'options_values' => array(
				'text' => elgg_echo('upload_users:mapping:value_type:text'),
				'tags' => elgg_echo('upload_users:mapping:value_type:tags'),
				'timestamp' => elgg_echo('upload_users:mapping:value_type:timestamp'),
			),
			'value' => $value_type
		));
	}

	echo '</td>';

	echo '</tr>';
}
echo '</tbody>';
echo '</table>';


echo '<div>';
echo '<label>' . elgg_echo('upload_users:save_as_template') . '</label>';
echo elgg_view('input/text', array('name' => 'template'));
echo '</div>';

echo '<div class="elgg-foot">';
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $file->guid));
echo elgg_view('input/submit', array('value' => elgg_echo('next')));
echo '</div>';