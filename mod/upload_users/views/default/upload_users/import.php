<?php

$guid = get_input('guid');
$file = get_entity($guid);

if (!elgg_instanceof($file, 'object', 'upload_users_file')) {
	register_error(elgg_echo('upload_users:error:file_open_error'));
	forward("admin/users/upload");
}

if ($file->status !== 'imported') {

	set_time_limit(0);

	$imp = new UploadUsers();

	$imp->setNotificationFlag($file->notification);
	$imp->setUpdateExistingUsersFlag($file->update_existing_users);
	$imp->setFixUsernamesFlag($file->fix_usernames);
	$imp->setFixPasswordsFlag($file->fix_passwords);

	$imp->setHeaderMapping($file->getHeaderMapping());
	$imp->setRequiredFieldMapping($file->getRequiredFieldMapping());

	$data = $file->parseCSV();
	
	$report = $imp->processRecords($data);

	if (($handle = fopen($file->getFilenameOnFilestore(), 'w')) !== FALSE) {
		$headerDisplayed = false;

		foreach ($report as $data) {
			// Add a header row if it hasn't been added yet
			if (!$headerDisplayed) {
				// Use the keys from $data as the titles
				fputcsv($handle, array_keys($data));
				$headerDisplayed = true;
			}

			// Put the data into the stream
			fputcsv($handle, $data);
		}
		fclose($handle);
	}
	$file->status = 'imported';
} else {
	$report = $file->parseCSV();
}

$header = array_keys($report[0]);

$title = elgg_view_title(elgg_echo('upload_users:report'));

$body .= '<div style="overflow-y:scroll;">';

$body .= '<table class="elgg-table-alt">';
$body .= '<thead>';
$body .= '<tr>';
foreach ($header as $h) {
	$body .= '<th>' . $h . '</th>';
}
$body .= '</tr>';
$body .= '</thead>';

$body .= '<tbody>';
foreach ($report as $record) {

	if ($record['__upload_users_status'] == 'complete') {
		$class = 'upload-users-success';
	} else {
		$class = 'upload-users-error';
	}

	$body .= "<tr class=\"$class\">";
	foreach ($record as $k => $value) {
		if (is_array($value)) {
			$value = implode('<br />', $value);
		}
		$body .= '<td>' . $value . '</td>';
	}
	$body .= '</tr>';
}

$body .= '</tbody>';
$body .= '</table>';

$body .= '</div>';

$body .= '<div class="elgg-foot mtl">';
$body .= elgg_view('output/url', array(
	'text' => elgg_echo('upload_users:continue:download_report'),
	'href' => "upload_users/report?guid=$file->guid",
	'class' => 'elgg-button elgg-button-action',
		));
$body .= elgg_view('output/url', array(
	'text' => elgg_echo('upload_users:delete'),
	'href' => "action/upload_users/delete?guid=$file->guid",
	'is_action' => true,
	'class' => 'elgg-button elgg-button-action',
		));
$body .= '</div>';

echo elgg_view_module('aside', $title, $body, array(
	'class' => 'mam'
));