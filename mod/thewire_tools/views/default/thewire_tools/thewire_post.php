<?php

if (elgg_is_logged_in() && (elgg_get_plugin_setting("extend_widgets", "thewire_tools") != "no")) {
	echo elgg_view_form("thewire/add");
}