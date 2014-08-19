<?php
/**
 * Elgg mobilize index layout
 *
 * @package mobilize
 * 
 * You can edit the layout of this page with your own layout and style. 
 * Whatever you put in this view will appear on the front page of your site.
 * 
 */

if (!elgg_is_logged_in()){

	$teaserstring = elgg_get_plugin_setting('teaserstring', 'mobilize');
	$teaseroutput = elgg_get_plugin_setting('teaseroutput', 'mobilize');

	if ($teaserstring == 'lang') {                
    	$content = elgg_echo("mobilize:teaser");
	} else if ($teaserstring == 'field') {
		$content = elgg_echo($teaseroutput);
	} else {
		//
	}

	$mod_params = array('class' => 'elgg-module-highlight');
	
	// Top box for login	
	$top_box = $vars['login'];
	
	echo elgg_view_module('index',  $content, $top_box, $mod_params);

} else {	
	forward('activity');
}
