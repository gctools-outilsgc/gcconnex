<?php
/**
 * Avatar upload view
 *
 * @uses $vars['entity']
 */

$user_avatar = elgg_view('output/img', array(
	'src' => $vars['entity']->getIconUrl('large'),
	'alt' => elgg_echo('avatar'),
));

$current_label = elgg_echo('avatar:current');

$remove_button = '';
if ($vars['entity']->icontime) {
	$remove_button = elgg_view('output/url', array(
		'text' => elgg_echo('remove'),
		'title' => elgg_echo('avatar:remove'),
		'href' => 'action/avatar/remove?guid=' . elgg_get_page_owner_guid(),
		'is_action' => true,
		'class' => 'elgg-button elgg-button-cancel mrgn-lft-sm',
	));
}

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
$remove_button
HTML;

$body = <<<HTML
<div id="">
	$upload_form
</div>
HTML;

//echo elgg_view_image_block($image, $upload_form);


echo '<div class="col-sm-4 col-xs-12">' . $image . '</div>';
echo '<div class="col-sm-8 col-xs-12">' . $body . '</div>';