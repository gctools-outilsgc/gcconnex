<?php
/**
 * All helper function for this plugin are bundled here
 */

/**
 * Returns array of all available plugins and their individual language keys
 *
 * @param string $current_language which language to use
 *
 * @return false|array
 */
function translation_editor_get_plugins($current_language) {
	
	if (empty($current_language)) {
		return false;
	}
	
	global $_ELGG;
	
	translation_editor_reload_all_translations();
	translation_editor_load_translations($current_language);
	
	$result = [];
	$core = [];
	$custom_keys = [];
	$plugins_result = [];
	
	$backup_full = $_ELGG->translations;
	$plugins = elgg_get_plugins();
	
	// Core translation
	$_ELGG->translations = [];
	$plugin_language = dirname(elgg_get_engine_path()) . DIRECTORY_SEPARATOR . 'languages' . DIRECTORY_SEPARATOR . 'en.php';
	
	if (file_exists($plugin_language)) {
		$core_language_array = include($plugin_language);
		if (is_array($core_language_array)) {
			add_translation('en', $core_language_array);
		}
		
		unset($_ELGG->translations['en']['']);
		
		$plugin_keys = $_ELGG->translations['en'];
		
		$key_count = count($plugin_keys);
		
		if (array_key_exists($current_language, $backup_full)) {
			$exists_count = $key_count - count(array_diff_key($plugin_keys, $backup_full[$current_language]));
		} else {
			$exists_count = 0;
		}
		
		$custom_content = translation_editor_read_translation($current_language, 'core');
		if (!empty($custom_content)) {
			$custom_count = count($custom_content);
		} else {
			$custom_count = 0;
		}
		
		$core['core']['total'] = $key_count;
		$core['core']['exists'] = $exists_count;
		$core['core']['custom'] = $custom_count;
	}
	
	// Custom Keys
	$_ELGG->translations = [];
	$custom_keys_original = elgg_get_data_path() . 'translation_editor' . DIRECTORY_SEPARATOR . 'custom_keys' . DIRECTORY_SEPARATOR . 'en.php';
	
	if (file_exists($custom_keys_original)) {
		$custom_language_array = include($custom_keys_original);
		if (is_array($custom_language_array)) {
			add_translation('en', $custom_language_array);
		}
		
		unset($_ELGG->translations['en']['']);
		
		$plugin_keys = $_ELGG->translations['en'];
		
		$key_count = count($plugin_keys);
		
		if (array_key_exists($current_language, $backup_full)) {
			$exists_count = $key_count - count(array_diff_key($plugin_keys, $backup_full[$current_language]));
		} else {
			$exists_count = 0;
		}
		
		$custom_content = translation_editor_read_translation($current_language, 'custom_keys');
		if (!empty($custom_content)) {
			$custom_count = count($custom_content);
		} else {
			$custom_count = 0;
		}
		
		$custom_keys['custom_keys']['total'] = $key_count;
		$custom_keys['custom_keys']['exists'] = $exists_count;
		$custom_keys['custom_keys']['custom'] = $custom_count;
	} else {
		$custom_keys['custom_keys']['total'] = 0;
		$custom_keys['custom_keys']['exists'] = 0;
		$custom_keys['custom_keys']['custom'] = 0;
	}
	
	// Plugin translations
	foreach ($plugins as $plugin) {
		
		$title = $plugin->title;
		
		$_ELGG->translations = [];
		$plugin_language = $plugin->getPath() . DIRECTORY_SEPARATOR . 'languages' . DIRECTORY_SEPARATOR . 'en.php';
		
		if (file_exists($plugin_language)) {
			$plugin_language_array = include($plugin_language);
			if (is_array($plugin_language_array)) {
				add_translation('en', $plugin_language_array);
			}
			
			unset($_ELGG->translations['en']['']);
			
			$plugin_keys = $_ELGG->translations['en'];
			
			$key_count = count($plugin_keys);
			
			if (array_key_exists($current_language, $backup_full)) {
				$exists_count = $key_count - count(array_diff_key($plugin_keys, $backup_full[$current_language]));
			} else {
				$exists_count = 0;
			}
			
			$custom_content = translation_editor_read_translation($current_language, $title);
			if (!empty($custom_content)) {
				$custom_count = count($custom_content);
			} else {
				$custom_count = 0;
			}
			
			$plugins_result[$title]['total'] = $key_count;
			$plugins_result[$title]['exists'] = $exists_count;
			$plugins_result[$title]['custom'] = $custom_count;
		}
	}
	
	ksort($plugins_result);
	
	$result = $core + $custom_keys + $plugins_result;
	
	$_ELGG->translations = $backup_full;

	return $result;
}

