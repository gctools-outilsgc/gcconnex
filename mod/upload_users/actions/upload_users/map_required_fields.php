<?php

/**
 * Add required field components mapping
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

$mapped_headers = $file->getHeaderMapping();
$mapped_required = $file->getRequiredFieldMapping();
if (!$mapped_required) {
	$mapped_required = array();
}

$required_fields = get_input('required');

foreach ($required_fields as $required => $mapping) {
	foreach ($mapping as $csv_header) {
		if (isset($mapped_headers[$csv_header])) {
			$mapped_required[$required][] = $csv_header;
		}
	}
	if (empty($mapped_required[$required])) {
		forward(REFERER);
	}
}

$file->setRequiredFieldMapping($mapped_required);

$file->setStatus('mapped');

forward("admin/users/upload");