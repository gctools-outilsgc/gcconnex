<?php
/**
 * Elgg poll plugin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */

$poll = $vars['entity'];

$owner = $poll->getOwnerEntity();
$friendlytime = elgg_get_friendly_time($poll->time_created);
$owner_link = elgg_view('output/url', array(
				'href' => "poll/owner/$owner->username",
				'text' => $owner->name,
				'is_trusted' => true,
	));
$author_text = elgg_echo('byline', array($owner_link));

$tags = elgg_view('output/tags', array('tags' => $poll->tags));

$responses = $poll->countAnnotations('vote');

$allow_close_date = elgg_get_plugin_setting('allow_close_date','poll');
if (($allow_close_date == 'yes') && (isset($poll->close_date))) {
	$show_close_date = true;
	$date_day = gmdate('j', $poll->close_date);
	$date_month = gmdate('m', $poll->close_date);
	$date_year = gmdate('Y', $poll->close_date);
	$friendly_time = $date_day . '. ' . elgg_echo("poll:month:$date_month") . ' ' . $date_year;

	$poll_state = $poll->isOpen() ? 'open' : 'closed';

	$closing_date = "<div class='poll_closing-date-{$poll_state}'><b>" . elgg_echo('poll:poll_closing_date', array($friendly_time)) . '</b></div>';
}

// TODO: support comments off
// The "on" status changes for comments, so best to check for !Off
if ($poll->comments_on != 'Off') {
	$comments_count = $poll->countComments();
	//only display if there are commments
	if ($comments_count != 0) {
		$text = elgg_echo("comments") . " ($comments_count)";
		$comments_link = elgg_view('output/url', array(
			'href' => $poll->getURL() . '#poll-comments',
			'text' => $text,
			'is_trusted' => true
		));
	} else {
		$comments_link = '';
	}
} else {
	$comments_link = '';
}

$icon = '<img src="' . elgg_get_simplecache_url('poll/poll.png') . '" alt="" />';
$info = "<a href=\"{$poll->getURL()}\">{$poll->question}</a><br>";
if ($responses == 1) {
	$noun = elgg_echo('poll:noun_response');
} else {
	$noun = elgg_echo('poll:noun_responses');
}
$info .= "$closing_date";
$info .= "$responses $noun<br>";
$info .= "<div class=\"elgg-subtext\">{$author_text} {$friendlytime} {$comments_link}</div>";
$info .= $tags;

echo elgg_view_image_block($icon, $info);
