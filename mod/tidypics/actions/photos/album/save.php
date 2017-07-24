<?php
/**
 * Save album action
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
$access_id = get_input('access_id');
$container_guid = get_input('container_guid', elgg_get_logged_in_user_guid());
$guid = get_input('guid');

elgg_make_sticky_form('tidypics');

if (empty($title) && empty($title2)) {
	register_error(elgg_echo("album:blank"));
	forward(REFERER);
}

if ($guid) {
	$album = get_entity($guid);
	if ($album->access_id != $access_id) {
            $options = array('type' => 'object', 'subtype' => 'image', 'container_guid' => $album->guid, 'limit' => false);
            $images = new ElggBatch('elgg_get_entities', $options);
	    foreach($images as $image) {
	        $image->access_id = $access_id;
	        $image->save();
	    }
	    $options = array('type' => 'object', 'subtype' => 'tidypics_batch', 'container_guid' => $album->guid, 'limit' => false);
            $batches = new ElggBatch('elgg_get_entities', $options);
            foreach($batches as $batch) {
                $batch->access_id = $access_id;
                $batch->save();
            }
	}
} else {
	$album = new TidypicsAlbum();
}

$album->container_guid = $container_guid;
$album->owner_guid = elgg_get_logged_in_user_guid();
$album->access_id = $access_id;
$album->title = $title;
$album->title2 = $title2;
$album->title = gc_implode_translation($title,$title2);
$album->description = $description;
$album->description2 = $description2;
$album->description = gc_implode_translation($description,$description2);

if($tags) {
        $album->tags = string_to_tag_array($tags);
} else {
        $album->deleteMetadata('tags');
}

if (!$album->save()) {
	register_error(elgg_echo("album:error"));
	forward(REFERER);
}

elgg_clear_sticky_form('tidypics');

system_message(elgg_echo("album:created"));
forward($album->getURL());
