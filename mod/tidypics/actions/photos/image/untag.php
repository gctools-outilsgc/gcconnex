<?php
/**
 * Remove photo tag action
 */

$annotation = elgg_get_annotation_from_id(get_input('annotation_id'));

if (!$annotation instanceof ElggAnnotation || $annotation->name != 'phototag') {
	register_error(elgg_echo("tidypics:phototagging:delete:error"));
	forward(REFERER);
}

if (!$annotation->canEdit()) {
	register_error(elgg_echo("tidypics:phototagging:delete:error"));
	forward(REFERER);
}

$entity_guid = $annotation->entity_guid;

$image = get_entity($entity_guid);
if (!$image) {
        register_error(elgg_echo("tidypics:phototagging:error"));
        forward(REFERER);
}

$value = $annotation->value;

if ($annotation->delete()) {
	// KJ - now remove any user tag relationship
	$tag = unserialize($value);
	if ($tag->type == 'user') {
		remove_entity_relationship($tag->value, 'phototag', $entity_guid);
	} else if ($tag->type == 'word') {
	        $obsolete_tags = string_to_tag_array($tag->value);
	
                // delete normal tags if they exists
                if (is_array($image->tags)) {
                        $tagarray = array();
                        $removed_tags = array();
                        foreach($image->tags as $image_tag) {
                                if((!in_array($image_tag, $obsolete_tags)) || (in_array($image_tag, $removed_tags))) {
                                        $tagarray[] = $image_tag;
                                } else {
                                        $removed_tags[] = $image_tag;
                                }
                        }
                        $image->deleteMetadata('tags');
                        if (sizeof($tagarray) > 0) {
                                $image->tags = $tagarray;
                        }
                } else {
                        if ($tag->value === $image->tags) {
                                $image->deleteMetadata('tags');
                        }
                }
	}
	system_message(elgg_echo("tidypics:phototagging:delete:success"));
} else {
	system_message(elgg_echo("tidypics:phototagging:delete:error"));
}

forward(REFERER);
