<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$tabs = '';
$navigation_tabs = array(
		array(
				'text' => elgg_echo('missions:search_opportunities'),
				'href' => elgg_get_site_url() . 'missions/main/find',
				'selected' => $vars['highlight_one'],
				'id' => 'mission-navigate-to-find-opportunity'
		),
		array(
				'text' => elgg_echo('missions:find_members'),
				'href' => elgg_get_site_url() . 'missions/main/members',
				'selected' => $vars['highlight_three'],
				'id' => 'mission-navigate-to-member-search'
		),
		array(
				'text' => elgg_echo('missions:my_opportunities'),
				'href' => elgg_get_site_url() . 'missions/main/mine',
				'selected' => $vars['highlight_two'],
				'id' => 'mission-navigate-to-my-opportunities'
		),
		array(
				'text' => elgg_echo('missions:archive'),
				'href' => elgg_get_site_url() . 'missions/main/archive',
				'selected' => $vars['highlight_four'],
				'id' => 'mission-navigate-to-archive'
		)
);
if(elgg_get_plugin_setting('mission_analytics_on', 'missions') != 'NO') {
	$navigation_tabs[4] = array(
			'text' => elgg_echo('missions:analytics'),
			'href' => elgg_get_site_url() . 'missions/main/analytics',
			'selected' => $vars['highlight_five'],
			'id' => 'mission-navigate-to-analytics'
	);
}
	
$tabs = elgg_view('navigation/tabs', array(
		'class' => 'elgg-menu elgg-menu-filter list-inline mrgn-lft-sm elgg-menu-filter-default mission-tab',
		'tabs' => $navigation_tabs
));
//Nick - need to test if we are on analytics to not show the create button
//Nick - find out if the user is on the analytics page
 $current_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$break_url = explode('/',$current_url);
$current_path = array_pop($break_url);

if($current_path == "analytics"){ //Nick - Are we on analytics? don't show create button
   $create_button = ''; 
}else{
  $create_button = elgg_view('output/url', array(
        'href' => elgg_get_site_url() . 'action/missions/pre-create-opportunity',
        'text' => elgg_echo('missions:create_opportunity'),
        'is_action' => true,
        'class' => 'elgg-button btn btn-primary',
        'style' => 'float:right;',
        'id' => 'mission-create-opportunity-button'
)) . '</br>';  
}



?>

<div class="clearfix col-sm-12" style="margin-bottom:4px;">
	<div class="col-sm-9">
        <?php echo $tabs;
        
        ?>
        
    </div>
    <div class="col-sm-3">
        <?php echo $create_button; ?>
    </div>
</div>