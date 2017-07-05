<?php
/**
 * Save image action
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

// Get input data
$title = get_input('title');
$title2 = get_input('title2');
$description = get_input('description');
$description2 = get_input('description2');
$tags = get_input('tags');
$guid = get_input('guid');

elgg_make_sticky_form('tidypics');

if ((empty($title)) && (empty($title2))) {
	register_error(elgg_echo("image:blank"));
	forward(REFERER);
}

$image = get_entity($guid);

$image->title = $title;
$image->title2 = $title2;
$image->title = gc_implode_translation($title,$title2);
$image->description = $description;
$image->description2 = $description2;
$image->description = gc_implode_translation($description,$description2);

if($tags) {
        $image->tags = string_to_tag_array($tags);
} else {
        $image->deleteMetadata('tags');
}

if (!$image->save()) {
	register_error(elgg_echo("image:error"));
	forward(REFERER);
}

elgg_clear_sticky_form('tidypics');

system_message(elgg_echo("image:saved"));
forward($image->getURL());
