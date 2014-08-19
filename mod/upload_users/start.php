<?php

/**
 * Upload users. Generate user accounts from an uploaded CSV file
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
elgg_register_event_handler('init', 'system', 'upload_users_init', 1);
elgg_register_event_handler('upgrade', 'system', 'upload_users_upgrade_v1_8_2');

/**
 * Initialize upload users on system init
 */
function upload_users_init() {

	$path = elgg_get_plugins_path() . 'upload_users/';

	elgg_register_classes("{$path}classes/");

	elgg_register_admin_menu_item('administer', 'upload', 'users');

	elgg_register_action('upload_users/delete', "{$path}actions/upload_users/delete.php", 'admin');
	elgg_register_action('upload_users/upload', "{$path}actions/upload_users/upload.php", 'admin');
	elgg_register_action('upload_users/map_fields', "{$path}actions/upload_users/map_fields.php", 'admin');
	elgg_register_action('upload_users/map_required_fields', "{$path}actions/upload_users/map_required_fields.php", 'admin');

	$css = elgg_get_simplecache_url('css', 'upload_users/css');
	elgg_register_css('upload_users.css', $css);

	$js = elgg_get_simplecache_url('js', 'upload_users/js');
	elgg_register_js('upload_users.js', $js);

	elgg_register_plugin_hook_handler('header:custom_method', 'upload_users', 'upload_users_set_role');

	elgg_register_page_handler('upload_users', 'upload_users_page_handler');
}

/**
 * Page handler for CSV download
 *
 * @param array $page
 */
function upload_users_page_handler($page) {

	admin_gatekeeper();

	switch ($page[0]) {

		default :

			return false;

		case 'report' :

			$file_guid = get_input("guid");

			$file = get_entity($file_guid);
			if (!$file) {
				register_error(elgg_echo('upload_users:error:file_open_error'));
				forward("admin/users/upload");
			}

			header("Pragma: public");
			header("Content-type: text/csv");
			header("Content-Disposition: attachment; filename=\"$file->originalfilename\"");

			ob_clean();
			flush();
			readfile($file->getFilenameOnFilestore());
			exit;

			break;

		case 'sample' :

			set_time_limit(0);

			$limit = get_input('limit', 20);
			$offset = get_input('offset', 0);

			$fileName = 'upload_users_sample.csv';

			header('Content-Description: File Transfer');
			header("Content-type: text/csv");
			header("Content-Disposition: attachment; filename={$fileName}");
			header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+1 day")), true);
			header("Pragma: public");


			$dbprefix = elgg_get_config('dbprefix');
			$query = "SELECT DISTINCT(md.name_id) FROM {$dbprefix}metadata md
					JOIN {$dbprefix}entities e ON md.entity_guid = e.guid
					WHERE e.type = 'user'";

			$md_names = get_data($query);
			foreach ($md_names as $md_name) {
				$string = get_metastring($md_name->name_id);
				if ($string && !is_int($string) && !in_array($string, array('name', 'username', 'password', 'email', 'user_upload_role'))) {
					$md[] = $string;
				}
			}

			$results = array();

			$options = array(
				'types' => 'user',
				'limit' => $limit,
				'offset' => $offset,
				'order_by' => 'e.time_created ASC'
			);

			$batch = new ElggBatch('elgg_get_entities', $options);

			foreach ($batch as $user) {

				$results[$user->guid] = array(
					'name' => $user->name,
					'username' => $user->username,
					'password' => '',
					'email' => $user->email,
					'user_upload_role' => (elgg_is_active_plugin('roles')) ? roles_get_role()->name : null
				);

				foreach ($md as $string) {
					$value = $user->$string;
					if (is_array($value)) {
						$value = implode(', ', $value);
					}

					$results[$user->guid][$string] = $value;
				}
			}

			$fh = @fopen('php://output', 'w');

			$headerDisplayed = false;

			foreach ($results as $data) {
				// Add a header row if it hasn't been added yet
				if (!$headerDisplayed) {
					// Use the keys from $data as the titles
					fputcsv($fh, array_keys($data));
					$headerDisplayed = true;
				}

				// Put the data into the stream
				fputcsv($fh, $data);
			}
			fclose($fh);
			exit;
			break;
	}
}

/**
 * Set user role upon import
 *
 * @global array $UPLOAD_USERS_ROLES_CACHE Cache roles
 * @param string $hook Equals 'header:custom_method'
 * @param string $type Equals 'upload_users'
 * @param boolean $return Return flag received by the hook
 * @param array $params An array of additional hook parameters
 * @return boolean If true, the upload script will not attempt to store the value as metadata
 */
function upload_users_set_role($hook, $type, $return, $params) {

	if (!elgg_is_active_plugin('roles')) {
		return $return;
	}

	$metadata_name = $params['metadata_name'];
	$user = $params['user'];
	$value = $params['value'];

	if ($metadata_name != 'user_upload_role' || !$value || !elgg_instanceof($user, 'user')) {
		return $return;
	}

	elgg_log("Upload users: assigning role $value to $user->guid");
	
	global $UPLOAD_USERS_ROLES_CACHE;

	if (!isset($UPLOAD_USERS_ROLES_CACHE[$value])) {
		$role = roles_get_role_by_name($value);
		if ($role) {
			$UPLOAD_USERS_ROLES_CACHE[$value] = $role;
		}
	} else {
		$role = $UPLOAD_USERS_ROLES_CACHE[$value];
	}


	return roles_set_role($role, $user);
}

/**
 * Run an upgrade script to port plugin settings to 1.8.2 format
 * @return boolean
 */
function upload_users_upgrade_v1_8_2() {

	if (elgg_get_plugin_setting('v1_8_2', 'upload_users')) {
		return true;
	}

	if (get_subtype_id('object', 'upload_users_file')) {
		update_subtype('object', 'upload_users_file', 'UploadUsersFile');
	} else {
		add_subtype('object', 'upload_users_file', 'UploadUsersFile');
	}

	$template_options = array();
	$templates = elgg_get_plugin_setting('templates', 'upload_users');
	if ($templates) {
		$templates = json_decode($templates, true);
		foreach ($templates as $template) {
			$template_options[$template] = json_decode(elgg_get_plugin_setting($template, 'upload_users'), true);
			elgg_unset_plugin_setting($template, 'upload_users');
		}
	}

	elgg_set_plugin_setting('templates', serialize($template_options), 'upload_users');
	elgg_set_plugin_setting('v1_8_2', true, 'upload_users');
}