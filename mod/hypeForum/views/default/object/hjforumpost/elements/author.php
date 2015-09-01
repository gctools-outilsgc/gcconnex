<?php
$user = $vars['entity'];

if (!$user) return true;

$name = elgg_view('output/url', array(
	'text' => $user->name,
	'href' => $user->getURL(),
	'class' => 'hj-forum-post-author-link',
	'is_trusted' => true
));

$icon = elgg_view_entity_icon($user, 'medium');

echo '<div class="hj-forum-post-owner-block">';
echo $name . '<br />' . $icon;
echo '</div>';