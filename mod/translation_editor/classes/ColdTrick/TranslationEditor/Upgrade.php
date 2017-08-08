<?php

namespace ColdTrick\TranslationEditor;

class Upgrade {
	
	/**
	 * Cleanup all custom translations from keys not present in the original plugin
	 *
	 * @param string $event  the name of the event
	 * @param string $type   the type of the event
	 * @param mixed  $object supplied params
	 *
	 * @return void
	 */
	public static function cleanupCustomTranslations($event, $type, $object) {
		
		$base_dir = elgg_get_data_path() . 'translation_editor' . DIRECTORY_SEPARATOR;
		if (!is_dir($base_dir)) {
			// no custom translations
			return;
		}
		
		$dh = opendir($base_dir);
		if (empty($dh)) {
			// something went wrong
			return;
		}
		
		while (($language = readdir($dh)) !== false) {
			if (in_array($language, ['.', '..'])) {
				continue;
			}
			
			$language_dir = $base_dir . $language . DIRECTORY_SEPARATOR;
			if (!is_dir($language_dir)) {
				continue;
			}
			
			$ldh = opendir($language_dir);
			if (empty($ldh)) {
				continue;
			}
			
			while (($plugin_file = readdir($ldh)) !== false) {
				$file_path = $language_dir . $plugin_file;
				if (!is_file($file_path)) {
					continue;
				}
				
				$plugin_id = basename($file_path, '.json');
				
				self::cleanupPlugin($language, $plugin_id);
			}
			
			// merge new translations for this language
			translation_editor_merge_translations($language, true);
			
			// close $ldh
			closedir($ldh);
		}
		
		// close $dh
		closedir($dh);
	}
	
	/**
	 * Cleanup the custom translations for one plugin
	 *
	 * @param string $language  the language to cleanup for
	 * @param string $plugin_id the plugin to cleanup
	 *
	 * @return bool
	 */
	protected static function cleanupPlugin($language, $plugin_id) {
		
		if (empty($language) || empty($plugin_id)) {
			return false;
		}
		
		$translation = translation_editor_get_plugin($language, $plugin_id);
		if ($translation === false) {
			return false;
		}
		
		$custom = elgg_extract('custom', $translation);
		if (empty($custom)) {
			// no custom translation, how did you get here??
			return true;
		}
		
		$english = elgg_extract('en', $translation);
		$clean_custom = array_intersect_key($custom, $english);
		$removed_custom = array_diff_key($custom, $clean_custom);
		
		// report cleaned-up translations
		if (empty($removed_custom)) {
			// nothing removed
			return true;
		} else {
			self::writeCleanupTranslations($language, $plugin_id, $removed_custom);
		}
		
		// write new custom translation
		if (empty($clean_custom)) {
			// no more custom translations
			translation_editor_delete_translation($language, $plugin_id);
		} else {
			// write new custom translation
			translation_editor_write_translation($language, $plugin_id, $clean_custom);
		}
		
		return true;
	}
	
	/**
	 * Write the removed custom translations to a file, so admins can act on it
	 *
	 * @param string $language     the language being handled
	 * @param string $plugin_id    the plugin ID
	 * @param array  $translations the removed translations
	 *
	 * @return void
	 */
	protected static function writeCleanupTranslations($language, $plugin_id, $translations) {
		
		if (empty($language) || empty($translations) || !is_array($translations)) {
			return;
		}
		
		$base_dir = elgg_get_data_path() . 'translation_editor' . DIRECTORY_SEPARATOR;
		$cleanup_file = $base_dir . $language . DIRECTORY_SEPARATOR . 'translation_editor_cleanup.json';
		
		$existing = [];
		if (file_exists($cleanup_file)) {
			// read previous keys
			$contents = file_get_contents($cleanup_file);
			$existing = json_decode($contents, true);
		}
		
		$new_translation = [$plugin_id => $translations];
		
		$new_content = array_merge($existing, $new_translation);
		// write new content
		file_put_contents($cleanup_file, json_encode($new_content));
	}
}
