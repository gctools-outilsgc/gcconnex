<?php 
/*

badge showcase
reads user levels for each badge to display correctly

*/

$owner = elgg_get_page_owner_entity();

//get user levels for badges, display badges for levels above 0
$content = '<ul class="elgg-gallery" style="padding-left:0">';




if($owner->likesBadge > 0){
    $content .= '<li class="mrgn-rght-sm" style="width:62px" >';
    $content .= elgg_view('output/img', array(
                            'src' => 'mod/achievement_badges/graphics/likesBadgeLvl0' . $owner->likesBadge . '.png',
                            'alt' => 'Likes Badge',
                            'class' => 'img-responsive mrgn-rght',
        'title' => $owner->getDisplayName() . ' achieved % likes'
                        ));
    $content .= '</li>';
}

if($owner->bookmarkBadge > 0){
    $content .= '<li class="mrgn-rght-sm" style="width:62px" >';
    $content .= elgg_view('output/img', array(
                            'src' => 'mod/achievement_badges/graphics/bookmrkBadgeLvl0' . $owner->bookmarkBadge . '.png',
                            'alt' => 'Bookmark Badge',
                            'class' => 'img-responsive',
        'title' => $owner->getDisplayName() . ' created % bookmarks'
                        ));
    $content .= '</li>';
}

if($owner->colleagueBadge > 0){
    $content .= '<li class="mrgn-rght-sm" style="width:62px" >';
    $content .= elgg_view('output/img', array(
                            'src' => 'mod/achievement_badges/graphics/colleagueBadgeLvl0' . $owner->colleagueBadge . '.png',
                            'alt' => 'Colleague Badge',
                            'class' => 'img-responsive',
        'title' => $owner->getDisplayName() . ' connected with % colleagues'
                        ));
    $content .= '</li>';
}

if($owner->commentBadge > 0){
    $content .= '<li class="mrgn-rght-sm" style="width:62px" >';
    $content .= elgg_view('output/img', array(
                            'src' => 'mod/achievement_badges/graphics/commentBadgeLvl0' . $owner->commentBadge . '.png',
                            'alt' => 'Comment Badge',
                            'class' => 'img-responsive',
        'title' => $owner->getDisplayName() . ' submitted % comments'
                        ));
    $content .= '</li>';
}

if($owner->discussionBadge > 0){
    $content .= '<li class="mrgn-rght-sm" style="width:62px" >';
    $content .= elgg_view('output/img', array(
                            'src' => 'mod/achievement_badges/graphics/bookmrkBadgeLvl0' . $owner->discussionBadge . '.png',
                            'alt' => 'Comment Badge',
                            'class' => 'img-responsive',
        'title' => $owner->getDisplayName() . ' created %s discussions'
                        ));
    $content .= '</li>';
}

$content .= '</ul>';



$footer = "<br>";


echo elgg_view_module('aside', 'Achievements', $content, array('footer' => $footer));

?>