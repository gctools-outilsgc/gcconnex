<?php
/**
 * Group entity view
 *
 * @package ElggGroups
 */

$group = $vars['entity'];
// $lang = get_current_language();
if(elgg_get_context() == 'widgets' || elgg_get_context() == 'custom_index_widgets'){
    $icon = elgg_view_entity_icon($group, 'small', $vars);
} else {
    $icon = elgg_view_entity_icon($group, 'medium', $vars);
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $group,
	'handler' => 'groups',
	'sort_by' => 'priority',
	'class' => 'list-inline',
));

if ($vars['full_view']) {
	echo elgg_view('groups/profile/summary', $vars);
} else if(!elgg_in_context('livesearch')){
	// brief view
	$params = array(
		'entity' => $group,
		'metadata' => $metadata,
	);

	$params = $params;
	$params = $params + $vars;
	$list_body = elgg_view('group/elements/summary', $params);

	echo elgg_view_image_block($icon, $list_body, $vars);
} else {
  $icon = elgg_view_entity_icon($group, 'medium', $vars);
  $body = $group->name;

  echo elgg_view_image_block($icon, $body, $vars);
}
