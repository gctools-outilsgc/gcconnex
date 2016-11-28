<?php

/**
 * Newsfeed Filter form
 * 
 * @author Ethan Wallace    github.com/ethanWallace
 */
echo '<h3 class="mrgn-tp-sm">'.elgg_echo('newsfeed:filter').'</h3>';

//check if user has filter set
if(elgg_get_logged_in_user_entity()->colleagueNotif){
    $checked = true;
}

//check box
echo elgg_view('input/checkbox', array(
    'name' => 'colleague-off',
    'label' => elgg_echo('newsfeed:label'),
    'value' => 'friend',
    'checked' => $checked,
    ));

echo '<div>';
//submit button
echo elgg_view('input/submit', array(
        'class' => 'pull-right btn btn-primary',
        'id' => 'filter-submit',
        'value' => elgg_echo('save')
    ));
echo '</div>';
?>