<?php

elgg_default_plugin_order_reorder();
elgg_default_plugin_order_set_status();

system_message(elgg_echo('plugin_loader:imported'));
forward(elgg_get_site_url() . '/admin/plugins');
