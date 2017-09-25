<?php
/**
 * Elgg login form
 *
 * @package Elgg
 * @subpackage Core
 */

$site_url = elgg_get_site_url();

//english or french graphic to display
if( _elgg_services()->session->get('language') == 'en'){//quick fix to display img on production
    $gccollabGraphic = '<img src="'.$site_url.'mod/wet4_collab/graphics/GCcollab_icon_slogan_Eng.png" alt="GCcollab. Shaping the Future of Canada." width="85%" class="mrgn-tp-sm">';
} else {
    $gccollabGraphic = '<img src="'.$site_url.'mod/wet4_collab/graphics/GCcollab_icon_slogan_Fra.png" alt="GCcollab. Façonner l\'avenir du Canada." width="85%" class="mrgn-tp-sm">';
}

if( elgg_in_context('login') ): ?>
    <div class="col-sm-2">
        <?php echo $gccollabGraphic; ?>
    </div>
    <div class="col-sm-4 clearfix">
        <?php echo elgg_echo('gcconnex:registerText');?>
    </div>
<?php endif; ?>

<div class="col-sm-5 col-sm-offset-1 mrgn-bttm-md clearfix">
    <div>
    	<label for="username_home"><?php echo elgg_echo('loginusername'); ?></label>
    	<?php
            echo elgg_view('input/text', array(
        		'name' => 'username',
                'id' => 'username_home',
        		'autofocus' => 'true',
                'required' => 'required',
                'placeholder' => elgg_echo('loginusername'),
        	));
        ?>
    </div>
    <div class="mrgn-bttm-sm">
    	<label for="password_home"><?php echo elgg_echo('password'); ?></label>
        <?php
            echo elgg_view('input/password', array(
                'name' => 'password',
                'id' => 'password_home',
                'required' => 'required',
                'placeholder' => elgg_echo('password'),
            ));
        ?>
    </div>

    <?php echo elgg_view('login/extend', $vars); ?>

	<label class="mtm">
		<input type="checkbox" name="persistent" value="true" />
		<?php echo elgg_echo('user:persistent'); ?>
	</label>
	<div>
        <?php
            echo elgg_view('input/submit', array('value' => elgg_echo('login'), 'class' => 'btn-primary mrgn-rght-sm'));
            echo '<a href="' . $site_url . 'register" class="btn btn-custom">'.elgg_echo('register').'</a>';
        ?>
    </div>

	<?php
        if( isset($vars['returntoreferer']) ){
            echo elgg_view('input/hidden', array('name' => 'returntoreferer', 'value' => 'true'));
        }
        echo '<a href="' . $site_url . 'forgotpassword" class="col-xs-12 mrgn-tp-md">'.elgg_echo('user:forgot').'</a>';
    ?>
</div>
