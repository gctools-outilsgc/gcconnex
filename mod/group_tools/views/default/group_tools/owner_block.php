<?php

/**
 * Group Tools
 *
 * show the group status (open/closed) in the owner block of the group
 *
 * @author ColdTrick IT Solutions
 * 
 */

$group = elgg_get_page_owner_entity();
if (!($group instanceof ElggGroup) || (elgg_get_plugin_setting('show_membership_mode', 'group_tools') === 'no')) {
	return;
}

if ($group->isPublicMembership()) {
	$status = elgg_echo('groups:open');
	$class = 'group-tools-status-open';
} else {
	$status = elgg_echo('groups:closed');
	$class = 'group-tools-status-closed';
}

$status = ucfirst($status);

?>
<script type='text/javascript'>
	require(['jquery'], function($) {
		$('div.elgg-owner-block div.elgg-image-block > .elgg-body').append('<div class="<?php echo $class; ?>"><?php echo $status;?></div>');
	});
</script>
