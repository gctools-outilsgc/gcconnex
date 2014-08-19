<?php 

	$entity = $vars["entity"];
	$size = $vars["size"];
	
	if (isset($vars["override"]) && $vars["override"] == true)
	{
		$override = true;
	}
	else
	{
		$override = false;
	}
	
	$allowed_sizes = array("tiny", "small", "medium");
	if(!in_array($size, $allowed_sizes))
	{
		$size = "small";
	}

	$icon = "<img src='" . elgg_format_url($entity->getIcon($size)) . "' alt='" . htmlentities($entity->title, ENT_QUOTES, "UTF-8") . "' title='" . htmlentities($entity->title, ENT_QUOTES, "UTF-8") . "' />";

	if(!$override)
	{
		echo "<a href='" . $entity->getURL() . "' class='icon'>";
		echo $icon;
		echo "</a>";
	}
	else
	{
		echo $icon;
	}
