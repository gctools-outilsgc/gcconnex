<?php

namespace Beck24\MemberSelfDelete;

// set default values if nothing is set
$feedback = elgg_get_plugin_setting('feedback', PLUGIN_ID);
if (empty($feedback)) {
	elgg_set_plugin_setting('feedback', 'yes', PLUGIN_ID);
}

$method = elgg_get_plugin_setting('method', PLUGIN_ID);
if (empty($method)) {
	elgg_set_plugin_setting('method', 'delete', PLUGIN_ID);
}