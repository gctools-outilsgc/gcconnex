<?php

namespace AU\SubGroups;

$group = $vars['entity'];
$au_subgroup = get_input('au_subgroup', false);
$parent_guid = get_input('au_subgroup_parent_guid', false);
$parent = get_entity($parent_guid);

// determine if we are editing or adding a subgroup
if ($group && !$au_subgroup) {
	$parent = get_parent_group($group);

	if ($parent) {
		$au_subgroup = true;
		$parent_guid = $parent->guid;
	}
}

if ($au_subgroup) {

	echo elgg_view('input/hidden', array('name' => 'au_subgroups_parent_guid', 'value' => $parent_guid));

	if (elgg_get_plugin_setting('hidden_groups', 'groups') == 'yes') {
		// determine which visibility options there should be
		// always hidden = ACCESS_PRIVATE
		// and parent group = 'parent_group_acl'
		// using jquery to modify the select
		// subgroups can't be more visible than parent groups
		?>

		<script>
			$(document).ready(function() {
				$('.elgg-form-groups-edit select[name=vis]').prepend('<option value="parent_group_acl"><?php echo elgg_echo('au_subgroups:option:parent:members'); ?></option>');

		<?php
		if ($parent->access_id != ACCESS_PUBLIC) {
			// remove public access option 
			?>
					$('.elgg-form-groups-edit select[name=vis] option[value=<?php echo ACCESS_PUBLIC; ?>]').remove();
			<?php
		}
		?>

		<?php
		if ($parent->access_id != ACCESS_PUBLIC && $parent->access_id != ACCESS_LOGGED_IN) {
			// remove public access option 
			?>
					$('.elgg-form-groups-edit select[name=vis] option[value=<?php echo ACCESS_LOGGED_IN; ?>]').remove();
			<?php
		}
		?>

		<?php


	    // cyu -  06/15/2015: check if memcache is enabled on the server
		if (class_exists('Memcache')) {
			if ($group) {
				// cyu - 06/15/2015: the elgg doesn't look up the value from the database, it takes the value off of memcache which is not updated....
				$query = "SELECT access_id FROM ".elgg_get_config('dbprefix')."entities WHERE guid = {$group->guid}";
				$group_entity = get_data($query);
				$group_access_id = $group_entity[0]->access_id;
			}
		} else {
			$group_access_id = $group->access_id;
		}


		// set the selected option after options have been determined
		// public, logged in, and members only take care of themselves
		// need to forcefully switch on parent group acl
		// otherwise if we're adding a group default to most permisssive
		if (!$group) {
			?>
					$('.elgg-form-groups-edit select[name=vis] option:last').attr('selected', 'selected');
			<?php
		} elseif ($group->access_id == $parent->group_acl) {
			?>
					$('.elgg-form-groups-edit select[name=vis] option[value=parent_group_acl]').attr('selected', 'selected');
			<?php
		}
		?>
			});
		</script>

		<?php
	}
}
