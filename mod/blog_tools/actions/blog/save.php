<?php
/**
 * Save blog entity
 *
 * Can be called by clicking save button or preview button. If preview button,
 * we automatically save as draft. The preview button is only available for
 * non-published drafts.
 *
 * Drafts are saved with the access set to private.
 *
 * @package Blog
 */

// start a new sticky form session in case of failure
elgg_make_sticky_form('blog');

// save or preview
$save = (bool)get_input('save');

// store errors to pass along
$error = FALSE;
$error_forward_url = REFERER;
$user = elgg_get_logged_in_user_entity();


// edit or create a new entity
$guid = get_input('guid');

if ($guid) {
	$entity = get_entity($guid);
	if (elgg_instanceof($entity, 'object', 'blog') && $entity->canEdit()) {
		$blog = $entity;
	} else {
		register_error(elgg_echo('blog:error:post_not_found'));
		forward(get_input('forward', REFERER));
	}

	// save some data for revisions once we save the new edit
	$revision_text = $blog->description;
	$new_post = $blog->new_post;
} else {
	$blog = new ElggBlog();
	$blog->subtype = 'blog';
	$blog->container_guid = (int) get_input('container_guid');
	
	$new_post = TRUE;
}

// set the previous status for the hooks to update the time_created and river entries
$old_status = $blog->status;

// set defaults and required values.
$values = array(
	'title' => '',
	'title2' => '',
	//'title3' => '',
	'description' => '',
	'description2' => '',
	'description3' => '',
	'status' => 'draft',
	'access_id' => ACCESS_DEFAULT,
	'comments_on' => 'On',
	'excerpt' => '',
	'excerpt2' => '',
	'excerpt3' => '',
	'tags' => '',
	'publication_date' => '',
	'expiration_date' => '',
	'show_owner' => 'no'
);

// fail if a required entity isn't set
$required = array('title', 'description');
$cart = array(); //Create a array to compare if english or french title and description is in.
foreach ($values as $name => $default) {

	 $cart[] = array($name => $values);
}

if ($cart['title'] && $cart['title2'] == ''){
	$error = elgg_echo("blog:error:missing:title");

}

if ($cart['description'] && $cart['description2'] == '') {
	$error = elgg_echo("blog:error:missing:description");
}



// cyu - implement minor edit functionality as per requirements document (notification)
$minor_edit = get_input('chk_blog_minor_edit');
$blog->entity_minor_edit = $minor_edit[0];


// load from POST and do sanity and access checking
foreach ($values as $name => $default) {
	if ($name === 'title') {
		$value = htmlspecialchars(get_input('title', $default, false), ENT_QUOTES, 'UTF-8');
	} else {
		$value = get_input($name, $default);
	}
	
	if (in_array($name, $required) && empty($value)) {
		$error = elgg_echo("blog:error:missing:$name");
		break;
	}

	switch ($name) {
		case 'tags':
			$values[$name] = string_to_tag_array($value);
			break;

		case 'excerpt2':
			if ($value) {
				$values[$name] = elgg_get_excerpt($value);
			}
			break;

		case 'excerpt':
			if ($value) {
				$values[$name] = elgg_get_excerpt($value);
			}
			break;

		case 'publication_date':
			if (!empty($value)) {
				$values[$name] = $value;
				
				// publication date has not yet passed, set as draft
				if (strtotime($value) > time()) {
					$save = false;
				}
			}
			break;
			
		case 'expiration_date':
			if (!empty($value)) {
				$values[$name] = $value;
				
				if ($new_post) {
					// new blogs can't expire directly
					if (strtotime($value) < time()) {
						$error = elgg_echo("blog_tools:action:save:error:expiration_date");
					}
				} else {
					// if expiration is passed, set as draft
					if (strtotime($value) < time()) {
						$save = false;
					}
				}
			}
			break;
			
		default:
			$values[$name] = $value;
			break;
	}
}

/*if (!$values['title']){
	$values['title'] = $values['title2'];
}*/
//implode for tranlation
$values['title'] = gc_implode_translation($values['title'], $values['title2']);
$values['excerpt'] = gc_implode_translation($values['excerpt'], $values['excerpt2']);
$values['description'] =gc_implode_translation($values['description'], $values['description2']);
// if preview, force status to be draft
if ($save == false) {
	$values['status'] = 'draft';
}

// if draft, set access to private and cache the future access
if ($values['status'] == 'draft') {
	$values['future_access'] = $values['access_id'];
	$values['access_id'] = ACCESS_PRIVATE;
}

// assign values to the entity, stopping on error.
if (!$error) {
	foreach ($values as $name => $value) {
		if (($name != 'title2') && ($name != 'description2') &&  ($name != 'excerpt2')){ // remove input 2 in metastring table
		$blog->$name = $value;
		}
	}
}

// only try to save base entity if no errors
if (!$error) {
	if ($blog->save()) {
		// handle icon upload
		if (get_input("remove_icon") == "yes") {
			// remove existing icons
			blog_tools_remove_blog_icon($blog);
		} else {
			$icon_file = get_resized_image_from_uploaded_file("icon", 100, 100);
			$icon_sizes = elgg_get_config("icon_sizes");
			
			if (!empty($icon_file) && !empty($icon_sizes)) {
				// create icon
				$prefix = "blogs/" . $blog->getGUID();
				
				$fh = new ElggFile();
				$fh->owner_guid = $blog->getOwnerGUID();
				
				foreach ($icon_sizes as $icon_name => $icon_info) {
					$icon_file = get_resized_image_from_uploaded_file("icon", $icon_info["w"], $icon_info["h"], $icon_info["square"], $icon_info["upscale"]);
					if (!empty($icon_file)) {
						$fh->setFilename($prefix . $icon_name . ".jpg");
						
						if ($fh->open("write")) {
							$fh->write($icon_file);
							$fh->close();
						}
					}
				}
				
				$blog->icontime = time();
			}
		}
		
		// remove sticky form entries
		elgg_clear_sticky_form('blog');

		// remove autosave draft if exists
		$blog->deleteAnnotations('blog_auto_save');

		// no longer a brand new post.
		$blog->deleteMetadata('new_post');

		// if this was an edit, create a revision annotation
		if (!$new_post && $revision_text) {
			$blog->annotate('blog_revision', $revision_text);
		}

		system_message(elgg_echo('blog:message:saved'));

		$status = $blog->status;
		// add to river if changing status or published, regardless of new post
		// because we remove it for drafts.
		if (($new_post || $old_status == 'draft' ||  $old_status == 'published') && $status == 'published') {
			elgg_create_river_item(array(
				'view' => 'river/object/blog/create',
				'action_type' => 'create',
				'subject_guid' => $blog->owner_guid,
				'object_guid' => $blog->getGUID(),
			));
			// we only want notifications sent when post published
			elgg_trigger_event('publish', 'object', $blog);
			

			// reset the creation time for posts that move from draft to published
			if ($guid) {
				$blog->time_created = time();
				$blog->save();
			}
		} elseif ($old_status == 'published' && $status == 'draft') {
			elgg_delete_river(array(
				'object_guid' => $blog->guid,
				'action_type' => 'create',
			));
		}

		if ($blog->status == 'published' || $save == false) {
			forward($blog->getURL());
		} else {
			forward("blog/edit/$blog->guid");
		}
	} else {
		register_error(elgg_echo('blog:error:cannot_save'));
		forward($error_forward_url);
	}
} else {
	register_error($error);
	forward($error_forward_url);
}
