<?php

$english = array(
  'gc_communities:title' => "Community Page Title",
  'gc_communities:url' => "Community Page URL",
  'gc_communities:animator' => "Community Animator",
  'gc_communities:tags' => "Community Tags",
  'gc_communities:delete' => "Delete Community Page",

  'gc_communities:communities' => "Communities",
  'gc_communities:community_newsfeed' => "Community Newsfeed",
  'gc_communities:community_wire' => "Community Wire",
  
  'gc_communities:filtered_activity_index' => "Filtered Activity",
  'gc_communities:filtered_blogs_index' => "Filtered Blog Posts",
  'gc_communities:filtered_discussions_index' => "Filtered Discussions",
  'gc_communities:filtered_events_index' => "Filtered Events",
  'gc_communities:filtered_feed_index' => "Filtered Feed",
  'gc_communities:filtered_groups_index' => "Filtered Groups",
  'gc_communities:filtered_members_index' => "Filtered Members",
  'gc_communities:filtered_spotlight_index' => "Filtered Image Gallery",
  'gc_communities:filtered_wire_index' => "Filtered Wire Posts",

  'gc_communities:enable_widgets' => "Enable widgets on community pages?",
  'gc_communities:newsfeed_shown' => "Newsfeed items shown:",
  'gc_communities:wires_shown' => "Wire posts shown:",
);

$communities = json_decode(elgg_get_plugin_setting('communities', 'gc_communities'));
foreach($communities as $community){
  $english['widget_manager:widgets:lightbox:title:gc_communities-' . $community->community_url] = "Add widgets";
}

return $english;
