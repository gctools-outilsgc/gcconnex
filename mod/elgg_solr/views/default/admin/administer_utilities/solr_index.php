<?php

if (!elgg_solr_has_settings()) {
	register_error(elgg_echo('elgg_solr:missing:settings'));
	forward('admin/plugin_settings/elgg_solr');
}

echo elgg_view('elgg_solr/admin_header');

echo elgg_view('elgg_solr/stats');