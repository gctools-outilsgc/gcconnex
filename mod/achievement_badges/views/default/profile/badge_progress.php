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

        //view likes badge
        echo elgg_view('badges/likes', $vars);
        echo elgg_view('badges/discussion', $vars);
        echo elgg_view('badges/colleagues', $vars);
        echo elgg_view('badges/comments', $vars);
        echo elgg_view('badges/bookmarks', $vars);

    echo '</div>';
echo '</div>';