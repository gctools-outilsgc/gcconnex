<?php
/**
 * show all pending group membership requests the user did
 */

$user = elgg_get_page_owner_entity();
if (!($user instanceof ElggUser) || !$user->canEdit()) {
	return;
}

$title = elgg_echo('group_tools:group:invitations:request');

// prepare get options
$limit = get_input('limit', elgg_get_config('default_limit'));
$offset = get_input('offset', 0);

$request_options = [
	'type' => 'group',
	'relationship' => 'membership_request',
	'relationship_guid' => $user->getGUID(),
	'limit' => $limit,
	'offset' => $offset,
	'count' => true,
];
$requests_count = elgg_get_entities_from_relationship($request_options);
unset($request_options['count']);
$requests = elgg_get_entities_from_relationship($request_options);

// prepare listing view
$vars['limit'] = $limit;
$vars['offset'] = $offset;
$vars['count'] = $requests_count;
$vars['items'] = $requests;
$vars['item_view'] = 'group_tools/format/membershiprequest';
$vars['no_results'] = elgg_echo('group_tools:group:invitations:request:non_found');

// get list
$list = elgg_view('page/components/list', $vars);

// draw result
echo elgg_view_module('info', $title, $list);
