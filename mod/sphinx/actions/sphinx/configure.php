<?php
$sphinx_path = elgg_get_data_path() . 'sphinx';

mkdir("$sphinx_path/indexes", '0700', true);
mkdir("$sphinx_path/log", '0700');

elgg_unregister_plugin_hook_handler('view', 'all', 'developers_wrap_views');
sphinx_write_conf();
elgg_register_plugin_hook_handler('view', 'all', 'developers_wrap_views');

system_message(elgg_echo('sphinx:configure:success'));
forward(REFERER);