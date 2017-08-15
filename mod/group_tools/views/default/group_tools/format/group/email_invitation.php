<?php
/**
 * Show an invitation to the group admin
 *
 * @uses $vars['entity'] the ElggUser being invited
 */

$page_owner = elgg_get_page_owner_entity();
if (!($page_owner instanceof ElggGroup) || !$page_owner->canEdit()) {
	return;
}

$email_invitation = elgg_extract('annotation', $vars);
if (!($email_invitation instanceof ElggAnnotation)) {
	return;
}

list(,$email) = explode('|', $email_invitation->value);

$email_title = elgg_view('output/email', ['value' => $email]);

$menu = elgg_view_menu('group:email_invitation', [
	'annotation' => $email_invitation,
	'group' => $page_owner,
	'order_by' => 'priority',
	'class' => 'elgg-menu-hz float-alt',
]);

$body = elgg_format_element('h4', [], $email_title);

echo elgg_view_image_block('', $body, ['image_alt' => $menu]);
