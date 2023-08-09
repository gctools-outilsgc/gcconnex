<?php
/*
 * Preset all plugin settings.
 */

$opportunity_type_string = ',' . 'missions:mentoring' . ',' . 'missions:casual' . ',' . 'missions:student' . ',' . 'missions:collaboration' . ',' . 'missions:skill_share' . ',' . 'missions:interchange';
elgg_set_plugin_setting('opportunity_type_string', $opportunity_type_string, 'missions');

$security_string = ',' . 'missions:reliability' . ',' . 'missions:enhanced_reliability' . ',' . 'missions:secret' . ',' . 'missions:top_secret' . ',' . 'missions:none_security' . ',' . 'missions:none_security';
elgg_set_plugin_setting('security_string', $security_string, 'missions');