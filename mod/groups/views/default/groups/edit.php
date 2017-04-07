<?php
/**
 * Edit/create a group wrapper
 *
 * @uses $vars['entity'] ElggGroup object
 */

$entity = elgg_extract('entity', $vars, null);

$form_vars = array(
	'enctype' => 'multipart/form-data',
	'class' => 'elgg-form-alt',
);

echo "<div class='wet-boew-formvalid wb-frmvld mrgn-tp-md'>";
echo elgg_view_form('groups/edit', $form_vars, groups_prepare_form_vars($entity));
echo "</div>";