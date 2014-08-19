<?php

/**
 * Add field mapping
 *
 * @package upload_users
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jaakko Naakka / Mediamaisteri Group
 * @author Ismayil Khayredinov / Arck Interactive
 * @copyright Mediamaisteri Group 2009
 * @copyright ArckInteractive 2013
 * @link http://www.mediamaisteri.com/
 * @link http://arckinteractive.com/
 */
$guid = get_input('guid');
$file = get_entity($guid);

if (!elgg_instanceof($file, 'object', 'upload_users_file')) {
	register_error(elgg_echo('upload_users:error:cannot_open_file'));
	forward(REFERER);
}


$headers = get_input('header');

foreach ($headers as $header => $mapping) {
	$metadata_name = $mapping['mapping'];
	if ($metadata_name == 'custom') {
		$metadata_name = $mapping['custom'];
	}

	$mapped_headers[$header] = array(
		'metadata_name' => $metadata_name,
		'access_id' => $mapping['access_id'],
		'value_type' => $mapping['value_type']
	);

	if (in_array($metadata_name, array('username', 'name', 'email', 'password'))) {
		$mapped_required[$metadata_name] = array($header);
	}
}

$file->setHeaderMapping($mapped_headers);
$file->setRequiredFieldMapping($mapped_required);

$template = get_input('template');
if ($template) {
	$templates = elgg_get_plugin_setting('templates', 'upload_users');
	$templates = ($templates) ? unserialize($templates) : array();
	$templates[$template] = $mapped_headers;
	elgg_set_plugin_setting('templates', serialize($templates), 'upload_users');
}

if (array_key_exists('username', $mapped_required) && array_key_exists('name', $mapped_required) && array_key_exists('email', $mapped_required)) {
	$file->setStatus('mapped');
	forward("admin/users/upload");
} else {
	$file->setStatus('premapped');
	forward("admin/users/upload?guid=$file->guid");
}

