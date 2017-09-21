<?php
/*
badge showcase
reads user levels for each badge to display correctly
*/

$owner = elgg_get_page_owner_entity();

//get user levels for badges, display badges for levels above 0
$content = '<ul class="elgg-gallery" style="padding-left:0; margin: 0 auto;">';

$badges = get_badges();

foreach($badges as $badg){
    $currentBadge = $badg . 'Badge';

        //use width of 112px or 57px
        $content .= '<li class="col-xs-2" style="height:auto;" >';
        $content .= elgg_view('output/img', array(
                        'src' => 'mod/achievement_badges/graphics/' . $currentBadge . 'Lvl0' . $owner->$currentBadge . '.png',
                        'class' => 'img-responsive mrgn-rght',
                        'title' => elgg_echo('badge:' . $badg . ':achieved:' . $owner->$currentBadge, array($owner->getDisplayName())),
                        'alt' => $badg . ' ' . elgg_echo('badge:level', array($owner->$currentBadge)),
                    ));
        $content .= '</li>';
}

$content .= '</ul>';

$footer = "<br>";
$knowMore = '';

echo elgg_view_module('aside', elgg_echo('badge:badges') . $knowMore, $content, array('footer' => false));

?>
