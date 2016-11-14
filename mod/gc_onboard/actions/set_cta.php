<?php

/**
 * This will create metadata for users who choose to close the tutorial call to action. 
 *
 * ['type'] = what type of call to action did the user close? (ex profile)
 *
 * @version 1.0
 * @author Nick
 */

$user = elgg_get_logged_in_user_entity();
$type = get_input('type');
$count = get_input('count');
$type_metadata = $type .'cta';

$user->$type_metadata = $count;