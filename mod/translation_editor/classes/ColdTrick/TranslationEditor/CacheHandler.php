<?php

namespace ColdTrick\TranslationEditor;

class CacheHandler {
	
	/**
	 * Listen to the cache flush event to invalidate translation editor cache
	 *
	 * @param string $event  the name of the event
	 * @param string $type   the type of the event
	 * @param mixed  $object supplied param
	 *
	 * @return void
	 */
	public static function resetTranslationCache($event, $type, $object) {
		
		// invalidate site cache
		translation_editor_invalidate_site_cache();
	}
}
