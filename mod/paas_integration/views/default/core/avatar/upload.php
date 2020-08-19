<?php
/**
 * Avatar upload view
 *
 * @uses $vars['entity']
 *
 * GC_MODIFICATION
 * Description: Adding avatar badge support / wet and bootstrap classes
 * Author: GCTools Team
 */

//display avatar with badge
$user_avatar = elgg_view_entity_icon($vars['entity'], 'large', array('use_hover' => false));

$current_label = elgg_echo('avatar:current');

$form_params = array('enctype' => 'multipart/form-data');
$upload_form = elgg_view_form('avatar/upload', $form_params, $vars);

?>

<p class="mtm">
	<?php echo elgg_echo('avatar:upload:instructions'); ?>
</p>

<?php

$image = <<<HTML
<div id="" class="mrl prl">
	<label>$current_label</label><br />
	$user_avatar
</div>
HTML;

$body = <<<HTML
<div id="">
	$upload_form
</div>
HTML;

//echo elgg_view_image_block($image, $upload_form);


echo '<div class="col-sm-4 col-xs-12">' . $image . '</div>';
echo '<div class="col-sm-8 col-xs-12">' . $body . '</div>';