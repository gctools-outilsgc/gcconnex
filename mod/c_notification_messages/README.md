Notification Messages
=====================
This module modifies the messages that gets sent out to users to their inboxes.
This is a custom module made specifically for GCconnex (Elgg instance for the Government of Canada to allow interdepartmental collaboration). The source code for the instance can be found on GitHub (https://github.com/tbs-sct/gcconnex).


Contents
--------
1. Module Dependencies
2. Installation Guide
3. Future Development
4. Use Cases


1. Module Dependencies
----------------------
- this module overrides core functions /and/ core modules
- requires the module html_email_handler (as it uses the template)
- list of modules that may be overwritten:
	1. likes
	2. comments (core)
	3. groups
	4. tidypics
	5. group_tools
	6. bookmarks
	7. event_calendar
	8. pages
	9. tasks
	10. thewire
	11. user (core)
	12. requestpassword (core)
	13. invitefriends
	14. notifications (core)
	15. html_email_handler
	16. blog
	17. file
	18. messages
	19. uservalidationbyemail
	20. friend_request
	21. thewire_tools
	22. messageboard
	23. upload_users 


2. Installation Guide
----------------------
- this module should be placed at the very bottom of the plugin list in administrative panel due to dependencies of various modules
- IF YOU HAVE usesr_upload MODULE INSTALLED, you must make the following changes:
	+ /mod/upload_users/classes/UploadUsers.php:
	

	/* Create a new user or update an existing user from record
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
					$message = elgg_echo('upload_users:email:message', array(
						$record['name'], 
						elgg_get_config('sitename'), 
						$record['username'], 
						$record['password'], 
						elgg_get_site_url(),
						
						$record['name'], 
						elgg_get_config('sitename'), 
						$record['username'], 
						$record['password'], 
						elgg_get_site_url(),
					));
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

	
3. Future Development
---------------------
- no current future development, only patching of issues only and missing modules


4. Use Cases
-------------
See excel spreadsheet for all notification messages and the modules that contains these messages.

1. new comment
2. like an entity
3. new blog
4. new bookmark
5. new album
6. new photo upload
7. new event
8. new discussion
9. new discussion reply
10. user joined a group
11. invite existing users to group
12. invite non existing users to group
13. mail group members
14. new file upload
15. new tasks
16. new pages
17. add friend
18. new wire post (colleague notification)
19. new wire reply to post
20. in site message
21. validation email
22. password reset
23. admin create users
24. request friend
25. upload users (mass upload via csv)
26. new message on message board
27. tagging users on photo/image
28. request to join closed group
29. group administrative adds user to their closed group
30. user gets accepted to closed group request