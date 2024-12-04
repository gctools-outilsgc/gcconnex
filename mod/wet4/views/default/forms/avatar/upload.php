<?php
/**
 * Avatar upload form
 *
 * @uses $vars['entity']
 */
 /*
 * GC_MODIFICATION
 * Description: Added accessible labels
 * Author: GCTools Team
 */
?>
<div>
	<label for="avatar"><?php echo elgg_echo("avatar:upload"); ?></label><br />
    <?php echo elgg_view("input/file",array('name' => 'avatar', 'id' => 'avatar','required '=> "required")); ?>
</div>
<div class="elgg-foot mrgn-tp-md">
	<?php echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['entity']->guid)); ?>
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('upload'))); ?>
</div>
