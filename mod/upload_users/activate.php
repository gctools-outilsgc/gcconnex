<?php

/**
 * A series of actions to perform on plugin activation
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

if (get_subtype_id('object', 'upload_users_file')) {
	update_subtype('object', 'upload_users_file', 'UploadUsersFile');
} else {
	add_subtype('object', 'upload_users_file', 'UploadUsersFile');
}

