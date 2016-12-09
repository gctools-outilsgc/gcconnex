<?php
/*
 * filename.php
 * 
 * Handles the file folder view. Related to the file_tools mod
 * 
 * @package file_tools
 * 
 * GC_MODIFICATION
 * Description: changed the layout / added wet classes / accessibility modifications
 * Author: GCTools Team
 */

$folder = elgg_extract("entity", $vars);
$full_view = elgg_extract("full_view", $vars, false);
$lang = get_current_language();
$time_preference = "date";

if ($user_time_preference = elgg_get_plugin_user_setting('file_tools_time_display', null, "file_tools")) {
	$time_preference = $user_time_preference;
} elseif ($site_time_preference = elgg_get_plugin_setting("file_tools_default_time_display", "file_tools")) {
	$time_preference = $site_time_preference;
}

if ($time_preference == 'date') {
	$friendlytime 	= date(elgg_echo("friendlytime:date_format"), $folder->time_created);
} else {
	$friendlytime 	= elgg_view_friendly_time($folder->time_created);
}


if($folder->title3){
	$title = gc_explode_translation($folder->title3,$lang);
}else{
	$title = $folder->title;
}

if (empty($title)) {
	$title = elgg_echo("untitled");
}
$params = array(
	'text' => elgg_get_excerpt($title, 100),
	'href' => $folder->getURL(),
	'is_trusted' => true,
);
$title = elgg_view('output/url', $params);

$entity_menu = "";
if (!elgg_in_context("widgets")) {
	$entity_menu = elgg_view_menu("entity", array(
		"entity" => $folder,
		"handler" => "file_tools/folder",
		"sort_by" => "priority",
		"class" => "list-inline",
        'item_class' => 'mrgn-rght-sm',
	));
}

if ($full_view) {
	// full view
	$icon = elgg_view_entity_icon($folder, "small", array('img_class' => 'img-responsive',));
	
	$owner_link = elgg_view("output/url", array("text" => $folder->getOwnerEntity()->name, "href" => $folder->getOwnerEntity()->getURL()));
	$owner_text = elgg_echo("byline", array($owner_link));
	
	$subtitle = "$owner_text $friendlytime";
	
	$params = array(
		"entity" => $folder,
		"title" => $title,
		"metadata" => $entity_menu,
		"tags" => elgg_view("output/tags", array("value" => $folder->tags)),
		"subtitle" => $subtitle
	);
	
	$params = $params + $vars;
	$summary = elgg_view("object/elements/summary", $params);
	
	if($folder->description3){
		$body = elgg_view("output/longtext", array("value" => gc_explode_translation($folder->description3,$lang)));
	}else{
		$body = elgg_view("output/longtext", array("value" => $folder->description));
	}

	//Identify available content
	if(($folder->description2) && ($folder->description)){
		echo'<div id="change_language" class="change_language">';
		if (get_current_language() == 'fr'){

			?>			
			<span id="indicator_language_en" onclick="change_en('.elgg-output');"><span id="en_content" class="testClass hidden" ><?php echo $folder->description;?></span><span id="fr_content" class="testClass hidden" ><?php echo $folder->description2;?></span><?php echo elgg_echo('box:indicator:en') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:en') ?></span></span>
			<?php

		}else{
					
			?>			
			<span id="indicator_language_fr" onclick="change_fr('.elgg-output');"><span id="en_content" class="testClass hidden" ><?php echo $folder->description;?></span><span id="fr_content" class="testClass hidden" ><?php echo $folder->description2;?></span><?php echo elgg_echo('box:indicator:fr') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:fr') ?></span></span>
			<?php	
		}
		echo'</div>';
	}

	echo elgg_view("object/elements/full", array(
		"entity" => $folder,
		"title" => false,
		"icon" => $icon,
		"summary" => $summary,
		"body" => $body,
	));
    elgg_unregister_menu_item('title2', 'new_folder');
} else {

	// identify available content
/*	if(($folder->description2) && ($folder->description)){
			
		echo'<span class="col-md-1 col-md-offset-11"><i class="fa fa-language fa-lg mrgn-rght-sm"></i>' . '<span class="wb-inv">Content available in both language</span></span>';	
	}*/

	// summary view
	$icon = elgg_view_entity_icon($folder, "small");
	$icon_alt = "";
	if (!elgg_in_context("widgets")) {
		$icon_alt = elgg_view("input/checkbox", array("name" => "folder_guids[]", "value" => $folder->getGUID(), "default" => false));
	}
	
	$params = array(
		"entity" => $folder,
		"title" => $title,
		"metadata" => $entity_menu
	);
	
	$params = $params + $vars;
	$list_body = elgg_view("object/elements/summary", $params);
	echo elgg_view_image_block($icon, $list_body, array("class" => "file-tools-folder", "image_alt" => $icon_alt));
}
