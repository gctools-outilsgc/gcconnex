<?php

$widget_guid = (int) get_input('guid');
$show_access = (boolean) get_input('show_access', false);
if (!$widget_guid) {
	return;
}

$widget = get_entity($widget_guid);
if (!elgg_instanceof($widget, 'object', 'widget') || !$widget->canEdit()) {
	return;
}

elgg_push_context($widget->context);
elgg_push_context('widgets');
elgg_set_page_owner_guid($widget->getOwnerGUID());

$additional_class = preg_replace('/[^a-z0-9-]/i', '-', "elgg-form-widgets-save-{$widget->handler}");

$body_vars = ['widget' => $widget, 'show_access' => $show_access];
$form_vars = ['class' => $additional_class];

$form = elgg_view_form('widgets/save', $form_vars, $body_vars);

echo elgg_format_element('div', [
	'class' => 'widget-manager-lightbox-edit',
	'id' => "widget-edit-{$widget->getGUID()}",
], $form);

elgg_pop_context(); // undo widgets
elgg_pop_context(); // undo $widget->context
