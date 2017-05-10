<?php
/**

Group Profile Sidebar

**/

$group = elgg_get_page_owner_entity();

//members widget
//Nick - we will keep the members in the sidebar
$display_members = $group->getPrivateSetting('group_tools:cleanup:members');

//show group members based on privacy setting
if($display_members != 'yes'){
  echo elgg_view('groups/sidebar/group_members', $vars);
}

//group activity
echo elgg_view('groups/sidebar/activity', $vars);

//subgroups
//I'll have to test if the user has sub groups and related groups active
echo elgg_view('au_subgroups/sidebar/subgroups', $vars);

//related groups
elgg_push_context('sidebar');
//echo elgg_view_module('related_sidebar', elgg_echo('groups_tools:related_groups:widget:title'), elgg_view('groups/profile/related', $vars));

echo elgg_view('groups/profile/related', $vars);
elgg_pop_context();
