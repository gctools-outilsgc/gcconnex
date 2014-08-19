<?php

/**
 * A series of actions to perform on plugin de-activation
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

// Remove incomplete uploads
$options = array(
	'types' => 'object',
	'subtypes' => 'upload_users_file',
	'limit' => 0
);

$batch = new ElggBatch('elgg_get_entities', $options);
foreach ($batch as $file) {
	$file->delete();
}


remove_subtype('object', 'upload_users_file');

