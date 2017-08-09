<?php
/**
 * Mail group members
 */

$group = elgg_extract('entity', $vars);
$members = elgg_extract('members', $vars);

$friendpicker_value = [];
if (!empty($members)) {
	foreach ($members as $member) {
		$friendpicker_value[] = $member->getGUID();
	}
}

$form_data = '<label>';
$form_data .= elgg_echo('group_tools:mail:form:recipients');
$form_data .= ': ' . elgg_format_element('span', ['id' => 'group_tools_mail_recipients_count'], count($friendpicker_value));
$form_data .= '</label>';
$form_data .= '<br />';
$form_data .= elgg_view('output/url', [
	'text' => elgg_echo('group_tools:mail:form:members:selection'),
	'href' => '#group_tools_mail_member_selection',
	'rel' => 'toggle',
]);

$form_data .= '<div id="group_tools_mail_member_selection" class="hidden">';
$form_data .= elgg_view('input/friendspicker', [
	'entities' => $members,
	'value' => $friendpicker_value,
	'highlight' => 'all',
	'name' => 'user_guids',
]);
$form_data .= '</div>';

$form_data .= '<div id="group_tools_mail_member_options">';
$form_data .= elgg_view('input/button', [
	'class' => 'elgg-button-action mrs',
	'value' => elgg_echo('group_tools:clear_selection'),
	'onclick' => 'elgg.group_tools.mail_clear_members();',
]);
$form_data .= elgg_view('input/button', [
	'class' => 'elgg-button-action mrs',
	'value' => elgg_echo('group_tools:all_members'),
	'onclick' => 'elgg.group_tools.mail_all_members();',
]);
$form_data .= '</div>';

$form_data .= elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('group_tools:mail:form:title'),
	'name' => 'title',
]);

$form_data .= elgg_view_field([
	'#type' => 'longtext',
	'#label' => elgg_echo('group_tools:mail:form:description'),
	'name' => 'description',
	'required' => true,
]);

$form_data .= elgg_view('input/hidden', [
	'name' => 'group_guid',
	'value' => $group->getGUID(),
]);

echo $form_data;

$footer = elgg_view('input/submit', ['value' => elgg_echo('send')]);
elgg_set_form_footer($footer);
