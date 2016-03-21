<?php
/**
 * Elgg login form
 *
 * @package Elgg
 * @subpackage Core
 
 
 
 * Removed class: 'float-alt' from line 31
 */

$site_url = elgg_get_site_url();
//english or french graphic to display
if( _elgg_services()->session->get('language') == 'en'){//quick fix to display img on production
    $gcconnexGraphic = '<img src="'.$site_url.'mod/wet4/graphics/GCconnex_icon_slogan_Eng.png" alt="GCconnex. Connecting people and ideas." width="85%" class="mrgn-tp-sm">';
}else{
    $gcconnexGraphic = '<img src="'.$site_url.'mod/wet4/graphics/GCconnex_icon_slogan_Fra.png" alt="GCconnex. Branchez-vous, maximisez vos idées." width="85%" class="mrgn-tp-sm">';;
}

?>
<div class="col-sm-2">
    <?php echo $gcconnexGraphic;?>

</div>
<div class="col-sm-4  clearfix">

    <div>
        <?php echo elgg_echo('gcconnex:registerText');?>
    </div>

</div>
<div class="col-sm-5 col-sm-offset-1  mrgn-bttm-md clearfix">
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
        <?php echo elgg_view('input/submit', array('value' => elgg_echo('login'), 'class' => 'btn-custom-cta mrgn-rght-lg',)); ?>
          <?php
        echo '<a href="' . $site_url . 'register" class="btn btn-custom">'.elgg_echo('register').'</a>';
        ?>
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

    echo '<a href="' . $site_url . 'forgotpassword" class="col-xs-12 mrgn-tp-md">'.elgg_echo('user:forgot').'</a>';
?>
</div>


