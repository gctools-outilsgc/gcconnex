<?php
/**
 * Elgg Polls plugin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */

$poll = $vars['entity'];
$owner = $poll->getOwnerEntity();
$friendlytime = elgg_get_friendly_time($poll->time_created);
$responses = $poll->countAnnotations('vote');
$lang = get_current_language();
$question = gc_explode_translation($poll->question,$lang);

$icon = '<img src="'.elgg_get_site_url().'mod/polls/graphics/poll.png" />';
$info = "<a href=\"{$poll->getURL()}\">{$question}</a><br>";

if ($responses == 1) {
	$noun = elgg_echo('polls:noun_response');
} else {
	$noun = elgg_echo('polls:noun_responses');
}
$info .= "$responses $noun<br>";
$info .= "<p class=\"owner_timestamp\"><a href=\"{$owner->getURL()}\">{$owner->name}</a> {$friendlytime}</p>";
echo elgg_view_image_block($icon,$info);

