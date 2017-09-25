<?php

elgg_set_plugin_setting('reindex_running', 0, 'elgg_solr');

system_message(elgg_echo('elgg_solr:reindex:unlocked'));
forward(REFERER);