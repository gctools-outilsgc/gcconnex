<?php

namespace ColdTrick\TranslationEditor;

/**
 * Event handler for upgrade, system
 *
 * @package    ColdTrick
 * @subpackage TranslationEditor
 */
class UpgradeHandler {
	
	/**
	 * Invalidate some language caching when upgrading the system
	 *
	 * @param string $event  'upgrade'
	 * @param string $type   'system'
	 * @param null   $object not relavant
	 *
	 * @return void
	 */
	public static function system($event, $type, $object) {
		
		// invalidate site cache
		translation_editor_invalidate_site_cache();
	}
}