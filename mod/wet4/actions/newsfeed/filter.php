<?php
//Action to control if you can see colleague connections on newsfeed

$user = elgg_get_logged_in_user_entity();
$colleague = get_input('colleague-off');

if($colleague){ //turn off colleague connections
    $user->colleagueNotif = $colleague;
    system_message(elgg_echo('newsfeed:do'));
} else {  //turn on colleague connections
    $user->colleagueNotif = '';
    system_message(elgg_echo('newsfeed:undo'));
}
    ?>