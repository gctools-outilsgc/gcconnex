<?php
/**
 * 
 * The Elgg standard HTML footer option
 * to remove the "powered by elgg" logo
 */
echo elgg_view_menu('footer', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));

// powered by Elgg banner
$enable_powered_by_elgg = elgg_get_plugin_setting('enable_powered_by_elgg', 'phloor_logo_manager');
if(strcmp('true', $enable_powered_by_elgg) == 0) {
	$powered_url = elgg_get_site_url() . "_graphics/powered_by_elgg_badge_drk_bckgnd.gif";
	echo '<div class="mts clearfloat float-alt">';
	echo elgg_view('output/url', array(
		'href' => 'http://elgg.org',
		'text' => "<img src=\"$powered_url\" alt=\"Powered by Elgg\" width=\"106\" height=\"15\" />",
		'class' => '',
		'is_trusted' => true,
	));
	echo '</div>';
}
