<?php
/**
 * A group's member requests
 *
 * @uses $vars['entity']   ElggGroup
 * @uses $vars['requests'] Array of ElggUsers who requested membership
 * @uses $vars['invitations'] Array of ElggUsers who where invited
 */

// load js
elgg_require_js('group_tools/membershiprequests');

$group = elgg_extract('entity', $vars);
$requests = elgg_extract('requests', $vars);

if (empty($requests) || !is_array($requests)) {
	echo elgg_view('output/longtext', ['value' => elgg_echo('groups:requests:none')]);
	return;
}

$params = [
	'items' => $requests,
	'count' => count($requests),
	'limit' => false,
	'offset' => 0,
	'item_view' => 'group_tools/format/group/membershiprequest',
];
echo elgg_view('page/components/list', $params);
