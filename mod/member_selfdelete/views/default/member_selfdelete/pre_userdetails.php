<?php

/**
This view gets called before the default profile/details view
It checks to see if we are looking at an inactive user
and if so sends them back to where they came from
 */

$user = elgg_get_page_owner_entity();

if ($user->member_selfdelete == "anonymized"){
	register_error(elgg_echo('member_selfdelete:profile_view'));
	forward(REFERRER);
}
