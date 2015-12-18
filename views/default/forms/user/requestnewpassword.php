<?php
/**
 * Elgg forgotten password.
 *
 * @package Elgg
 * @subpackage Core
 *
 *Add username1 for accessibility, without 1, its not working
 */
?>

<div class="mtm">
	<?php echo elgg_echo('user:password:text'); ?>
</div>
<div>
	<label for='username1'><?php echo elgg_echo('loginusername'); ?></label>
	<?php echo elgg_view('input/text', array(
		'name' => 'username1',
		'autofocus' => true,
     'id' => 'username1',
		));
	?>
</div>
<br/>
<?php echo elgg_view('input/captcha'); ?>
<div class="elgg-foot">
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('request'))); ?>
</div><br/>
