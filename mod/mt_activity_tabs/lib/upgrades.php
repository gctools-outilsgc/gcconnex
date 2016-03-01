<?php

namespace AU\ActivityTabs;

/**
 * Initial upgrade to set plugin versioning
 * @return boolean
 */
function upgrade20151017() {
	$version = (int) elgg_get_plugin_setting('version', PLUGIN_ID);
	if ($version >= 20151017) { 
		return true;
	}
	
	elgg_set_plugin_setting('version', 20151017, PLUGIN);
}
