linkedin_profile_importer
===============

#### Setting up LinkedIn ####
* Go to https://www.linkedin.com/secure/developer
* Create new application
	> In OAuth User Agreement, update the default scope to your needs. If you are unsure, check r_basicprofile, r_emailaddress, rw_nus and r_network
	> You do not need to fill out redirect URLs
* Copy the API Key into the Public Key field in the plugin settings
* Copy the Secret Key into the Private Key field in the plugin settings

#### Persistent hybriauth sessions

If you are using the plugin for interactions with the provider APIs, you may
want to implement persistent sessions, so that users are not prompted to
authorize their accounts every time they want to post or import data.

```php

	elgg_register_event_handler('init', 'system', '_persist_hybridauth_session', 1);
	elgg_register_plugin_hook_handler('hybridauth:authenticate', 'all', '_store_hybridauth_session');
	elgg_register_plugin_hook_handler('hybridauth:deauthenticate', 'all', '_store_hybridauth_session');

	/**
	 * Store hybridauth session information, so that it can be restored when user logs in
	 *
	 * @param string $hook
	 * @param string $type
	 * @param mixed $return
	 * @param array $params
	 * @return mixed
	 */
	function simplur_register_store_hybridauth_session($hook, $type, $return, $params) {

		$entity = elgg_extract('entity', $params);

		try {

			$ha = new ElggHybridAuth();
			$hybridauth_session_data = $ha->getSessionData();
			elgg_set_plugin_user_setting('hybridauth_session_data', $hybridauth_session_data, $entity->guid, 'linkedin_profile_importer');
			elgg_set_plugin_user_setting('hybridauth_session_id', session_id(), $entity->guid, 'linkedin_profile_importer');
		} catch (Exception $e) {
			error_log($e->getMessage());
			// Something is wrong, but whatever
		}

		return $return;
	}

	/**
	 * Restore hybrdiauth session
	 * @return boolean
	 */
	function simplur_register_persist_hybridauth_session() {

		$user = elgg_get_logged_in_user_entity();
		if (!$user) {
			return true;
		}

		if (elgg_in_context('hybridauth')) {
			return true;
		}
		try {

			$session_id = elgg_get_plugin_user_setting('hybridauth_session_id', $user->guid, 'linkedin_profile_importer');
			if ($session_id && session_id() !== $session_id) {
				error_log('Restoring hybridauth session');
				$stored_session_data = elgg_get_plugin_user_setting('hybridauth_session_data', $user->guid, 'linkedin_profile_importer');
				$ha = new ElggHybridAuth();
				$ha->restoreSessionData($stored_session_data);
				elgg_set_plugin_user_setting('hybridauth_session_id', session_id(), $user->guid, 'linkedin_profile_importer');
			}
		} catch (Exception $e) {
			error_log($e->getMessage());
			// Something is wrong, but whatever
		}

		return true;
	}
```