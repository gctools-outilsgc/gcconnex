<?php

namespace AU\SubGroups;

if ($vars['subgroup_guid']) {
  $subgroup_guid = $vars['subgroup_guid'];
  $subgroup = get_entity($subgroup_guid);
}
else {
  $subgroup = elgg_get_page_owner_entity();
}

elgg_require_js('au_subgroups/edit');

$dbprefix = elgg_get_config('dbprefix');

$options = array(
	'type' => 'group',
	'limit' => 10,
	'joins' => array("JOIN {$dbprefix}groups_entity g ON e.guid = g.guid")
);

if (empty($vars['q'])) {
  $options['order_by'] = "g.name ASC";
}
else {
  $query = sanitize_string($vars['q']);
  $options['wheres'][] = "g.name LIKE '{$query}%'";
}

$groups = elgg_get_entities($options);


elgg_push_context('widgets'); // use widgets context so no entity menu is used
if ($groups) {
  echo '<div class="au-subgroups-result-col">';
  
  for ($i=0; $i<count($groups); $i++) {
	// break results into 2 columns of 5
	if ($i == 5) {
	  echo '</div>';
	  echo '<div class="au-subgroups-result-col">';
	}
	
	if (can_move_subgroup($subgroup, $groups[$i])) {
	  $class = 'au-subgroups-parentable';
	}
	else {
	  $class = 'au-subgroups-non-parentable';
	}
	
	
	$action_url = elgg_get_site_url() . 'action/au_subgroups/move?parent_guid=' . $groups[$i]->guid;
	$action_url = elgg_add_action_tokens_to_url($action_url);
	echo "<div class=\"{$class}\" data-action=\"{$action_url}\">";
	echo elgg_view_entity($groups[$i], array('full_view' => false));
	echo "</div>";
  }
  
  echo '</div>';
}
else {
  echo elgg_echo('au_subgroups:search:noresults');
}
elgg_pop_context();
