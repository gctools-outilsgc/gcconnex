<?php 

	// get widget settings
	$count = sanitise_int($vars["entity"]->file_count, false);
	if(empty($count)){
		$count = 8;
	}

	$options = array(
		"type" => "object",
		"subtype" => "file",
		"limit" => $count,
		"full_view" => false,
		"pagination" => false
	);
	
	if($files = elgg_list_entities($options)){
		echo $files;
		
		echo "<span class='elgg-widget-more'>";
		echo elgg_view("output/url", array("href" => "file/all", "text" => elgg_echo("file:more"), "is_trusted" => true));
		echo "</span>";
	} else {
		echo elgg_echo("file:none");
	}
