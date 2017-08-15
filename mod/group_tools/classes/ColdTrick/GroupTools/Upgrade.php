<?php

namespace ColdTrick\GroupTools;

class Upgrade {
	
	/**
	 * Set the correct class for the GroupMail subtype
	 *
	 * @param string $event  the name of the event
	 * @param string $type   the type of the event
	 * @param mixed  $object supplied object
	 *
	 * @return void
	 */
	public static function setGroupMailClassHandler($event, $type, $object) {
		
		if (get_subtype_id('object', \GroupMail::SUBTYPE)) {
			update_subtype('object', \GroupMail::SUBTYPE, 'GroupMail');
		} else {
			add_subtype('object', \GroupMail::SUBTYPE, 'GroupMail');
		}
	}
	
	/**
	 * Migrate the group listing settings to the new format
	 *
	 * @param string $event  the name of the event
	 * @param string $type   the type of the event
	 * @param mixed  $object supplied object
	 *
	 * @return void
	 */
	public static function migrateListingSettings($event, $type, $object) {
		
		// check if an old tab is enabled, if so enable 'all'
		$settings = [
			'newest',
			'popular',
			'alpha',
		];
		foreach($settings as $name) {
			$setting = elgg_get_plugin_setting("group_listing_{$name}_available", 'group_tools');
			if (is_null($setting)) {
				// setting doesn't exist
				continue;
			}
			
			// enable all
			elgg_set_plugin_setting('group_listing_all_available', '1', 'group_tools');
			// remove old setting
			elgg_unset_plugin_setting("group_listing_{$name}_available", 'group_tools');
		}
		
		// check default tab
		$default_tab = elgg_get_plugin_setting('group_listing', 'group_tools');
		if (in_array($default_tab, $settings)) {
			// set default to all
			elgg_set_plugin_setting('group_listing', 'all', 'group_tools');
			// set default sorting for all tab
			elgg_set_plugin_setting('group_listing_all_sorting', $default_tab, 'group_tools');
		}
	}
}
