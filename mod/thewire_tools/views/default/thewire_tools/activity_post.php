<?php
/**
 * Prepend a form before the river
 */

if (elgg_is_logged_in() && (elgg_get_plugin_setting("extend_activity", "thewire_tools") === "yes")) {
	// make sure we get the correct access options
	elgg_push_context("thewire");
	
	echo elgg_view_form("thewire/add");
	
	// restore context
	elgg_pop_context();
}