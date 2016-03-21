<?php
/**
 * Page icon
 *
 * Uses a separate icon view due to dependency on annotation
 *
 * @package ElggTasks
 *
 * @uses $vars['entity']
 * @uses $vars['annotation']
 */

$annotation = $vars['annotation'];
$entity = get_entity($annotation->entity_guid);

// Get size
if (!in_array($vars['size'], array('small', 'medium', 'large', 'tiny', 'master', 'topbar'))) {
	$vars['size'] = "medium";
}


// Ajout Fx pour traiter la cas ou pas d'annotations (ce qui est curieux en fait)
if ($annotation) {
?>

<a href="<?php echo $annotation->getURL(); ?>">
	<img src="<?php echo $entity->getIconURL($vars['size']); ?>" />
</a>
<?php } ?>