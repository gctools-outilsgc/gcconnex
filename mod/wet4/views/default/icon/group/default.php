<?php

namespace AU\SubGroups;

/**
 * Generic icon view.
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['entity']     The entity the icon represents - uses getIconURL() method
 * @uses $vars['size']       topbar, tiny, small, medium (default), large, master
 * @uses $vars['href']       Optional override for link
 * @uses $vars['img_class']  Optional CSS class added to img
 * @uses $vars['link_class'] Optional CSS class for the link
 */
$entity = $vars['entity'];

$sizes = array('small', 'medium', 'large', 'tiny', 'master', 'topbar');
// Get size
if (!in_array($vars['size'], $sizes)) {
	$vars['size'] = "medium";
}

$class = elgg_extract('img_class', $vars, '');

$span = '';
$parent = get_parent_group($entity);
if ($parent) {
  if ($class) {
    $class .= ' ';
  }
  $class .= 'au_subgroup_icon ';
  $span = '<span class="au_subgroup au_subgroup_icon-' . $vars['size'] . '">' . elgg_echo('au_subgroups:subgroup') . '</span>';
}

if (isset($entity->name)) {
	$title = $entity->name;
} else {
	$title = $entity->title;
}
$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8', false);

$url = $entity->getURL();
if (isset($vars['href'])) {
	$url = $vars['href'];
}

$icon_sizes = elgg_get_config('icon_sizes');
$size = $vars['size'];

// maintain aspect ratio
$filehandler = new \ElggFile();
$filehandler->owner_guid = $entity->owner_guid;
$filehandler->setFilename("groups/" . $entity->guid . $size . ".jpg");

$location = elgg_get_plugins_path() . "groups/graphics/default{$size}.gif";
if ($filehandler->open("read")) {
  $location = $filehandler->getFilenameOnFilestore();
}

$imginfo = getimagesize($location);

if($imginfo){
	$realratio = $imginfo[0]/$imginfo[1];
  $img_height = $size != 'master' ? $icon_sizes[$size]['h'] : NULL;
  $img_width = $size != 'master' ? $icon_sizes[$size]['w'] : NULL;
  
	//set ratio greater than realratio by default in case $img_height = 0
	$setratio = $realratio + 1;
	if(!empty($img_height)){
		$setratio = $img_width/$img_height;
	}
	    		
	// set the largest dimension to "auto"
	if($realratio > $setratio || empty($img_height)){
		// constrain the height
		$img_height = NULL;
	}
	elseif($realratio < $setratio || empty($img_width)){
		$img_width = NULL;
	}
}

$img = '<div class="au_subgroups_group_icon au_subgroups_group_icon-' . $vars['size'] . '-wet4">';
$img .= elgg_view('output/img', array(
	'src' => $entity->getIconURL($vars['size']),
	'alt' => $title,
	'class' => $class . 'img-responsive img-circle',
	'width' => $img_width,
	'height' => $img_height,
));
$img .= "{$span}</div>";

if ($url) {
	$params = array(
		'href' => $url,
		'text' => $img,
		'is_trusted' => true,
	);
	$class = elgg_extract('link_class', $vars, '');
	if ($class) {
		$params['class'] = $class;
	}

	echo elgg_view('output/url', $params);
} else {
	echo $img;
}
