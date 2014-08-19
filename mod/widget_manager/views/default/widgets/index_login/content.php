<?php
/**
 * Elgg login form
 *
 * @package Elgg
 * @subpackage Core
 */
	
	if(!elgg_is_logged_in()){
		
		$login_url = elgg_get_site_url();
		if (elgg_get_config('https_login')) {
			$login_url = str_replace("http:", "https:", elgg_get_site_url());
		}
		
		echo elgg_view_form('login', array('action' => "{$login_url}action/login"), array('returntoreferer' => TRUE));
		
	} else {
		echo elgg_echo("widget_manager:widgets:index_login:welcome", array(elgg_get_logged_in_user_entity()->name, $vars["config"]->site->name));
	}