/**
 * Returns translation data for a specific plugin
 *
 * @param string $current_language which language to return
 * @param string $plugin           for which plugin do you want the translations
 *
 * @return fasle|array
 */
function translation_editor_get_plugin($current_language, $plugin) {
	
	if (empty($current_language) || empty($plugin)) {
		return false;
	}

	global $_ELGG;
	
	if ($plugin == 'core') {
		// Core translation
		$plugin_language = dirname(elgg_get_engine_path()) . DIRECTORY_SEPARATOR . 'languages' . DIRECTORY_SEPARATOR . 'en.php';
	} elseif ($plugin == 'custom_keys') {
		$plugin_language = elgg_get_data_path() . 'translation_editor' . DIRECTORY_SEPARATOR . 'custom_keys' . DIRECTORY_SEPARATOR . 'en.php';
	} else {
		// plugin translations
		$plugin_object = elgg_get_plugin_from_id($plugin);
		if (!($plugin_object instanceof ElggPlugin)) {
			return false;
		}
		$plugin_language = $plugin_object->getPath() . 'languages' . DIRECTORY_SEPARATOR . 'en.php';
	}
	
	translation_editor_reload_all_translations();
	translation_editor_load_translations($current_language);
	
	$result = [
		'total' => 0
	];
	
	$backup_full = $_ELGG->translations;
	$_ELGG->translations = [];
	
	// Fetch translations
	if (file_exists($plugin_language)) {
		$plugin_language_array = include($plugin_language);
		if (is_array($plugin_language_array)) {
			add_translation('en', $plugin_language_array);
		}
		
		unset($_ELGG->translations['en']['']);
		
		$plugin_keys = $_ELGG->translations['en'];
		
		$key_count = count($plugin_keys);
		
		if (array_key_exists($current_language, $backup_full)) {
			$exists_count = $key_count - count(array_diff_key($plugin_keys, $backup_full[$current_language]));
		} else {
			$exists_count = 0;
		}
		
		$custom_content = translation_editor_read_translation($current_language, $plugin);
		if (!empty($custom_content)) {
			$custom = $custom_content;
		} else {
			$custom = [];
		}
		
		$result['total'] = $key_count;
		$result['exists'] = $exists_count;
		$result['en'] = $plugin_keys;
		$result['current_language'] = array_intersect_key($backup_full[$current_language], $plugin_keys);
		$result['custom'] = $custom;
	}
	
	$_ELGG->translations = $backup_full;
	
	return $result;
}

/**
 * Compare the provided translations to filter out the custom translations
 *
 * @param string $current_language the language to check
 * @param array  $translated       the provided translations
 *
 * @return false|array
 */
function translation_editor_compare_translations($current_language, $translated) {
	
	if (empty($current_language) || empty($translated)) {
		return false;
	}
	
	global $_ELGG;
	
	$result = [];
	
	$backup_full = $_ELGG->translations;
	
	$_ELGG->translations = [];
	translation_editor_reload_all_translations();
	
	foreach ($translated as $key => $value) {
		$original = translation_editor_clean_line_breaks(html_entity_decode($_ELGG->translations[$current_language][$key], ENT_NOQUOTES, 'UTF-8'));
		$new = translation_editor_clean_line_breaks(html_entity_decode($value, ENT_NOQUOTES, 'UTF-8'));
		
		// if original string contains beginning/trailing spaces (eg ' in the group '),
		// don't trim translated
		$trim_needed = (strlen($original) === strlen(trim($original)));
		if ($trim_needed) {
			$new = trim($new);
		}
		
		if (($original != $new) && strlen($new) > 0) {
			$result[$key] = $new;
		}
	}
	
	$_ELGG->translations = $backup_full;
	
	return $result;
}

