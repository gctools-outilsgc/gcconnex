<?php

/**
 * Group edit form
 *
 * This view contains everything related to group access.
 * eg: how can people join this group, who can see the group, etc
 *
 * @package ElggGroups
 */

$entity = elgg_extract("entity", $vars, false);
$membership = elgg_extract("membership", $vars);
$visibility = elgg_extract("vis", $vars);
$owner_guid = elgg_extract("owner_guid", $vars);
$content_access_mode = elgg_extract("content_access_mode", $vars);

?>
<div class="form-group">
	<label for="groups-membership"><?php echo elgg_echo("groups:membership"); ?></label>
	<?php echo elgg_view("input/select", array(
		"name" => "membership",
		"id" => "groups-membership",
		"value" => $membership,
		"options_values" => array(
			ACCESS_PRIVATE => elgg_echo("groups:access:private"),
			ACCESS_PUBLIC => elgg_echo("groups:access:public"),
		)
	));
	?>
</div>

<?php if (elgg_get_plugin_setting("hidden_groups", "groups") == "yes"): ?>
	<div class="form-group">
		<label for="groups-vis"><?php echo elgg_echo("groups:visibility"); ?></label>
		<?php
		$visibility_options =  array(
			ACCESS_PRIVATE => elgg_echo("groups:access:group"),
			ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN"),
			ACCESS_PUBLIC => elgg_echo("PUBLIC"),
		);
		if (elgg_get_config("walled_garden")) {
			unset($visibility_options[ACCESS_PUBLIC]);
		}
		
		echo elgg_view("input/access", array(
			"name" => "vis",
			"id" => "groups-vis",
			"value" => $visibility,
			"options_values" => $visibility_options,
			'entity' => $entity,
			'entity_type' => 'group',
			'entity_subtype' => '',
		));
		?>
	</div>
<?php endif; ?>

<?php

$access_mode_params = array(
	"name" => "content_access_mode",
	"id" => "groups-content-access-mode",
	"value" => $content_access_mode,
	"options_values" => array(
		ElggGroup::CONTENT_ACCESS_MODE_UNRESTRICTED => elgg_echo("groups:content_access_mode:unrestricted"),
		ElggGroup::CONTENT_ACCESS_MODE_MEMBERS_ONLY => elgg_echo("groups:content_access_mode:membersonly"),
	)
);

if ($entity) {
	// Disable content_access_mode field for hidden groups because the setting
	// will be forced to members_only regardless of the entered value
	if ($entity->access_id === $entity->group_acl) {
		$access_mode_params['disabled'] = 'disabled';
	}
}
?>
<div class="form-group">
	<label for="groups-content-access-mode"><?php echo elgg_echo("groups:content_access_mode"); ?></label>
	<?php
		echo elgg_view("input/select", $access_mode_params);

		if ($entity && $entity->getContentAccessMode() == ElggGroup::CONTENT_ACCESS_MODE_UNRESTRICTED) {
			// Warn the user that changing the content access mode to more
			// restrictive will not affect the existing group content
			$access_mode_warning = elgg_echo("groups:content_access_mode:warning");
			echo "<span class='elgg-text-help'>$access_mode_warning</span>";
		}
	?>
</div>

<?php

if ($entity && ($owner_guid == elgg_get_logged_in_user_guid() || elgg_is_admin_logged_in())) {
	$members[$owner_guid] = get_entity($owner_guid)->name ."  (@". get_entity($owner_guid)->username .")";
	?>

	<div class="form-group">
		<label for="groups-owner-guid"><?php echo elgg_echo("groups:owner"); ?></label>
		<?php
			echo elgg_view("input/text", array(
				"id" => "groups-owner-guid",
				"value" =>  get_entity($owner_guid)->name,
			));

			echo elgg_view("input/select", array(
				"name" => "owner_guid",
				"id" => "groups-owner-guid-select",
				"value" =>  $owner_guid,
				"options_values" => $members,
				"class" => "groups-owner-input hidden",
			));

			$vars = array(
				'class' => 'mentions-popup hidden',
				'id' => 'groupmems-popup',
			);

			echo elgg_view_module('popup', '', elgg_view('graphics/ajax_loader', array('hidden' => false)), $vars);

			if ($owner_guid == elgg_get_logged_in_user_guid()) {
				echo "<span class='elgg-text-help'>" . elgg_echo("groups:owner:warning") . "</span>";
			}
		?>
	</div>
<?php
}
