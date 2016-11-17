<?php

/**
 * This action sets metadata for users who visit the Wire and close the popup
 *
 * @version 1.0
 * @author Nick
 */


$user = elgg_get_logged_in_user_entity();
$visited_wire = get_input('visited');
$user->hasVisitedWire = $visited_wire;