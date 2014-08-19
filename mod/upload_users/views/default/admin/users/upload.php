<?php

/**
 * Upload users admin interface
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
elgg_load_css('upload_users.css');
elgg_load_js('jquery.form');
elgg_load_js('upload_users.js');

$guid = get_input('guid');
$file = get_entity($guid);

switch ($file->status) {
	default :
		$body = elgg_view('upload_users/incomplete'); // Show unfinished user imports
		$body .= elgg_view('upload_users/upload'); // Show upload form
		$body .= elgg_view('upload_users/instructions'); // Show upload instructions
		break;

	case 'uploaded' :
		$body = elgg_view('upload_users/map_fields');
		break;

	case 'premapped' :
		$body = elgg_view('upload_users/map_required_fields');
		break;

	case 'mapped' :
	case 'imported' :
		$body = elgg_view('upload_users/import');
		break;

}

echo $body;