/**
 * Replace different line endings with the ones used by the current OS
 *
 * @param string $string the text to replace the line endings in
 *
 * @return string
 */
function translation_editor_clean_line_breaks($string) {
	return preg_replace("/(\r\n)|(\n|\r)/", PHP_EOL, $string);
}

/**
 * Write the custom translation for a plugin to disk
 *
 * @param string $current_language the language for the translations
 * @param string $plugin           the translated plugin
 * @param array  $translation      the translations
 *
 * @return false|int
 */
function translation_editor_write_translation($current_language, $plugin, $translations) {
	
	$translation = new \ColdTrick\TranslationEditor\PluginTranslation($plugin, $current_language);
	return $translation->saveTranslations($translations);
}

/**
 * Read the custom translations from disk
 *
 * @param string $current_language the language to fetch
 * @param string $plugin           the plugin to fetch
 *
 * @return false|array
 */
function translation_editor_read_translation($current_language, $plugin) {
	$translation = new \ColdTrick\TranslationEditor\PluginTranslation($plugin, $current_language);
	return $translation->readTranslations();
}

/**
 * Load all the custom translations into the running translations
 *
 * @param string $current_language the language to load (defaults to the language of the current user)
 *
 * @return void
 */
function translation_editor_load_translations($current_language = "") {
	$site = elgg_get_site_entity();
	
	if (empty($current_language)) {
		$current_language = get_current_language();
	}
	
	// check if update is needed
	$main_ts = (int) datalist_get("te_last_update_{$current_language}");
	$site_ts = (int) get_private_setting($site->getGUID(), "te_last_update_{$current_language}");
	
	if (!empty($main_ts)) {
		if (empty($site_ts) || ($main_ts > $site_ts)) {
			if (translation_editor_merge_translations($current_language)) {
				set_private_setting($site->getGUID(), "te_last_update_{$current_language}", time());
			}
		}
	} else {
		translation_editor_merge_translations($current_language, true);
	}
	
	// load translations
	$translations = translation_editor_read_translation($current_language, "translation_editor_merged_{$site->getGUID()}");
	if (!empty($translations)) {
		add_translation($current_language, $translations);
	}
}

/**
 * Load all the custom languages added by this plugin
 *
 * @return void
 */
function translation_editor_load_custom_languages() {
	$custom_languages = elgg_get_plugin_setting('custom_languages', 'translation_editor');
	if (empty($custom_languages)) {
		return;
	}
	
	$custom_languages = explode(',', $custom_languages);
	
	foreach ($custom_languages as $lang) {
		add_translation($lang, ['' => '']);
	}
}

/**
 * Custom implementation of reload_all_translations() to be able to reset the translations
 *
 * @see reload_all_translations()
 *
 * @return void
 */
function translation_editor_reload_all_translations() {
	global $_ELGG;
	
	static $run_once;
	
	if (isset($run_once)) {
		$_ELGG->translations = $run_once;
	} else {
		
		$_ELGG->translations = array();
		
		if ($_ELGG->i18n_loaded_from_cache) {
			// make sure all plugins have registered their paths
			$plugins = elgg_get_plugins();
			if (!empty($plugins)) {
				foreach ($plugins as $plugin) {
					$plugin->start(ELGG_PLUGIN_REGISTER_LANGUAGES);
				}
			}
		}
		
		// include all languages in the configured paths
		foreach ($_ELGG->language_paths as $path => $dummy) {
			$handle = opendir($path);
			if (!empty($handle)) {
				// proccess all files
				while (($language = readdir($handle)) !== false) {
					// do we have a file (not a directory)
					if (is_file($path . $language)) {
						$result = include($path . $language);
						if (is_array($result)) {
							add_translation(basename($language, '.php'), $result);
						}
					}
				}
				
				closedir($handle);
			}
		}
		
		$run_once = $_ELGG->translations;
	}
}

/**
 * Remove the custom translations for a plugin
 *
 * @param string $current_language the language to remove
 * @param string $plugin           the plugin to remove
 *
 * @return bool
 */
