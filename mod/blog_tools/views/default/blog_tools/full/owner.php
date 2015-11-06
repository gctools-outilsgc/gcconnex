<?php
/**
 * show some information about the blog owner
 *
 * @uses $vars['entity'] to get the ownet of the blog
 * @users $vars['full_view'] only when in full view of the blog
 */

$entity = elgg_extract("entity", $vars);
$full_view = elgg_extract("full_view", $vars, false);

if (!$full_view) {
	return;
}

$setting = elgg_get_plugin_setting("show_full_owner", "blog_tools");

if (($setting == "optional") && ($entity->show_owner != "yes")) {
	return;
} elseif (($setting != "yes") && ($setting != "optional")) {
	return;
}

$owner = $entity->getOwnerEntity();

if (!empty($owner) && elgg_instanceof($owner, "user")) {
	$icon = elgg_view_entity_icon($owner, "medium", array("use_hover" => false));
	
	$profile_fields = elgg_get_config("profile_fields");
	$brief = false;
	$description = false;
	
	if (!empty($profile_fields)) {
		foreach ($profile_fields as $metadata_name => $type) {
			if ($metadata_name == "briefdescription") {
				$brief = $type;
			} elseif ($metadata_name == "description") {
				$description = $type;
			}
		}
	}
	
	$content = "<h3>" . elgg_view("output/url", array(
		"text" => $owner->name,
		"href" => $owner->getURL(),
		"is_trusted" => true
	)) . "</h3>";
	
	if ($brief && $owner->briefdescription) {
		$content .= "<div>";
		$content .= elgg_view("output/" . $brief, array("value" => $owner->briefdescription));
		$content .= "</div>";
	}
	
	if ($description && $owner->description) {
		$content .= "<div>";
		$content .= "<strong>" . elgg_echo("profile:description") . "</strong>";
		$content .= elgg_view("output/" . $description, array("value" => elgg_get_excerpt($owner->description, 200)));
		$content .= "</div>";
	}
	
	echo elgg_view_image_block($icon, $content, array("class" => "mtm pam blog-tools-full-owner"));
}
