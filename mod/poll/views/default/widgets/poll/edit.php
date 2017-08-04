<?php
/**
 * Elgg Poll plugin
 * @package Elggpoll
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @Original author John Mellberg
 * website http://www.syslogicinc.com
 * @Modified By Team Webgalli to work with ElggV1.5
 * www.webgalli.com or www.m4medicine.com
 */
?>

<p>
	<?php echo elgg_echo('poll:widget:label:displaynum'); ?>

	<select name="params[limit]">
		<option value="1" <?php if($vars['entity']->num_display == 1) echo "SELECTED"; ?>>1</option>
		<option value="2" <?php if($vars['entity']->num_display == 2) echo "SELECTED"; ?>>2</option>
		<option value="3" <?php if($vars['entity']->num_display == 3) echo "SELECTED"; ?>>3</option>
		<option value="4" <?php if($vars['entity']->num_display == 4) echo "SELECTED"; ?>>4</option>
		<option value="5" <?php if($vars['entity']->num_display == 5) echo "SELECTED"; ?>>5</option>
		<option value="10" <?php if($vars['entity']->num_display == 10) echo "SELECTED"; ?>>10</option>
		<option value="15" <?php if($vars['entity']->num_display == 15) echo "SELECTED"; ?>>15</option>
		<option value="20" <?php if($vars['entity']->num_display == 20) echo "SELECTED"; ?>>20</option>
	</select>
</p>