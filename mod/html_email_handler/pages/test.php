<?php 

	admin_gatekeeper();
	
	$title = elgg_echo("useradd:subject");
	$message = elgg_echo("useradd:body");
	
	echo elgg_view("html_email_handler/notification/body", array("title" => $title, "message" => $message));
