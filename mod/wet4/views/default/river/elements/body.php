<?php
/**
 * Body of river item
 *
 * @uses $vars['item']        ElggRiverItem
 * @uses $vars['summary']     Alternate summary (the short text summary of action)
 * @uses $vars['message']     Optional message (usually excerpt of text)
 * @uses $vars['attachments'] Optional attachments (displaying icons or other non-text data)
 * @uses $vars['responses']   Alternate respones (comments, replies, etc.)
 *
 * GC_MODIFICATION
 * Description: Changes to the layout of the river body. Does checks for group activity to format the layout differently
 * Author: Nick github.com/piet0024
 */
$lang = get_current_language();
$item = $vars['item'];
/* @var ElggRiverItem $item */

$menu = elgg_view_menu('river', array(
	'item' => $item,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

// river item header
$timestamp = elgg_view_friendly_time($item->getTimePosted());

$summary = elgg_extract('summary', $vars);
if ($summary === null) {
	$summary = elgg_view('river/elements/summary', array(
		'item' => $vars['item'],
	));
}

$image = elgg_view('river/elements/image', $vars);
if ($image) {
	$image = elgg_format_element('div', [
		'class' => 'elgg-river-image',
	], $image);
}

if ($summary === false) {
	$subject = $item->getSubjectEntity();
	$summary = elgg_view('output/url', array(
		'href' => $subject->getURL(),
		'text' => $subject->name,
		'class' => 'elgg-river-subject',
		'is_trusted' => true,
	));

}

$message = elgg_extract('message', $vars);
if ($message !== null) {
	$message = "<div class=\"elgg-river-message actPre\">$message</div>";
}


$attachments = elgg_extract('attachments', $vars);
if ($attachments !== null) {
	$attachments = "<div class=\"elgg-river-attachments clearfix\">$attachments</div>";
}

$responses = elgg_view('river/elements/responses', $vars);
if ($responses) {
	$responses = "<div class=\"elgg-river-responses\">$responses</div>";
}

$group_string = '';
$object = $item->getObjectEntity();
$container = $object->getContainerEntity();

$subtype_test = $object->getSubtype();


	$name = gc_explode_translation($container->name,$lang);


	if ($container instanceof ElggGroup && $container->guid != elgg_get_page_owner_guid()) {
		$group_link = elgg_view('output/url', array(
			'href' => $container->getURL(),
			'text' => $name,
			'is_trusted' => true,
		));
		$group_string = elgg_echo('river:ingroup', array($group_link));
	}
//so when the activity happens in a group then display the users icon and stuff
$subject = $item->getSubjectEntity();
// $user_icon = elgg_view_entity_icon($subject, 'small');

$type = $object->getType();
if($type == 'group') {
	$message = elgg_view('river/object/group/attachment', array('item' => $vars['item']));
}
$count = elgg_view('river/object/likes/count', array('entity' => $object));

// Have a different display for list view
if(elgg_get_logged_in_user_entity()->newsfeedCard == 'list'){
	$view_test = 'LIST VIEW';
	$message = '';
	$attachments = '';
	$menu = '';
	$responses = '';
	$count = '';
}

echo <<<RIVER
<div>
<div class="elgg-river-summary clearfix mb-3">
$image $summary $group_string 
<div class="elgg-river-timestamp">$timestamp</div>
</div>
$message
$attachments
<div class="mt-3">
$menu
</div>
<div>
$count
</div>
$responses
</div>
RIVER;
