<?php

	// info box
	if(elgg_is_logged_in()){
		$title = elgg_view_icon("info", "float-alt");
		$title .= elgg_echo("file_tools:list:tree:info");
	
		$body = elgg_echo("file_tools:list:tree:info:" . rand(1,12));
	
		echo elgg_view_module("aside", $title, $body);
	}
