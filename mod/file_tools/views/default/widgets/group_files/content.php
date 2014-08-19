<?php

	$widget = $vars["entity"];
	$group = $widget->getOwnerEntity();

	$number = sanitise_int($widget->file_count, false);
	if(empty($number)){
		$number = 4;
	}

	//get the group's files
	$options = array(
		"type" => "object",
		"subtype" => "file",
		"container_guid" => $group->getGUID(),
		"limit" => $number,
		"pagination" => false,
		"full_view" => false
	);

	//if there are some files, go get them
	if ($files = elgg_list_entities($options)) {
		//display in list mode
		echo $files;
	} else {
		echo elgg_echo("file:none");
	}
	
	$new_link = elgg_view("output/url", array(
				"href" => "file/add/" . $group->getGUID(),
				"text" => elgg_echo("file:add"),
				"is_trusted" => true,
	));
	echo "<div>" . $new_link . "</div>";