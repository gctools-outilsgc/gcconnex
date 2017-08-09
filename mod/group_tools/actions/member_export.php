<?php

/**
* Group Tools
*
* Export the members of a group to CSV
* 
* @author ColdTrick IT Solutions
*/	

$group_guid = (int) get_input('group_guid');

if (empty($group_guid)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

elgg_entity_gatekeeper($group_guid, 'group');
$group = get_entity($group_guid);
if (!$group->canEdit() || (elgg_get_plugin_setting('member_export', 'group_tools') != 'yes')) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

$group_admins = [];
if (group_tools_multiple_admin_enabled()) {
	$group_admins = elgg_get_entities_from_relationship([
		'type' => 'user',
		'limit' => false,
		'relationship' => 'group_admin',
		'relationship_guid' => $group->getGUID(),
		'inverse_relationship' => true,
		'wheres' => [
			"e.guid <> {$group->getOwnerGUID()}",
		],
		'callback' => function($row) {
			return (int) $row->guid;
		},
	]);
}

// create temp file
$fh = tmpfile();

// write header line
$headers = [
	'displayname',
	'username',
	'email',
	'banned',
	'member since (unix)',
	'member since (YYYY-MM-DD HH:MM:SS)',
	'role',
];
$profile_fields = elgg_get_config('profile_fields');
if (!empty($profile_fields)) {
	foreach ($profile_fields as $metadata_name => $type) {
		$lan_key = "profile:{$metadata_name}";
		$header = $metadata_name;
		if (elgg_language_key_exists($lan_key)) {
			$header = elgg_echo($lan_key);
		}
		
		$header = html_entity_decode($header);
		$header = str_ireplace("\"", " ", str_ireplace(PHP_EOL, "", $header));
		$headers[] = $header;
	}
}
fputcsv($fh, $headers, ';');

// get members
$options = [
	'type' => 'user',
	'limit' => false,
	'relationship' => 'member',
	'relationship_guid' => $group->getGUID(),
	'inverse_relationship' => true,
];

$members = new ElggBatch('elgg_get_entities_from_relationship', $options);
/* @var $member ElggUser */
foreach ($members as $member) {
	// basic user information
	$info = [
		$member->name,
		$member->username,
		$member->email,
		$member->banned,
	];
	
	// member since
	$member_since = group_tools_get_membership_information($member, $group);
	$info[] = $member_since;
	$info[] = date('Y-m-d G:i:s', $member_since);
	
	// role
	if ($group->getOwnerGUID() === $member->getGUID()) {
		// owner
		$info[] = 'owner';
	} elseif (in_array($member->getGUID(), $group_admins)) {
		$info[] = 'group admin';
	} else {
		$info[] = 'member';
	}
	
	// profile fields
	if (!empty($profile_fields)) {
		foreach ($profile_fields as $metadata_name => $type) {
			
			$value = $member->$metadata_name;
			if (is_array($value)) {
				$value = implode(', ', $value);
			}
			
			$value = html_entity_decode($value);
			$value = str_ireplace("\"", " ", str_ireplace(PHP_EOL, "", $value));
			$info[] = $value;
		}
	}
	
	fputcsv($fh, $info, ';');
}

// read the csv in to a var before output
$contents = '';
rewind($fh);
while (!feof($fh)) {
	$contents .= fread($fh, 2048);
}

// cleanup the temp file
fclose($fh);

// output the csv
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . elgg_get_friendly_title($group->name) . '.csv"');
header('Content-Length: ' . strlen($contents));

echo $contents;
exit();
