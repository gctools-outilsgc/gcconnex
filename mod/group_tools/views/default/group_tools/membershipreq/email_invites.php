<?php

$emails = elgg_extract('emails', $vars);
$group = elgg_extract('entity', $vars);

if (empty($emails) || !is_array($emails)) {
	echo elgg_view('output/longtext', [
		'value' => elgg_echo('group_tools:groups:membershipreq:email_invitations:none'),
	]);
	return;
}

unset($vars['entity']);
unset($vars['emails']);
$vars['items'] = $emails;
$vars['item_view'] = 'group_tools/format/group/email_invitation';

echo elgg_view('page/components/list', $vars);
return;

$lis = [];
foreach ($emails as $annotation) {
	
	list(,$email) = explode('|', $annotation->value);
	
	$email_title = elgg_view('output/email', ['value' => $email]);
	
	$url = "action/group_tools/revoke_email_invitation?annotation_id={$annotation->id}&group_guid={$group->getGUID()}";
	$delete_button = elgg_view('output/url', [
		'href' => $url,
		'confirm' => elgg_echo('group_tools:groups:membershipreq:invitations:revoke:confirm'),
		'text' => elgg_echo('revoke'),
		'class' => 'elgg-button elgg-button-delete mlm',
	]);
	
	$body = elgg_format_element('h4', [], $email_title);
	
	$lis[] = elgg_format_element('li', ['class' => 'elgg-item'], elgg_view_image_block('', $body, ['image_alt' => $delete_button]));
}

// show list
echo elgg_format_element('ul', ['class' => 'elgg-list'], implode('', $lis));

// pagination
echo elgg_view('navigation/pagination', $vars);
