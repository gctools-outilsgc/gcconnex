<?php
/**
 * Action to control if you can see colleague connections on newsfeed
 *
 * @author Ethan Wallace github.com/ethanWallace
*/


$user = elgg_get_logged_in_user_entity();

if(!isset($user->colleagueNotif) || $user->colleagueNotif == ''){ //turn off colleague connections
    $user->colleagueNotif = 'friend';
    system_message(elgg_echo('newsfeed:do'));
} else {  //turn on colleague connections
    $user->colleagueNotif = '';
    system_message(elgg_echo('newsfeed:undo'));
}
    ?>
    ?>
