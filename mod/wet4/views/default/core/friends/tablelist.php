<?php
/**
 * Elgg friends picker
 * Lists the friends picker
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['entities'] The array of ElggUser objects
 *
 * GC_MODIFICATION
 * Description: Added wet styling and classes 
 * Author: GCTools Team
 */

if (is_array($vars['entities'])) {

?>

<table cellspacing="0" id="friendspicker-members-table">
	<tr>
		<?php
		$column = 0;
		foreach($vars['entities'] as $entity) {
			if (!($entity instanceof ElggEntity)) {
				$entity = get_entity($entity);
			}

			if ($entity instanceof ElggEntity) {
				?>
				<td style="width:25px;">
                    <div class="mrgn-tp-sm">
                        <div style="width: 25px;" class="mbl mrgn-lft-sm">
                            <?php echo elgg_view_entity_icon($entity, 'tiny'); ?>
                        </div>
                    </div>
				</td>
				<td style="width: 200px;" class="pas">
					<?php echo $entity->name; ?>
				</td>
				<?php
				$column++;
				if ($column == 3) {
					echo "</tr><tr>";
					$column = 0;
				}
			}
		}

if ($column < 3 && $column != 0) echo "</tr>";
	echo "</table>";
}

if (isset($vars['content'])) {
	echo $vars['content'];
}