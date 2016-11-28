<?php

global $badgemap;

$badgemap = array(
	get_entity(662668)->name => 'Ambassadors_Badge_2.gif',
    get_entity(112)->name => 'Ambassadors_Badge_2.gif',
);

//initiative badges
global $initbadges;

//get GUID of mental health group for badge
$mentalHealth_guid = elgg_get_plugin_setting("mentalHealth_group", "gcProfilePictureBadges");

if(!$mentalHealth_guid){
    $mentalHealth_guid = 20934966;
}

$initbadges = array(
    get_entity($mentalHealth_guid)->name => 'mentalHealth',
);


?>
