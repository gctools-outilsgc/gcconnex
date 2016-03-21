<?php
/*
 * Preset all plugin settings.
 */
elgg_set_plugin_setting('search_limit', '100', 'missions');
elgg_set_plugin_setting('river_message_limit', '100', 'missions');
elgg_set_plugin_setting('advanced_element_limit', 6, 'missions');
elgg_set_plugin_setting('river_element_limit', 10, 'missions');
elgg_set_plugin_setting('search_result_per_page', 9, 'missions');
elgg_set_plugin_setting('mission_developer_tools_on', 'NO', 'missions');
elgg_set_plugin_setting('mission_front_page_limit', 3, 'missions');

$hour_string = ' ,00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23';
elgg_set_plugin_setting('hour_string', $hour_string, 'missions');

// $minute_string = ' ,00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,31,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59';
$minute_string = ' ,00,15,30,45';
elgg_set_plugin_setting('minute_string', $minute_string, 'missions');

$language_string = ' ,A,B,C';
elgg_set_plugin_setting('language_string', $language_string, 'missions');

$day_string = elgg_echo('missions:mon') . ',' . elgg_echo('missions:tue') . ',' . elgg_echo('missions:wed') . ',' . elgg_echo('missions:thu') . ',' . elgg_echo('missions:fri') . ',' . elgg_echo('missions:sat') . ',' . elgg_echo('missions:sun');
elgg_set_plugin_setting('day_string', $day_string, 'missions');

$security_string = ' ,' . elgg_echo('missions:enhanced_reliability') . ',' . elgg_echo('missions:secret') . ',' . elgg_echo('missions:top_secret');
elgg_set_plugin_setting('security_string', $security_string, 'missions');

$timezone_string = 'Canada/Pacific (-8),Canada/Mountain (-7),Canada/Central (-6),Canada/Eastern (-5),Canada/Atlantic (-4),Canada/Newfoundland (-3.5)';
elgg_set_plugin_setting('timezone_string', $timezone_string, 'missions');

$duration_string = ' ,1,2,3,4,5,6,7,8';
elgg_set_plugin_setting('duration_string', $duration_string, 'missions');

$time_rate_string = elgg_echo('missions:total') . ',' . elgg_echo('missions:per_week') . ',' . elgg_echo('missions:per_month');
elgg_set_plugin_setting('time_rate_string', $time_rate_string, 'missions');

$opportunity_type_string = elgg_echo('missions:micro_mission') . ',' .elgg_echo('missions:job_swap') . ',' . elgg_echo('missions:mentoring') . ',' . elgg_echo('missions:shadowing') . ',' . elgg_echo('missions:peer_coaching');
elgg_set_plugin_setting('opportunity_type_string', $opportunity_type_string, 'missions');