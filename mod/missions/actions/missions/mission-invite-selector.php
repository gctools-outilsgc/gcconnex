<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$mission_guid = get_input('mission_guid');
$candidate_guid = get_input('hidden_user_guid');

$ts = time();
$token = generate_action_token($ts);

set_input('aid', $candidate_guid);
set_input('mid', $mission_guid);
set_input('__elgg_ts', $ts);
set_input('__elgg_token', $token);

action('missions/invite-user');