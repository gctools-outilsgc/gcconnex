<?php

elgg_require_js('groups/edit/access_simplified');

$open_text = '<h3>' . elgg_echo('group_tools:edit:access_simplified:open') . '</h3>';
$open_text .= elgg_view('output/longtext', ['value' => elgg_echo('group_tools:edit:access_simplified:open:description')]);

$closed_text = '<h3>' . elgg_echo('group_tools:edit:access_simplified:closed') . '</h3>';
$closed_text .= elgg_view('output/longtext', ['value' => elgg_echo('group_tools:edit:access_simplified:closed:description')]);

$open_text = elgg_format_element('div', [
	'class' => 'group-tools-simplified-access-button elgg-state-active',
	'data-group-type' => 'open',
], $open_text);

$closed_text = elgg_format_element('div', [
	'class' => 'group-tools-simplified-access-button',
	'data-group-type' => 'closed',
], $closed_text);

echo '<div class="group-tools-simplified-access-container clearfix">';
echo '<div class="elgg-col elgg-col-1of2">' . $open_text . '</div>';
echo '<div class="elgg-col elgg-col-1of2">' . $closed_text . '</div>';
echo '</div>';

echo elgg_format_element('div', ['class' => 'hidden'] , elgg_view('groups/edit/access', $vars));
