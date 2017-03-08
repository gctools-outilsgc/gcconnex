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

    //if($owner->$currentBadge > 0){

        //use width of 112px or 57px
        $content .= '<li class="col-xs-2" style="height:auto;" >';
        $content .= elgg_view('output/img', array(
                            'src' => 'mod/achievement_badges/graphics/' . $currentBadge . 'Lvl0' . $owner->$currentBadge . '.png',
                            'class' => 'img-responsive mrgn-rght',
                            'title' => elgg_echo('badge:' . $badg . ':achieved:' . $owner->$currentBadge, array($owner->getDisplayName())),
                            'alt' => $badg . ' ' . elgg_echo('badge:level', array($owner->$currentBadge)),
                            ));
        $content .= '</li>';
    //}
}

$content .= '</ul>';



$footer = "<br>";

if(elgg_get_logged_in_user_guid() == elgg_get_page_owner_guid()){
    $knowMore = '<span class="pull-right"><a title="' . elgg_echo('badge:knowmore') . '" target="_blank" href="' . elgg_echo('badge:knowmorelink') . '""><i class="fa fa-info-circle icon-sel"><span class="wb-invisible">' . elgg_echo('badge:knowmore') . '</span></i></a></span>';
}


echo elgg_view_module('aside', elgg_echo('badge:badges') . $knowMore, $content, array('footer' => false));

?>
