<?php

$entity = elgg_extract('entity', $vars);
$full = elgg_extract('full_view', $vars, false);

if (!$entity) {
	return true;
}

$user = $entity->getOwnerEntity();

$friendly_time = date("F j, Y - ga T", $entity->time_created);

if (HYPEFORUM_STICKY && $entity->isSticky()) {
	$icon = elgg_view('output/img', array(
		'src' => elgg_get_site_url() . 'mod/hypeForum/graphics/forumtopic/sticky.png',
		'height' => $config['tiny']['h'],
		'width' => $config['tiny']['w'],
		'title' => elgg_echo('hj:forum:sticky')
			));
}

if ($full) {
	$author = elgg_view('object/hjforumpost/elements/author', array('entity' => $user));
	$author_signature = elgg_view('object/hjforumpost/elements/signature', array('entity' => $user));

	$description = elgg_view('framework/bootstrap/object/elements/description', $vars);
	$menu = elgg_view('framework/bootstrap/object/elements/menu', $vars);

	$quote = elgg_view('framework/forum/quote', array('entity' => get_entity($entity->quote)));

	echo <<<__HTML
<div class="hj-forum-post-header"></div>
<div class="elgg-image-block hj-forum-post-body clearfix">
	<div class="elgg-image hj-forum-post-left">
		$author
	</div>
	<div class="elgg-body hj-forum-post-right clearfix">
		<div class="hj-forum-post-icons">$icon</div>
		<div class="hj-forum-post-time">$friendly_time</div>
		<div class="hj-forum-post-description">$quote$description</div>
		<div class="hj-forum-post-signature">$author_signature</div>
	</div>
</div>
<div class="hj-forum-post-footer clearfix">
	$menu
</div>
__HTML;

} else {
	echo $friendly_time . '<br />';
	echo elgg_view('output/url', array(
		'text' => elgg_echo('byline', array($user->name)),
		'href' => $entity->getURL()
	));
}