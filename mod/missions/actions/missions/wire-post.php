<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$message = get_input('wire_message');
$char_limit = (int)elgg_get_plugin_setting('limit', 'thewire');

if(strlen($message) > $char_limit) {
	register_error(elgg_echo('missions:error:wire_post_too_long'));
	forward(REFERER);
}
else {
	thewire_tools_save_post($message, elgg_get_logged_in_user_guid(), ACCESS_LOGGED_IN);
	
	system_message(elgg_echo('missions:posted_to_the_wire'));
	forward(elgg_get_site_url() . 'missions/main');
}