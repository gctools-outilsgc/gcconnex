<?php
/**
 * show the group status (open/closed) below a group
 */

$group = elgg_get_page_owner_entity();

if (!empty($group) && ($group instanceof ElggGroup) && (elgg_get_plugin_setting("show_membership_mode", "group_tools") !== "no")) {
	if ($group->isPublicMembership()) {
		$status = elgg_echo("groups:open");
		$id = "group_tools_status_open";
	} else {
		$status = elgg_echo("groups:closed");
		$id = "group_tools_status_closed";
	}
	
	$status = ucfirst($status);
	
	?>
	<script type="text/javascript">
		$('div.groups-stats').append("<p id='<?php echo $id; ?>'><?php echo $status;?></p>");
	</script>
	<?php
}
