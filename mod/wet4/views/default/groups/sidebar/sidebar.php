<?php
/**

Group Profile Sidebar

**/


//members widget
echo elgg_view('groups/sidebar/group_members', $vars);

//group activity
echo elgg_view('groups/sidebar/activity', $vars);

//subgroups
echo elgg_view('au_subgroups/sidebar/subgroups', $vars);