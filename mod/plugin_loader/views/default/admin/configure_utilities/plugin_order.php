<?php
elgg_require_js('pluginLoader');
$config_file = elgg_get_config('path')."plugin_config.ini";

echo '<h3>'.elgg_echo('plugin_loader:description').'</h3>';
echo "<br>" . elgg_echo('plugin_loader:config_file_location');
echo "<pre>{$config_file}</pre>";
echo elgg_view_form('admin/plugin_loader/import');
echo elgg_view_form('admin/plugin_loader/export');
