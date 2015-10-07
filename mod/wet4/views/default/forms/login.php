<?php
/**
 * Elgg login form
 *
 * @package Elgg
 * @subpackage Core
 
 
 
 * Removed class: 'float-alt' from line 31
 */

$site_url = elgg_get_site_url();
?>
<div class="col-sm-6 mrgn-bttm-md clearfix">
<div>
	<label><?php echo elgg_echo('loginusername'); ?></label>
	<?php echo elgg_view('input/text', array(
		'name' => 'username',
		'autofocus' => true,
        'placeholder' => 'Username or Email',
		));
	?>
</div>
<div>
	<label><?php echo elgg_echo('password'); ?></label>
	<?php echo elgg_view('input/password', array('name' => 'password', 'placeholder' => 'Password')); ?>
</div>

<?php echo elgg_view('login/extend', $vars); ?>


	<label class="mtm">
		<input type="checkbox" name="persistent" value="true" />
		<?php echo elgg_echo('user:persistent'); ?>
	</label>
	
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('login'), 'class' => 'btn-custom-cta',)); ?>
	
	<?php 
	if (isset($vars['returntoreferer'])) {
		echo elgg_view('input/hidden', array('name' => 'returntoreferer', 'value' => 'true'));
	}
	?>

	<?php
    /*
	echo elgg_view_menu('login', array(
		'sort_by' => 'priority',
		'class' => 'elgg-menu-general elgg-menu-hz mtm',
	));
    */

    echo '<a href="' . $site_url . 'forgotpassword" class="col-xs-12 mrgn-tp-md">Forgot your password?</a>';
?>
</div>

<div class="col-sm-6 clearfix">
    
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur pulvinar scelerisque ligula in imperdiet.</p>
    <hr>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur pulvinar scelerisque ligula in imperdiet.</p>

    <div class="text-center">
        <?php
        echo '<a href="' . $site_url . 'register" class="btn btn-custom">Register</a>';
        ?>
    </div>
</div>
