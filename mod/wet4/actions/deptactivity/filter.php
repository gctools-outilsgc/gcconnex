<?php
/**
 * Action to control if you can see colleague connections on newsfeed
 *
*/

$user = elgg_get_logged_in_user_entity();

if(!isset($user->DAconnections) || $user->DAconnections == ''){ //turn off colleague connections
    $user->DAconnections = 'friend';
    system_message(elgg_echo('dept:activity:do'));
} else {  //turn on colleague connections
    $user->DAconnections = '';
    system_message(elgg_echo('dept:activity:undo'));
}
?>
