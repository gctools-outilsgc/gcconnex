<?php
/**
 * Elgg poll individual widget view
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 *
 * @uses $vars['entity'] Optionally, the poll post to view
*/

elgg_require_js('elgg/poll/poll');

$allow_close_date = elgg_get_plugin_setting('allow_close_date','poll');
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

?>

<h3><?php echo "<a href=\"{$poll->getURL()}\">{$poll->question}</a>"; ?></h3>

<?php
if ($show_close_date) {
	echo $closing_date;
}

echo "<div class=\"elgg-subtext\">{$author_text} {$friendlytime} {$comments_link}</div>";

echo $tags;

?>
<div id="poll-container-<?php echo $poll->guid; ?>" class="poll_post">
	<?php echo elgg_view('poll/poll_widget_content', $vars); ?>
</div>
