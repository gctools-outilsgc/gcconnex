<?php
/**
 * WET 4 Theme plugin
 *
 * @package wet4Theme
 */

elgg_register_event_handler('init','system','machine_translation_init');

function machine_translation_init() {
	//extends discussion reply view.
	elgg_extend_view('discussion/replies','machine_translation/replies', 450);
	
}
	
	