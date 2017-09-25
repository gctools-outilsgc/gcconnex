<?php

$batch_size = elgg_get_plugin_setting('reindex_batch_size', 'elgg_solr');

if (empty($batch_size)) {
	elgg_set_plugin_setting('reindex_batch_size', 1000, 'elgg_solr');
}

$extract = elgg_get_plugin_setting('extract_handler', 'elgg_solr');

if (empty($extract)) {
	elgg_set_plugin_setting('extract_handler', 'yes', 'elgg_solr');
}

$title_boost = elgg_get_plugin_setting('title_boost', 'elgg_solr');

if (empty($title_boost) && $title_boost !== '0') {
	elgg_set_plugin_setting('title_boost', '1.5', 'elgg_solr');
}

$description_boost = elgg_get_plugin_setting('description_boost', 'elgg_solr');

if (empty($description_boost) && $description_boost !== '0') {
	elgg_set_plugin_setting('description_boost', '1', 'elgg_solr');
}

$use_time_boost = elgg_get_plugin_setting('use_time_boost', 'elgg_solr');

if (empty($use_time_boost)) {
	elgg_set_plugin_setting('use_time_boost', 'no', 'elgg_solr');
}

$time_boost_num = elgg_get_plugin_setting('time_boost_num', 'elgg_solr');

if (empty($time_boost_num)) {
	elgg_set_plugin_setting('time_boost_num', '1', 'elgg_solr');
}

$time_boost_interval = elgg_get_plugin_setting('time_boost_interval', 'elgg_solr');

if (empty($time_boost_interval)) {
	elgg_set_plugin_setting('time_boost_interval', 'year', 'elgg_solr');
}

$time_boost = elgg_get_plugin_setting('time_boost', 'elgg_solr');

if (empty($time_boost) && $time_boost !== '0') {
	elgg_set_plugin_setting('time_boost', '1.5', 'elgg_solr');
}

$hl_prefix = elgg_get_plugin_setting('hl_prefix', 'elgg_solr');

if (empty($hl_prefix)) {
	elgg_set_plugin_setting('hl_prefix', '<strong class="search-highlight search-highlight-color1">', 'elgg_solr');
}

$hl_suffix = elgg_get_plugin_setting('hl_suffix', 'elgg_solr');

if (empty($hl_suffix)) {
	elgg_set_plugin_setting('hl_suffix', '</strong>', 'elgg_solr');
}