function translation_editor_delete_translation($current_language, $plugin) {
	$translation = new \ColdTrick\TranslationEditor\PluginTranslation($plugin, $current_language);
	return $translation->removeTranslations();
}

/**
 * Custom version of get_language_completeness() to give better results
 *
 * @see get_language_completeness()
 *
 * @param string $current_language the language to check
 *
 * @return float|false
 */
function translation_editor_get_language_completeness($current_language) {
	
	if (empty($current_language) || ($current_language == 'en')) {
		return false;
	}
	
	$plugins = translation_editor_get_plugins($current_language);
	if (empty($plugins)) {
		return (float) 0;
	}
		
	$english_count = 0;
	$current_count = 0;
	
	foreach ($plugins as $plugin) {
		$english_count += $plugin['total'];
		$current_count += $plugin['exists'];
	}
	
	return round(($current_count / $english_count) * 100, 2);
}

/**
 * Check if the provided user is a translation editor
 *
 * @param int $user_guid the user to check (defaults to current user)
 *
 * @return bool
 */
function translation_editor_is_translation_editor($user_guid = 0) {
	static $editors_cache;
	
	if (empty($user_guid)) {
		$user_guid = elgg_get_logged_in_user_guid();
	}
	
	if (empty($user_guid)) {
		return false;
	}
	
	if (elgg_is_admin_user($user_guid)) {
		return true;
	}
		
	// preload all editors
	if (!isset($editors_cache)) {
		$editors_cache = array();
		
		$translation_editor_id = elgg_get_metastring_id('translation_editor');
		$true_id = elgg_get_metastring_id(true);
		
		$options = array(
			'type' => 'user',
			'limit' => false,
			'joins' => array('JOIN ' . elgg_get_config('dbprefix') . 'metadata md ON e.guid = md.entity_guid'),
			'wheres' => array("(md.name_id = {$translation_editor_id} AND md.value_id = {$true_id})"),
			'callback' => function ($row) {
				return (int) $row->guid;
			},
		);
		
		$guids = elgg_get_entities($options);
		if (!empty($guids)) {
			$editors_cache = $guids;
		}
	}

	// is the user an editor or an admin
	return in_array($user_guid, $editors_cache);
}

/**
 * Remove disabled languages from the available languages
 *
 * @return void
 */
function translation_editor_unregister_translations() {
	
	$disabled_languages = translation_editor_get_disabled_languages();
	if (empty($disabled_languages)) {
		return;
	}
	
	global $_ELGG;
	
	foreach ($_ELGG->translations as $key => $dummy) {
		if (!in_array($key, $disabled_languages)) {
			continue;
		}
		
		unset($_ELGG->translations[$key]);
	}
}

/**
 * Search for a translation
 *
 * @param string $query    the text to search for
 * @param string $language the language to search in (defaults to English)
 *
 * @return array|bool
 */
function translation_editor_search_translation($query, $language = 'en') {
	
	$plugins = translation_editor_get_plugins($language);
	if (empty($plugins)) {
		return false;
	}
	
	$found = [];
	foreach ($plugins as $plugin => $data) {
		$translations = translation_editor_get_plugin($language, $plugin);
		if (empty($translations) || empty(elgg_extract('total', $translations))) {
			continue;
		}

		foreach ($translations['en'] as $key => $value) {
			if (stristr($key, $query) || stristr($value, $query) || (array_key_exists($key, $translations['current_language']) && stristr($translations['current_language'][$key], $query))) {
				if (!array_key_exists($plugin, $found)) {
					$found[$plugin] = ['en' => [], 'current_language' => []];
				}
				
				$found[$plugin]['en'][$key] = $value;
				if (array_key_exists($key, $translations['current_language'])) {
					$found[$plugin]['current_language'][$key] = $translations['current_language'][$key];
				}
			}
		}
	}
	
	if (empty($found)) {
		return false;
	}

	return $found;
}

/**
 * Merge all custom translations into a single file for performance
 *
 * @param string $language the language to merge
 * @param bool   $update   force and update to other sites
 *
 * @return bool
 */
