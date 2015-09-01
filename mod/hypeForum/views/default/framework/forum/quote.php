<?php


$entity = elgg_extract('entity', $vars, false);
if (!$entity)
	return true;

$author = $entity->getOwnerEntity();
$author_link = elgg_view('framework/bootstrap/user/elements/name', array('entity' => $author));

$author_str = elgg_echo('hj:forum:quote:author', array($author_link));

$quote = preg_replace("/<blockquote[^>]*>.*?<\/blockquote>/si", '', $entity->description);

$quote = elgg_view('output/longtext', array(
	'value' => $quote
		));

echo <<<__QUOTE
<blockquote class="hj-forum-quote">
	<div class="hj-forum-quote-author">$author_str</div>
	$quote
</blockquote>
<p></p>
__QUOTE;
