<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$tabs = '';
if(elgg_get_logged_in_user_entity()->opt_in_missions == 'gcconnex_profile:opt:yes') {
	$navigation_tabs = array(
			array(
					'text' => elgg_echo('missions:find_opportunity'),
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
			),
			array(
					'text' => elgg_echo('missions:analytics'),
					'href' => elgg_get_site_url() . 'missions/graph-interval',
					'selected' => $vars['highlight_five'],
					'id' => 'mission-navigate-to-analytics'
			)
	);
	
	$tabs = elgg_view('navigation/tabs', array(
			'class' => 'elgg-menu elgg-menu-filter list-inline mrgn-lft-sm elgg-menu-filter-default mission-tab',
			'tabs' => $navigation_tabs
	));
}
?>

<div style="margin-bottom:4px;">
	<?php echo $tabs; ?>
</div>