function translation_editor_merge_translations($language = "", $update = false) {
	$result = false;
	$site = elgg_get_site_entity();
	
	if (empty($language)) {
		$language = get_current_language();
	}
	
	if (!empty($language)) {
		$translations = array();
		
		// get core translations
		$core = translation_editor_read_translation($language, 'core');
		if (!empty($core)) {
			$translations = $core;
		}
		
		// get the customo keys
		$custom_keys = translation_editor_read_translation($language, 'custom_keys');
		if (!empty($custom_keys)) {
			$translations += $custom_keys;
		}
		
		// proccess all plugins
		$plugins = elgg_get_plugins();
		if (!empty($plugins)) {
			foreach ($plugins as $plugin) {
				// add plugin translations
				$plugin_translation = translation_editor_read_translation($language, $plugin->title);
				if (!empty($plugin_translation)) {
					$translations += $plugin_translation;
				}
			}
		}
		
		if (!empty($translations)) {
			// write all to disk
			if (translation_editor_write_translation($language, "translation_editor_merged_{$site->getGUID()}", $translations)) {
				$result = true;
			}
		} else {
			// no custom translations, so remove the cache file
			if (translation_editor_delete_translation($language, "translation_editor_merged_{$site->getGUID()}")) {
				$result = true;
			}
		}
	}
	
	if ($result) {
		// clear system cache
		$cache = elgg_get_system_cache();
		$cache->delete("{$language}.lang");
		
		// let others know this happend
		elgg_trigger_event("language:merge", "translation_editor", $language);
	}
	
	// reset language cache on all sites
	if ($update) {
		$ts = time();
		
		datalist_set("te_last_update_{$language}", $ts);
		set_private_setting($site->getGUID(), "te_last_update_{$language}", $ts);
	}
	
	return $result;
}

/**
 *  parses a string meant for printf and returns an array of found parameters
 *
 *  @param string $string the string to search parameters for
 *  @param bool   $count  return the count of the parameters (default = true)
 *
 *  @return array
 */
function translation_editor_get_string_parameters($string, $count = true) {
	$valid = '/%[-+]?(?:[ 0]|\'.)?a?\d*(?:\.\d*)?[%bcdeEufFgGosxX]/';
	
	$result = [];
	
	if (!empty($string)) {
		if (!$string = preg_replace('/^[^%]*/', '', $string)) {
			// no results
		} elseif (preg_match_all($valid, $string, $matches)) {
			$result = $matches[0];
		}
	}
	
	if ($count) {
		$result = count($result);
	}
	
	return $result;
}

/**
 * Get the disabled languages
 *
 * @return array|bool
 */
function translation_editor_get_disabled_languages() {
	static $result;

	if (isset($result)) {
		return $result;
	}
		
	$result = false;
		
	$disabled_languages = elgg_get_plugin_setting(TRANSLATION_EDITOR_DISABLED_LANGUAGE, 'translation_editor');
	if (!empty($disabled_languages)) {
		$result = string_to_tag_array($disabled_languages);
	}

	return $result;
}

/**
 * Reset the site timestamp that tracks the merged translation status.
 *
 * This will recreate the translation editor cache
 *
 * @param int $site_guid which site to invalidate (defaults to current site)
 *
 * @return void
 */
function translation_editor_invalidate_site_cache($site_guid = 0) {
	
	$site_guid = sanitize_int($site_guid, false);
	
	// make sure we have all translations
	translation_editor_reload_all_translations();
	
	$languages = get_installed_translations();
	if (empty($languages) || !is_array($languages)) {
		return;
	}
	
	$site = elgg_get_site_entity($site_guid);
	if (empty($site)) {
		return;
	}
	
	foreach ($languages as $key => $desc) {
		remove_private_setting($site->getGUID(), "te_last_update_{$key}");
	}
}

/**
 * Protect pages for only translation editor
 *
 * @return void
 */
function translation_editor_gatekeeper() {
	elgg_gatekeeper();
	
	if (translation_editor_is_translation_editor()) {
		return;
	}
	
	register_error(elgg_echo("translation_editor:gatekeeper"));
	forward();
}
