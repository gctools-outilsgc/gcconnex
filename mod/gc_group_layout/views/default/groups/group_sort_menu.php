<?php
/**
 * All groups listing page navigation
 *
 */
$user = elgg_get_logged_in_user_entity();
if($user) {
	/** Adding badge to invite tab, just see if there is at least 1 */
	$request_options = array(
		"relationship" => "invited",
		"relationship_guid" => (int) $user->getGUID(),
		"inverse_relationship" => true,
		"count" => true,
		"limit" => 1,
	);
	$requests = elgg_get_entities_from_relationship($request_options);
	$badge = "";
	if($requests) {
		/** TODO: make better */
		$badge = '<span class="notif-badge" style="padding:6px;"><span class="wb-invisible">'.elgg_echo('new').'</span></span>';
	}
}
$tabs = array(
	"newest" => array(
		"text" => elgg_echo("sort:newest"),
		"href" => "groups/all?filter=newest",
		"priority" => 200,
	),
	"yours" => array(
		"text" => elgg_echo("groups:yours"),
		"href" => "/groups/all?filter=yours",
		"priority" => 250,
	),
	//"popular" => array(
	//	"text" => elgg_echo("sort:popular"),
	//	"href" => "groups/all?filter=popular",
	//	"priority" => 300,
	//),
	"discussion" => array(
		"text" => elgg_echo("groups:latestdiscussion"),
		"href" => "groups/all?filter=discussion",
		"priority" => 400,
	),
	"open" => array(
		"text" => elgg_echo("group_tools:groups:sorting:open"),
		"href" => "groups/all?filter=open",
		"priority" => 500,
	),
	"closed" => array(
		"text" => elgg_echo("group_tools:groups:sorting:closed"),
		"href" => "groups/all?filter=closed",
		"priority" => 600,
	),
	"alpha" => array(
		"text" => elgg_echo("group_tools:groups:sorting:alphabetical"),
		"href" => "groups/all?filter=alpha",
		"priority" => 700,
	),
	"ordered" => array(
		"text" => elgg_echo("group_tools:groups:sorting:ordered"),
		"href" => "groups/all?filter=ordered",
		"priority" => 800,
	),
	"suggested" => array(
		"text" => elgg_echo("group_tools:groups:sorting:suggested"),
		"href" => "groups/suggested",
		"priority" => 900,
	),
    "invitations" => array(
		"text" => elgg_echo("Invitations") . $badge,
		"href" => "groups/invitations/$user->username",
		"priority" => 900,
	),
);



// if user is the gsa-crawler
if (elgg_is_active_plugin('gc_fedsearch_gsa') || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'solr-crawler') !== false ) {
  
	// cyu - added discussion
	$tabs["gsa_all_discussions"] = array(
		"text" => elgg_echo("Discussions (gsa only)"),
		"href" => "groups/all?gsa=discussion",
		"priority" => 100,
	);

	// cyu - added all groups (and subgroups)
	$tabs["gsa_all_groups"] = array(
		"text" => elgg_echo("Groups (gsa only)"),
		"href" => "groups/all?gsa=groups",
		"priority" => 150,
	);
}



foreach ($tabs as $name => $tab) {
	$show_tab = false;
	$show_tab_setting = elgg_get_plugin_setting("group_listing_" . $name . "_available", "group_tools");
	if ($name == "ordered") {
		if ($show_tab_setting == "1") {
			$show_tab = true;
		}
	} elseif ($show_tab_setting !== "0") {
		$show_tab = true;
	}
	
	if ($show_tab && in_array($name, array("yours", "suggested", "invitations")) && !elgg_is_logged_in()) {
		$show_tab = false;
	}
	
	if ($show_tab) {
		$tab["name"] = $name;
		
		if ($vars["selected"] == $name) {
			$tab["selected"] = true;
		}
	
		elgg_register_menu_item("filter", $tab);
	}
}

if(elgg_is_logged_in()){
    elgg_register_menu_item('filter', array(
        'name' => 'owned',
        'priority' => 275,
        'text' => elgg_echo('groups:owned'),
        'href' => 'groups/owner/' . $user->username));
}

?>

<script type="text/javascript">

    //place additional group tools in dropdown menu
    $(document).ready( function(){

        //grab all list items
        var listItems = $('.elgg-menu-filter li').toArray();

        //if filter menu has six items
        if (listItems.length >= 6) {
            $('.elgg-menu-filter').append('<li class="elgg-menu-item-more dropdown"><a href="" data-toggle="dropdown" class="elgg-menu-content dropdown-toggle"><?php echo elgg_echo('gprofile:more') ?><b class="caret"></b></a></li>');
            $('.elgg-menu-filter .dropdown').append('<ul class="dropdown-menu pull-right"></ul>');
            var items;
            for (var i = 0; i < listItems.length; i++) {
                if (i >= 4) {
                    items = $(listItems[i]).clone();
                    $('.elgg-menu-filter .dropdown-menu').append(items);
                    listItems[i].parentNode.removeChild(listItems[i]);

                }
            }

            //working out css changes
            $('.elgg-menu-filter .dropdown li a').css('padding', '3px 20px');
            $('.elgg-menu-filter .dropdown .active a').css('color', 'white');


        }

});


</script>


<?php


echo elgg_view_menu("filter", array("sort_by" => "priority", "class" => "elgg-menu-hz"));
