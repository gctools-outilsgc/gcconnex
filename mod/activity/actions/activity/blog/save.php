<?php
/**
 * Save blog entity
 *
 * @package Activity
 */

// start a new sticky form session in case of failure
elgg_make_sticky_form('blog');

$user = elgg_get_logged_in_user_entity();

$title = get_input('title');
$description = get_input('description');
$tags = get_input('tags');

if (empty($title)) {
	register_error(elgg_echo("blog:error:missing:title"));
	forward();
}

if (empty($description)) {
	register_error(elgg_echo("blog:error:missing:description"));
	forward();
}

$blog = new ElggBlog();
$blog->subtype = 'blog';
$blog->container_guid = $user->getGUID();
$blog->owner_guid = $user->getGUID();
$blog->title = $title;
$blog->description = $description;
$blog->excerpt = elgg_get_excerpt($description);
$blog->access_id = ACCESS_LOGGED_IN; // @TODO Make this configurable
$blog->comments_on = 'On';
$blog->tags = string_to_tag_array($tags);
$blog->status = 'published';

if ($blog->save()) {
	add_to_river('river/object/blog/create', 'create', $user->getGUID(), $blog->getGUID());
	system_message(elgg_echo('blog:message:saved'));
	// remove sticky form entries
	elgg_clear_sticky_form('blog');
} else {
	register_error(elgg_echo('blog:error:cannot_save'));
}

forward();