<?php

namespace AU\SubGroups;

function upgrade20150912() {
	$version = (int) elgg_get_plugin_setting('version', PLUGIN_ID);
	if ($version >= 20150912) {
		return true;
	}
	
	elgg_set_plugin_setting('version', 20150912, PLUGIN_ID);
}