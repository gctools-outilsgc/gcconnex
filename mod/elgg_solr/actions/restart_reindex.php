<?php

$logtime = get_input('logtime');

if (!$logtime) {
	forward(REFERER);
}

$filename = elgg_get_config('dataroot') . 'elgg_solr/' . $logtime . '.txt';
$line = elgg_solr_get_log_line($filename);

if (!$line) {
	forward(REFERER);
}

elgg_register_event_handler('shutdown', 'system', 'elgg_solr_reindex');

$querycache = json_decode($line);


elgg_set_plugin_setting('reindex_running', 0, 'elgg_solr');
elgg_set_plugin_setting('stop_reindex', 0, 'elgg_solr');

elgg_register_event_handler('shutdown', 'system', 'elgg_solr_reindex');

elgg_set_config('elgg_solr_reindex_options', (array) $querycache->cacheoptions->types);

$time = array(
	'starttime' => $querycache->cacheoptions->starttime,
	'endtime' => $querycache->cacheoptions->endtime
);

elgg_set_config('elgg_solr_time_options', $time);
elgg_set_config('elgg_solr_restart_logtime', $logtime);
elgg_set_config('elgg_solr_restart_time', $querycache->restart_time);

system_message('Reindex has been restarted');
forward(REFERER);