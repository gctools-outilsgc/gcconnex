<?php
/**
 * Create friend river view
 */
$item = $vars['item'];
/* @var ElggRiverItem $item */

$subject = $item->getSubjectEntity();
$object = $item->getObjectEntity();

$subject_icon = elgg_view_entity_icon($subject, 'small');
$object_icon = elgg_view_entity_icon($object, 'small');

echo elgg_view('river/elements/layout', array(
	'item' => $item,
	'attachments' => $subject_icon . '<i class="fa fa-exchange fa-2x icon-unsel mrgn-lft-sm mrgn-rght-sm"></i>' . $object_icon,
));
