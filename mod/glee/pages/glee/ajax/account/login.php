<?php

require_once(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . "/engine/start.php");

if (elgg_is_logged_in()) {
	return;
}

$login_box = elgg_view('core/account/login_box');

echo $login_box;
