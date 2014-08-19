<?php
/**
 * Prepend a form before the river
 */

if (elgg_is_logged_in() && (elgg_get_plugin_setting("extend_activity", "thewire_tools") === "yes")) {
	echo elgg_view_form("thewire/add");
}