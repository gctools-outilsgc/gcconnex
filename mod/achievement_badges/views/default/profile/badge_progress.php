<?php
/*

Adds badge progress tab to user profile
Calls all badges seperatley

profile page > this file > badge page > progress layout 

profile page - final display of mod
this file - calls all the badges
badge page - does all the calculations/passes to layout
layout 
*/


echo '<div role="tabpanel" class="tab-pane fade-in" id="badgeProgress">';
    echo '<div class="clearfix">';

    $badges = get_badges();

    foreach($badges as $badge){
        echo elgg_view('badges/' . $badge, $vars);
    }


    echo '</div>';
echo '</div>';