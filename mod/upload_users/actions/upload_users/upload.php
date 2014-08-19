<?php

/**
 * Process an uploaded CSV file
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

// Process uploaded file
if (isset($_FILES['csvfile']) && $_FILES['csvfile']['error'] == 0) {
	$contents = file_get_contents($_FILES['csvfile']['tmp_name']);
}

if (!$contents) {
	register_error(elgg_echo('upload_users:error:cannot_open_file'));
	forward(REFERER);
}

// Modify encoding if not UTF-8
$encoding = get_input('encoding', 'UTF-8');
if ($encoding != 'UTF-8') {
	$contents = iconv($encoding, 'UTF-8//IGNORE', $contents);
}

$time = time();
$name = $_FILES['csvfile']['name'];

// Store uploaded file contents on Elgg's filestore and create a new upload_users_file entity
$file = new UploadUsersFile();
$file->owner_guid = elgg_get_logged_in_user_guid();
$file->setFilename("upload_users/{$time}{$name}");
$file->open("write");
$file->write($contents);
$file->close();

// Attach metadata describing processing logic and parameter4es
$file->setStatus('uploaded');

$template = get_input('template', 'new');
if ($template != 'new') {
	$templates = unserialize(elgg_get_plugin_setting('templates', 'upload_users'));
	$file->setHeaderMapping($templates[$template]);
}

$file->delimiter = get_input('delimiter', ',');
$file->enclosure = get_input('enclosure', '"');
$file->originalfilename = $name;

$settings = array(
	'notification',
	'update_existing_users',
	'fix_usernames',
	'fix_passwords',
);

foreach ($settings as $setting) {
	$file->$setting = (bool)get_input($setting, false);
}

if (!$file->parseCSVHeader() || !$file->save()) { // CSV can not be parsed or file can not be saved
	$file->delete();
	register_error(elgg_echo('upload_users:error:cannot_open_file'));
	forward(REFERER);
}

$guid = $file->getGUID();

forward("admin/users/upload?guid=$guid");