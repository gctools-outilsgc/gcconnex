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
<div class="col-sm-5 mrgn-bttm-md clearfix">
<div>
	<label for="username_home"><?php echo elgg_echo('loginusername'); ?></label>
	<?php echo elgg_view('input/text', array(
		'name' => 'username',
        'id' => 'username_home',
		'autofocus' => true,
        'placeholder' => elgg_echo('loginusername'),
		));
	?>
</div>
<div class="mrgn-bttm-sm">
	<label for="password_home"><?php echo elgg_echo('password'); ?></label>
        <?php echo elgg_view('input/password', array('name' => 'password', 'id' => 'password_home', 'placeholder' => elgg_echo('password'))); ?>
</div>

<?php echo elgg_view('login/extend', $vars); ?>


	<label class="mtm">
		<input type="checkbox" name="persistent" value="true" />
		<?php echo elgg_echo('user:persistent'); ?>
	</label>
	<div>
        <?php echo elgg_view('input/submit', array('value' => elgg_echo('login'), 'class' => 'btn-custom-cta',)); ?>
    </div>
	
	
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

<div class="col-sm-6 col-sm-offset-1 clearfix">

    <div>
        <?php echo elgg_echo('gcconnex:registerText');?> </div>


    <div class="text-center">
        <?php
        echo '<a href="' . $site_url . 'register" class="btn btn-custom">'.elgg_echo('register').'</a>';
        ?>
    </div>
</div>
