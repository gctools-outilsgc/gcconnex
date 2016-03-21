<?php
/**
 * Avatar cropping view
 *
 * @uses vars['entity']
 */

?>
<div id="" class="mtl ptm col-xs-12">
	<label><?php echo elgg_echo('avatar:crop:title'); ?></label>
	<br />
	<p>
		<?php echo elgg_echo("avatar:create:instructions"); ?>
	</p>
	<?php echo elgg_view_form('avatar/crop', array(), $vars); ?>
</div>
