<?php

$logtime = get_input('logtime');

if (!$logtime) {
	forward(REFERER);
}

elgg_set_plugin_setting('stop_reindex', $logtime, 'elgg_solr');

system_message(elgg_echo('elgg_solr:admin:stop_reindex'));