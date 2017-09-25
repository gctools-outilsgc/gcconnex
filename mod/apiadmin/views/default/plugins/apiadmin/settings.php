<?php
/* 
 * API Admin plugin settings
 * 
 */

if ( !elgg_is_active_plugin('version_check') ) {
    register_error(elgg_echo('apiadmin:no_version_check'));
}

// Plugin setting: should we collect API stats?
if ( isset($vars['entity']->enable_stats) ) {
    $enable_stats = $vars['entity']->enable_stats;
} else {
    $enable_stats = '';
}

$label1 = elgg_echo('apiadmin:settings:enable_stats');
// Add a checkbox
$options1 = array(
    'name' => 'params[enable_stats]',
    'value' => 'on',
    'checked' => ($enable_stats == 'on')
);

// Plugin setting: should we drop stats tables on deactivate?
if ( isset($vars['entity']->keep_tables) ) {
    $keep_tables = $vars['entity']->keep_tables;
} else {
    $keep_tables = '';
}

$label2 = elgg_echo('apiadmin:settings:keep_tables');
// Add a checkbox
$options2 = array(
    'name' => 'params[keep_tables]',
    'value' => 'on',
    'checked' => ($keep_tables == 'on')
);

// display the UI

echo "<p>$label1 ";
echo elgg_view('input/checkbox', $options1);
echo '</p>';

echo "<p>$label2 ";
echo elgg_view('input/checkbox', $options2);
echo '</p>';
