<?php
/*
 * Preset all plugin settings.
 */

$opportunity_type_string = ',' . 'missions:mentoring' . ',' . 'missions:casual' . ',' . 'missions:student' . ',' . 'missions:collaboration';
elgg_set_plugin_setting('opportunity_type_string', $opportunity_type_string, 'missions');
