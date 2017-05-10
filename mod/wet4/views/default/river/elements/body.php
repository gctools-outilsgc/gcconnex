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
	'class' => 'elgg-menu-hz river-margin',
));

// river item header
$timestamp = elgg_view_friendly_time($item->getTimePosted());

$summary = elgg_extract('summary', $vars);
if ($summary === null) {
	$summary = elgg_view('river/elements/summary', array(
		'item' => $vars['item'],
	));
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
	$message = "<div class=\"elgg-river-message mrgn-bttm-sm actPre\">$message</div>";
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

if($subtype_test == 'comment' || $subtype_test =='discussion_reply'){


    //$test = $subtype_test->getContainerEntity();
    //get the container of the container if it's a comment or reply
    $container = $container->getContainerEntity();
    $test = 'You need to find the group I am in.';
    $commentordiscuss = true;
    
    //$subtype_test2 = $subtype_test->getContainerEntity();
}else{
    $test = '';
    $commentordiscuss = false;
}


	$name = gc_explode_translation($container->title,$lang);


if ($container instanceof ElggGroup && $container->guid != elgg_get_page_owner_guid()) {
	$group_link = elgg_view('output/url', array(
		'href' => $container->getURL(),
		'text' => $name,
		'is_trusted' => true,
	));
    //Nick - Changed "in the group" to just the group link in order to show this is group content. May need some looking at
	$group_string = $group_link;
    $group_image = elgg_view_entity_icon($container, 'medium');
    $in_the_group = elgg_echo('river:ingroup', array($group_string));
   // $group_testing = elgg_view_image_block($group_image, $group_link);

    
}
//so when the activity happens in a group then display the users icon and stuff
$subject = $item->getSubjectEntity();
$user_icon = elgg_view_entity_icon($subject, 'small');


//removed $responses
//Nick - commented out comment or discuss var for instances of comments on blogs not within a group.
//Nick - checking for group activity context so it will use the other layout 
if($group_string /*|| $commentordiscuss*/ && !elgg_in_context('group_activity_tab')){
    $identify_activity = elgg_echo('group');
    echo <<<RIVER
<div class="">


<div aria-hidden="true" class="elgg-river-summary mrgn-bttm-sm river-group-link"> $group_string</div>
<h3 class="elgg-river-summary"> $summary <span class="wb-invisible">$in_the_group</span></h3>
<div class="elgg-river-timestamp mrgn-bttm-md timeStamp "><i>$timestamp</i><div class="pull-right">$menu</div></div>

</div>
<div class="  mrgn-bttm-sm mrgn-tp-sm">

$message 
$attachments 

</div>



RIVER;

}else{
    $identify_activity = elgg_echo('friend:river');
    echo <<<RIVER

<h3 class="elgg-river-summary  mrgn-bttm-sm river-user-heading"> $summary  </h3>

<div class="elgg-river-timestamp mrgn-bttm-sm timeStamp"><i>$timestamp</i> <div class="pull-right">$menu</div></div>

$message
$attachments


RIVER;

}

