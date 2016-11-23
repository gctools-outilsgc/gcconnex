<?php
	$loggedInUser = elgg_get_logged_in_user_entity()->username;
	$lang = 'en';
	if (isset($_COOKIE['connex_lang'])){
		$lang = $_COOKIE['connex_lang'];
	}
	forward(elgg_get_plugin_setting('gcpedia_url','saml_link')."saml/ucheck.php?username=".$loggedInUser."&lang=".$lang);
?>
