<?php
/**
 * Idea view
 *
 * @package ideas
 */

$full = elgg_extract('full_view', $vars, FALSE);
$idea = elgg_extract('entity', $vars, FALSE);
$show_group = elgg_extract('show_group', $vars, FALSE);

if (!$idea) {
	return;
}

$owner = $idea->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'medium');
$container = $idea->getContainerEntity();
$user_guid = elgg_get_logged_in_user_guid();
$categories = elgg_view('output/categories', $vars);

$description = elgg_view('output/longtext', array('value' => $idea->description, 'class' => 'pbl'));

$title_link = elgg_view('output/url', array(
	'text' => $idea->title,
	'href' => $idea->getURL(),
	'class' => 'mrs'
));

$owner_link = elgg_view('output/url', array(
	'href' => "ideas/owner/$owner->username",
	'text' => $owner->name,
));
$author_text = elgg_echo('byline', array($owner_link));

$tags = elgg_view('output/tags', array('tags' => $idea->tags));
$date = elgg_view_friendly_time($idea->time_created);

if ($show_group && elgg_instanceof($container, 'group')) {
	$group_link = elgg_view('output/url', array(
		'href' => $container->getURL(),
		'text' => $container->name,
		'is_trusted' => true,
	));
	$group_text = elgg_echo('groups:ingroup') . ' ' . $group_link;
} else {
	$group_text = '';
}

$comments_count = $idea->countComments();
//only display if there are commments
if ($comments_count != 0) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $idea->getURL() . '#comments',
		'text' => $text,
	));
} else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'ideas',
	'sort_by' => 'priority',
	'class' => 'list-inline',
));

$subtitle = "$author_text $group_text $date $categories $comments_link";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

//dont display title in full view
if($full == 'full'){
    $params = array(
        'entity' => $idea,
        'title' => false,
        'metadata' => $metadata,
        'subtitle' => $subtitle,
        'tags' => $tags,
    );
} else {
    $params = array(
        'entity' => $idea,
        'metadata' => $metadata,
        'subtitle' => $subtitle,
        'tags' => $tags,
    );
}

$params = $params + $vars;
$list_body = elgg_view('object/elements/summary', $params);

// current points for idea
$sum = elgg_get_annotations(array(
	'guids' => $idea->guid,
	'annotation_names' => array('point', 'close'),
	'annotation_calculation' => 'sum',
	'limit' => 0
));
if ( $sum == '' ) $sum = 0;

$likes = elgg_get_annotations(array(
    'guids' => $idea->guid,
    'annotation_names' => array('point'),
    'annotation_values' => 1
));

$dislikes = elgg_get_annotations(array(
    'guids' => $idea->guid,
    'annotation_names' => array('point'),
    'annotation_values' => -1
));

// current users votes for idea
$userVote = elgg_get_annotations(array(
	'guids' => $idea->guid,
	'annotation_names' => array('point'),
	'annotation_calculation' => 'sum',
	'annotation_owner_guids' => $user_guid,
	'limit' => 0
));
//modify the vote
$point = ($sum == 1 || $sum == -1) ? "point" : "points";
$points = "<div class='idea-vote-counter text-center ideaPoints'><span class='wb-inv'>Vote count</span>$sum</div>";

if($container) { // ds - was a weird bug where the container presumably didn't exist??

    $vote .= "<div class='idea-vote-container pull-left'>";

    if ( $container->canWriteToContainer($user) ) {
        $url = elgg_add_action_tokens_to_url("action/ideas/rateidea");

        
        //$vote .= "<span class='idea-likes'>" . count($likes) . "</span>"; 
        if($userVote == 1) {
            $vote .= "<a href='$url' data-value='1' data-idea='{$idea->guid}'><i class='fa fa-arrow-up fa-lg icon-sel'></i><span class='wb-inv'>Upvote this Idea</span></a>";
        } else {
            $vote .= "<a href='$url' data-value='1' data-idea='{$idea->guid}'><i class='fa fa-arrow-up fa-lg icon-unsel'></i><span class='wb-inv'>Upvote this Idea</span></a>";
        }
        $vote .= $points;

        if($userVote == -1) {
            $vote .= "<a href='$url' data-value='-1' data-idea='{$idea->guid}'><i class='fa fa-arrow-down fa-lg icon-sel'></i><span class='wb-inv'>Downvote this Idea</span></a>";
        } else {
            $vote .= "<a href='$url' data-value='-1' data-idea='{$idea->guid}'><i class='fa fa-arrow-down fa-lg icon-unsel'></i><span class='wb-inv'>Downvote this Idea</span></a>";
        }
        //$vote .= "<span class='idea-dislikes'>" . count($dislikes) . "</span>";
       

    } else {
        $vote .= "<div class='idea-vote-counter text-center idea-points'><span class='wb-inv'>Vote count</span>$sum</div>";
    }

    $vote .= "</div>";

    // $totals = count($likes) . "<span class='elgg-icon elgg-icon-thumbs-up-alt'></span><span class='elgg-icon elgg-icon-thumbs-down-alt'></span>" . count($dislikes);
    
}
$idea_info = elgg_view_image_block($owner_icon, $list_body, array('class' => 'mbs'));
if ($full == 'full' && !elgg_in_context('gallery')) {

	
    
	echo <<<HTML
<div id="elgg-object-{$idea->guid}" class="elgg-item-idea">
<div class="col-xs-1">  $vote </div>
	<div class="col-xs-11">
		$idea_info
	</div>
    <div class="col-xs-12"> $description </div>
	
</div>
HTML;

} elseif ($full == 'sidebar') {

	echo <<<HTML
<div class="sidebar-idea-points">$sum</div><div class="sidebar-idea-title">$title_link</div>
HTML;

} elseif ($full == 'no_vote') {

	$content = elgg_get_excerpt($idea->description);
    $points = "<div class='idea-vote-counter text-center idea-points'><span class='wb-inv'>Vote count</span>$sum</div>";

	echo <<<HTML
<div class="col-xs-1">$points</div>
<div class="col-xs-11">
	<h3 class="mrgn-tp-0">$title_link</h3>
	<div class="elgg-subtext">$subtitle</div>
	<div class="elgg-content">$content</div>
</div>

HTML;
} elseif ($full == 'module') {

	$content = elgg_get_excerpt($idea->description);

	echo <<<HTML
<div class="col-xs-1">$points</div>
<div class="col-xs-11">
	<h3>$title_link</h3>
	<div class="elgg-subtext">$subtitle</div>
	<div class="elgg-content">$content</div>
</div>

HTML;

} elseif (elgg_in_context('gallery')) {

	echo <<<HTML
<div class="idea-gallery-item">
	<h3>$idea->title</h3>
	<p class='subtitle'>$owner_link $date</p>
</div>
HTML;

} else {

	// brief view
	if ( $full != 'searched') {
		$content = elgg_get_excerpt($idea->description);
	} else {
		$content = $idea->description;
	}

	echo <<<HTML
        <div class="col-xs-1">$vote</div>
<div class="col-xs-11">

    $idea_info
	
	
</div>

HTML;

}
