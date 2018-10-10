<?php
/*
 * GC Talent Cloud Invitation API start.php
 */

elgg_register_event_handler('init', 'system', 'talent_cloud_invite_api_init');

function talent_cloud_invite_api_init()
{
	include elgg_get_plugins_path() . 'talent_cloud_invite_api/actions/invite.php';
}
