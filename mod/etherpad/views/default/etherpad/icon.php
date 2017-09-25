<?php
/**
 * Doc icon
 *
 * Uses a separate icon view due
 *
 * @package ElggPad
 *
 * @uses $vars['entity']
 */

$entity = elgg_extract('entity', $vars, false);

if(!$entity){
	return false;
}

// Get size
if (!in_array($vars['size'], array('small', 'medium', 'large', 'tiny', 'master', 'topbar'))) {
	$vars['size'] = "medium";
}

?>

<a href="<?php echo $entity->getURL(); ?>">
	<img src="<?php echo $entity->getIconURL($vars['size']); ?>" />
</a>
