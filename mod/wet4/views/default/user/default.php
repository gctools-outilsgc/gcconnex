<?php
/**
 * Elgg user display
 *
 * @uses $vars['entity'] ElggUser entity
 * @uses $vars['size']   Size of the icon
 * @uses $vars['title']  Optional override for the title
 */
 /*
 * GC_MODIFICATION
 * Description: Switched classes to bootstrap classes and display different metadata
 * Author: GCTools Team
 */
$entity = $vars['entity'];
$size = elgg_extract('size', $vars, 'small');

$icon = elgg_view_entity_icon($entity, $size, $vars);

$title = elgg_extract('title', $vars);
if (!$title) {
	$link_params = array(
		'href' => $entity->getUrl(),
		'text' => $entity->name,
	);

	// Simple XFN, see http://gmpg.org/xfn/
	if (elgg_get_logged_in_user_guid() == $entity->guid) {
		$link_params['rel'] = 'me';
	} elseif (check_entity_relationship(elgg_get_logged_in_user_guid(), 'friend', $entity->guid)) {
		$link_params['rel'] = 'friend';
	}

	$title = elgg_view('output/url', $link_params);
}

//Display group join date for group member list - Nick
if(elgg_in_context('groups_members')){
	$group_relationship = check_entity_relationship($entity->guid, 'member', elgg_get_page_owner_guid());
	$join_date = '<p style="padding-top:10px;">'.elgg_echo('group:member_date_joined'). ': ' .date("Y-m-d H:i", $group_relationship->time_created).'</p>';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $entity,
	'sort_by' => 'priority',
	'class' => 'list-inline mrgn-tp-sm elgg-menu-hz',
));

if (elgg_in_context('owner_block') || elgg_in_context('widgets')) {
	$metadata = '';
}

if (elgg_get_context() == 'gallery') {
	echo $icon;
} else {
	if ($entity->isBanned()) {
		$banned = elgg_echo('banned');
		$params = array(
			'entity' => $entity,
			'title' => $title,
			'metadata' => $metadata,
		);
	} else {
		$params = array(
			'entity' => $entity,
			'title' => $title,
			'metadata' => $metadata . $join_date,
			'subtitle' => $entity->job,
			'content' => elgg_view('user/status', array('entity' => $entity)),
		);
	}

	$list_body = elgg_view('user/elements/summary', $params);

	echo '<div class="panel"><div class="panel-body">' .elgg_view_image_block($icon, $list_body, $vars) .'</div></div>';
}
