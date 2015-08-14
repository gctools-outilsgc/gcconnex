<?php
	$loggedInUser = elgg_get_logged_in_user_entity()->username;
	$lang = 'en';
	if (isset($_COOKIE['connex_lang'])){
		$lang = $_COOKIE['connex_lang'];
	}
	forward("http://www.gcpedia.gc.ca/saml/ucheck.php?username=".$loggedInUser."&lang=".$lang);
?>
