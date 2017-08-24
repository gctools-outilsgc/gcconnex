<?php

plugin_loader_reorder();
plugin_loader_set_status();

system_message(elgg_echo('plugin_loader:imported'));
forward(elgg_get_site_url() . '/admin/plugins');
