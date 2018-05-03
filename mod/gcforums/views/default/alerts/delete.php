<?php

$entity = $vars['entity'];
$is_menu_buttons = $vars['is_menu_buttons'];
$delete_title = elgg_echo('gcforums:delete:heading');
$delete_content = elgg_echo('gcforums:delete:body', array(elgg_echo("gcforums:translate:{$entity->getSubtype()}")));
$delete_button = elgg_echo('gcforums:delete:delete');
$cancel_button = elgg_echo('gcforums:delete:cancel');

$url = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/gcforums/delete?guid={$entity->getGUID()}");
$delete = "<a style='color:white; text-decoration:none;' href='{$url}'>{$delete_button}</a>";
$button_size = ($is_menu_buttons) ? "" : "btn-sm";

?>

<button type="button" class="btn btn-danger <?php echo $button_size; ?>" data-toggle="modal" data-target="#myModal-<?php echo $entity->guid; ?>"><?php echo $delete_button; ?></button>

<div id="myModal-<?php echo $entity->guid; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><?php echo $delete_title; ?></h4>
			</div>
			<div class="modal-body">
				<p>
					<?php echo $delete_content . " '{$entity->title}'"; ?>
				</p>
			</div>
			<div class="modal-footer">
				<a href="<?php echo $url; ?>"><button id="btnDeleteEntity" type="button" class="btn btn-danger <?php echo $button_size; ?>" data-toggle="modal" data-target="#myModal"><?php echo $delete_button; ?></button></a>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $cancel_button; ?></button>
			</div>
		</div>
	</div>
</div>

<style>

.modal-footer {
	text-align: center;
}
.modal {
	display: none; /* Hidden by default */
	position: fixed; /* Stay in place */
	z-index: 99; /* Sit on top */
	left: 0;
	top: 0;
	width: 100%; /* Full width */
	height: 100%; /* Full height */
	overflow: auto; /* Enable scroll if needed */
	background-color: rgb(0,0,0); /* Fallback color */
	background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	text-align: center;
}
</style>
