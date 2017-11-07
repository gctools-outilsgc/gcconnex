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
}elseif($user->gcdeactivate == true){
	//If the user has deactivated we allow users to view profile but with a message
	echo elgg_format_element('div',array('class'=>'alert alert-warning clearfix col-sm-12'),'<i class="fa fa-exclamation" aria-hidden="true"></i> '.elgg_echo('member_selfdelete:gc:deactivate:profile'));
}
