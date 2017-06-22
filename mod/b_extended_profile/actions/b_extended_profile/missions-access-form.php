<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$access = get_input('completed_missions_access');
$user = get_user(get_input('hidden_user_guid'));

$user->missions_hide_all_completed = $access;
$user->save();

forward(REFERER);