<?php
/**
 * Avatar upload view
 *
 * @uses $vars['entity']
 */

 //EW - converting user avatar to elgg view entity icon to display new Ambassador Badge

//display avatar with badge
$user_avatar = elgg_view_entity_icon($vars['entity'], 'large', array('use_hover' => false));

$current_label = elgg_echo('avatar:current');

$remove_button = '';
if ($vars['entity']->icontime) {

}

?>


<h2>
    <?php echo elgg_echo('onboard:profile:five:title'); echo elgg_view('page/elements/step_counter', array('current_step'=>6, 'total_steps'=>6, 'class' => 'mrgn-tp-md wb-inv'));?>
</h2>
<div class="mrgn-bttm-md onboarding-cta-holder">
    <?php echo elgg_echo('onboard:profile:avatar:why');?>

</div>

    <div id="infoCard" class="panel panel-custom mrgn-tp-md mrgn-bttm-md">

        <?php echo elgg_view('profileStrength/infoCard', array('noJava' => 1)); ?>


    </div>

	<?php //echo elgg_echo('avatar:upload:instructions');
$form_params = array('enctype' => 'multipart/form-data');
$upload_form = elgg_view_form('onboard/upload', $form_params, $vars);

$image = <<<HTML
<div id="" class="mrl prl">
	<label>$current_label</label><br />
	$user_avatar
</div>
$remove_button
HTML;

$body = <<<HTML
<div id="" class="mrgn-bttm-md">

    $upload_form
</div>
HTML;

echo $body;

?>
