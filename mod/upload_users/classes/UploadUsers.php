<?php

/**
 * Upload users helper class
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
class UploadUsers {

	var $records;
	var $mapped_headers;
	var $mapped_required_fields;
	var $notification = false;
	var $update_existing_users = false;
	var $fix_usernames = false;
	var $fix_passwords = false;

	function __construct() {
		$this->records = new stdClass();
	}

	/**
	 * Set alternative mapping of CSV headers to Elgg metadata
	 *
	 * @param $mapping array An array of $key => $value pairs, where $key is the CSV header and $value is an Elgg metadata mapped to it
	 */
	function setHeaderMapping($mapping) {
		$this->mapped_headers = $mapping;
	}

	/**
	 * Set alternative mapping of required user entity attributes to CSV headers
	 *
	 * @param array $mapping An array of $key => $value pairs, where $key is username, name or email and $value is an array of CSV headers which will be used to concatinate the value
	 */
	function setRequiredFieldMapping($mapping) {
		$this->mapped_required_fields = $mapping;
	}

	/**
	 * Send an email notification to new user accounts
	 *
	 * @param $flag boolean
	 */
	function setNotificationFlag($flag) {
		$this->notification = $flag;
	}

	/**
	 * Update user profile information if user account already exists
	 *
	 * @param $flag boolean
	 */
	function setUpdateExistingUsersFlag($flag) {
		$this->update_existing_users = $flag;
	}

	/**
	 * Fix usernames to meet Elgg requirements
	 *
	 * @param $flag boolean
	 */
	function setFixUsernamesFlag($flag) {
		$this->fix_usernames = $flag;
	}

	/**
	 * Fix passwords to meet Elgg requirements
	 *
	 * @param $flag boolean
	 */
	function setFixPasswordsFlag($flag) {
		$this->fix_passwords = $flag;
	}

	/**
	 * Add unmapped user data
	 *
	 * @param array $data
	 */
	function setRecords($data) {
		$this->records->source = $data;
	}

	/**
	 * Map user records
	 *
	 * @param $data
	 * @return boolean
	 */
	function mapRecords($data = null) {

		if (!$this->records->source) {
			$this->setRecords($data);
		}

		$this->records->mapped = array();

		foreach ($this->records->source as $record) {
			$this->records->mapped[] = $this->mapRecord($record);
		}
	}

	/**
	 * Map an individual user record
	 *
	 * @param array $record
	 * @return array
	 */
	function mapRecord($record) {

		// Set required keys
		$mapped_record = array(
			'__upload_users_status' => array(),
			'__upload_users_messages' => array(),
			'guid' => null,
			'email' => '',
			'username' => '',
			'name' => '',
			'password' => '',
		);

		// Map values
		$headers = $this->mapped_headers;
		if ($headers) {
			foreach ($headers as $original_header => $new_header) {
				if (is_array($new_header)) {
					$new_header = $new_header['metadata_name'];
				}
				if (!isset($mapped_record[$new_header])) {
					$mapped_record[$new_header] = $record[$original_header];
				}
			}
		} else {
			foreach ($record as $key => $value) {
				$mapped_record[$key] = $value;
			}
		}

		// Map required values
		$mapped_record['username'] = $this->getUsername($record);
		$mapped_record['name'] = $this->getName($record);
		$mapped_record['email'] = $this->getEmail($record);
		$mapped_record['password'] = $this->getPassword($record);

		return $mapped_record;
	}

	/**
	 * Validate records and create update and create queues
	 *
	 * @param mixed $data
	 */
	function queueRecords($data = null) {

		if (!$this->records->mapped) {
			$this->mapRecords($data);
		}

		$this->records->queue = array();

		foreach ($this->records->mapped as $record) {

			$create = true;
			$update = false;
			$messages = array();

			// First check if the user already exists
			if ($record['guid']) {
				$create = false;

				$record_entity = get_entity($record['guid']);
				if (elgg_instanceof($record_entity, 'user')) {
					$messages[] = elgg_echo('upload_users:error:userexists');
					if ($this->update_existing_users) {
						$update = true;
					}
				} else if ($this->update_existing_users) {
					$messages[] = elgg_echo('upload_users:error:invalid_guid');
				}
			} else {

				try {
					validate_email_address($record['email']);

					$record_by_username = get_user_by_username($record['username']);
					$record_by_email = get_user_by_email($record['email']);

					if (elgg_instanceof($record_by_username, 'user') || elgg_instanceof($record_by_email[0], 'user')) {
						$create = false;
						if ($record_by_username->guid != $record_by_email[0]->guid) {
							if ($this->fix_usernames && !$this->update_existing_users) {
								$create = true;
								while (get_user_by_username($record['username'])) {
									$record['username'] = $record['username'] . rand(1000, 9999);
								}
							} else {
								$messages[] = elgg_echo('upload_users:error:update_email_username_mismatch'); // username does not match with the email we have in the database
							}
						} else {
							$messages[] = elgg_echo('upload_users:error:userexists');
							if ($this->update_existing_users) {
								$record['guid'] = $record_by_username->guid;
								$update = true;
							}
						}
					}
				} catch (RegistrationException $r) {
					$create = false;
					$messages[] = $r->getMessage();
				}
			}

			// No existing accounts found; validate details for registration
			if ($create) {
				if (!$record['name']) {
					$create = false;
					$messages[] = elgg_echo('upload_users:error:empty_name');
				}

				try {
					validate_username($record['username']);
				} catch (RegistrationException $r) {
					$create = false;
					$messages[] = $r->getMessage();
				}

				if ($record['password']) {
					try {
						validate_password($record['password']);
					} catch (RegistrationException $r) {
						$create = false;
						$messages[] = $r->getMessage();
					}
				}
			}

			$record['__upload_users_messages'] = $messages;
			$record['__upload_users_status'] = false;

			if ($create || $update) {
				$record['__upload_users_status'] = true;
			}

			$this->records->queue[] = $record;
		}
	}

	/**
	 * Process queue
	 *
	 * @param mixed $data
	 */
	function processRecords($data = null) {
		if (!$this->records->queue) {
			$this->queueRecords($data);
		}

		foreach ($this->records->queue as $record) {
			if ($record['__upload_users_status']) {
				$record = $this->uploadUser($record);
			}

			if ($record['__upload_users_status']) {
				$record['__upload_users_status'] = 'complete';
			} else {
				$record['__upload_users_status'] = 'error';
			}

			$record['__upload_users_messages'] = implode("\n", $record["__upload_users_messages"]);

			$this->record->uploaded[] = $record;
		}

		return $this->record->uploaded;
	}

	/**
	 * Create a new user or update an existing user from record
	 * 
	 * @param array $record User record 
	 * @return array User record with status report
	 */
	function uploadUser($record) {


		if (!$record['guid']) {

			// No user, try registering
			try {

				if (!$record['password']) {
					$record['password'] = generate_random_cleartext_password();
				}

				$record['guid'] = register_user($record['username'], $record['password'], $record['name'], $record['email']);

				$user = get_entity($record['guid']);

				set_user_validation_status($record['guid'], true, 'upload_users');

				$hook_params = $record;
				$hook_params['user'] = $user;

				if (!elgg_trigger_plugin_hook('register', 'user', $hook_params, TRUE)) {
					$ia = elgg_set_ignore_access(true);
					$user->delete();
					elgg_set_ignore_access($ia);
					throw new RegistrationException(elgg_echo('registerbad'));
				}

				if ($this->notification) {
					$subject = elgg_echo('upload_users:email:subject', elgg_get_config('sitename'));
					$message = elgg_echo('upload_users:email:message', array($record['name'], elgg_get_config('sitename'), $record['username'], $record['password'], elgg_get_site_url()));
					notify_user($record['guid'], elgg_get_site_entity()->guid, $subject, $message);
				}
			} catch (RegistrationException $e) {
				$record['__upload_users_status'] = false;
				$record['__upload_users_messages'][] = $e->getMessage();
			}
		} else {
			$user = get_entity($record['guid']);
		}

		if (!elgg_instanceof($user, 'user')) {
			$record['__upload_users_status'] = false;
			return $record;
		}

		foreach ($record as $metadata_name => $metadata_value) {

			switch ($metadata_name) {

				case '__upload_users_status' :
				case '__upload_users_messages' :
				case 'guid' :
				case 'username' :
				case 'password' :
				case 'name' :
				case 'email' :
					continue;
					break;

				default :

					$metadata_value = trim($metadata_value);

					$header = $this->getHeaderForMetadataName($metadata_name);

					$hook_params = array(
						'header' => $header,
						'metadata_name' => $metadata_name,
						'value' => $metadata_value,
						'record' => $record,
						'user' => $user
					);

					if (elgg_trigger_plugin_hook('header:custom_method', 'upload_users', $hook_params, false)) {
						continue;
					}

					$access_id = $this->getHeaderAccess($header);
					$value_type = $this->getHeaderValueType($header);

					switch ($value_type) {

						default :
						case 'text' :
							// keep the value
							break;

						case 'tags' :
							$metadata_value = string_to_tag_array($metadata_value);
							break;

						case 'timestamp' :
							$metadata_value = strtotime($metadata_value);
							break;
					}

					$md_report = array();

					if (is_array($metadata_value)) {
						foreach ($metadata_value as $value) {
							$value = trim($value);
							if (create_metadata($user->guid, $metadata_name, trim($value), '', $user->guid, $access_id, true)) {
								$md_report[] = $value;
							}
						}
					} else {
						if (create_metadata($user->guid, $metadata_name, $metadata_value, '', $user->guid, $access_id)) {
							$md_report[] = $metadata_value;
						}
					}

					$metadata_value = implode(',', $md_report);

					elgg_log("Upload users: creating $metadata_name with value $metadata_value (as $value_type) and access_id $access_id for user $user->guid");
					$record[$metadata_name] = $metadata_value;

					break;
			}
		}

		return $record;
	}

	/**
	 * Reverse CSV header lookup
	 *
	 * @param string $metadata_name
	 * @return string header name
	 */
	function getHeaderForMetadataName($metadata_name) {
		if ($this->mapped_headers) {
			foreach ($this->mapped_headers as $mapped_header => $mapping) {
				if ($mapping == $metadata_name || $mapping['metadata_name'] == $metadata_name) {
					return $mapped_header;
				}
			}
		}
		return $metadata_name;
	}

	/**
	 * Get header access id from mapping
	 *
	 * @param string $header
	 * @return int Access id
	 */
	function getHeaderAccess($header) {

		$access_id = $this->mapped_headers[$header]['access_id'];
		if (is_null($access_id)) {
			$access_id = ACCESS_PRIVATE;
		}

		return $access_id;
	}

	/**
	 * Get header value type
	 *
	 * @param string $header
	 * @return boolean
	 */
	function getHeaderValueType($header) {

		$value_type = $this->mapped_headers[$header]['value_type'];
		return ($value_type) ? $value_type : 'text';
	}

	/**
	 * Get username from mapping
	 *
	 * @param array $record
	 * @return string
	 */
	function getUsername($record) {

		$required_fields = $this->mapped_required_fields;
		$components = $required_fields['username'];

		if (!$required_fields || !is_array($components)) {
			return $record['username'];
		}

		$value = array();
		foreach ($components as $header) {
			$value[] = strtolower(trim($record[$header]));
		}

		$value = implode('.', $value);

		if ($this->fix_usernames) {
			$value = iconv('UTF-8', 'ASCII//TRANSLIT', $value);
			$blacklist = '/[\x{0080}-\x{009f}\x{00a0}\x{2000}-\x{200f}\x{2028}-\x{202f}\x{3000}\x{e000}-\x{f8ff}]/u';
			$blacklist2 = array(' ', '\'', '/', '\\', '"', '*', '&', '?', '#', '%', '^', '(', ')', '{', '}', '[', ']', '~', '?', '<', '>', ';', '|', '¬', '`', '@', '-', '+', '=');
			$value = preg_replace($blacklist, '', $value);
			$value = str_replace($blacklist2, '.', $value);
		}

		return $value;
	}

	/**
	 * Get name from mapping
	 *
	 * @param array $record
	 * @return string
	 */
	function getName($record) {

		$required_fields = $this->mapped_required_fields;
		$components = $required_fields['name'];

		if (!$required_fields || !is_array($components)) {
			return $record['name'];
		}

		$value = array();
		foreach ($components as $header) {
			$value[] = trim($record[$header]);
		}

		if (count($value) > 1) {
			$value = implode(' ', $value);
			$value = ucwords(strtolower($value));
		} else {
			$value = implode(' ', $value);
		}
		return $value;
	}

	/**
	 * Get email from mapping
	 *
	 * @param array $record
	 * @return string
	 */
	function getEmail($record) {

		$required_fields = $this->mapped_required_fields;
		$component = $required_fields['email'];

		if (!$required_fields || !$component) {
			return $record['email'];
		}
		if (is_array($component)) {
			$component = $component[0];
		}

		return trim($record[$component]);
	}

	/**
	 * Get password from mapping
	 *
	 * @param array $record
	 * @return string
	 */
	function getPassword($record) {

		$required_fields = $this->mapped_required_fields;
		$component = $required_fields['password'];

		if (!$required_fields || !is_array($component)) {
			return $record['password'];
		}
		if (is_array($component)) {
			$component = $component[0];
		}

		$value = trim($record[$component]);

		if ($value && $this->fix_passwords) {
			$minlength = elgg_get_config('min_password_length');
			if (strlen($value) < $minlength) {
				$value = '';
			}
		}

		return $value;
	}

}

