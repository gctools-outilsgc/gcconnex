<?php
/**
 * content of the featured groups widget
 *
 *GC_MODIFICATION
 *Nick - piet0024
 * Added limit counter with a default of 9 so we can display the featured groups on the welcome module
 */

$limit = elgg_extract('limit',$vars, 9);
$widget = elgg_extract("entity", $vars);

$num_display = (int) $widget->num_display;
if ($num_display < 1) {
	$num_display = 5;
}

$show_random = $widget->show_random;

$featured_options = array(
	"type" => "group",
	"limit" => $limit,
	"full_view" => false,
	"pagination" => false,
	"metadata_name_value_pairs" => array("featured_group" => "yes"),
	"order_by" => "RAND()"
);

if ($widget->show_members == "yes") {
	$show_members = true;
} else {
	$show_members = false;
}

if ($show_members) {
	elgg_push_context("widgets_groups_show_members");
}

$featured = elgg_get_entities_from_metadata($featured_options);

if ($show_members) {
	elgg_pop_context();
}

$list = $featured;
if (empty($list)) {
	$list = elgg_echo("notfound");
}

foreach($featured as $group){

    //dont show groups user is already a member of
    if($group->isMember(elgg_get_logged_in_user_entity())){
        //echo ' i am a member of '.$group->name;
    }else {
        $join_url = "action/groups/join?group_guid={$group->getGUID()}";

        if ($group->isPublicMembership() || $group->canEdit()) {
            $join_text = elgg_echo("groups:join");

        } else {
            // request membership
            $join_text = elgg_echo("groups:joinrequest");

        }
        echo '<div class="col-sm-6 hght-inhrt">';

        echo elgg_view('group/default', array('entity' => $group));

        //echo "<div class='text-center'>" . elgg_view("output/url", array("text" => $join_text, "href" => $join_url, "is_action" => true, "class" => "elgg-button elgg-button-action btn btn-primary mrgn-bttm-sm")) . "</div>";
        echo '<div class="text-center"><a id="featured-'.$group->guid.'" class="btn btn-primary mrgn-bttm-sm join-group" data-guid="'.$group->guid.'">'.$join_text.'</a></div>';
        echo '</div>';

    }
}

//echo $list;
