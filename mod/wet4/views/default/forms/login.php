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
if( _elgg_services()->session->get('language') == 'en') {//quick fix to display img on production
    $gcconnexGraphic = '<img src="'.$site_url.'mod/wet4/graphics/GCconnex_icon_slogan_Eng.png" alt="GCconnex. Connecting people and ideas." width="85%" class="mrgn-tp-sm">';
}else{
    $gcconnexGraphic = '<img src="'.$site_url.'mod/wet4/graphics/GCconnex_icon_slogan_Fra.png" alt="GCconnex. Branchez-vous, maximisez vos idées." width="85%" class="mrgn-tp-sm">';
}
if(elgg_in_context('login')){ //Nick - only show the graphic and register text on the main login page
?>

<div class="col-sm-6 clearfix login-engage-bg">
   <div class="col-sm-12 clearfix ">
    <?php 
        
        //echo '<div class="col-sm-2">'.$gcconnexGraphic.'</div>';
        echo '<div class="col-sm-12">'.elgg_format_element('div', array('class'=>'login-engage-message',), elgg_echo('wet:login_engage_0')) .'</div>';
        ?>

    </div> 


<div class="clearfix col-sm-12">

    <div>
        <?php //Nick - adding list of engaging things in the center of the login / landing page
            
            /*echo elgg_echo('gcconnex:registerText');*/ //Nick - This replaces the older register text
            $login_list_array = ['wet:login_engage_1','wet:login_engage_2','wet:login_engage_3'];
            foreach($login_list_array as $list_text){
                $contents .='<li><i class="fa fa-circle-o pull-left mrgn-rght-sm" aria-hidden="true"></i>'.elgg_echo($list_text) .'</li>';
            }
            
            echo elgg_format_element('ul', array('class'=>'login-engage-list'), $contents );
            
        ?>
    </div>
  

</div>
</div>
<?php }?>
<div class="col-sm-5 col-sm-offset-1 mrgn-bttm-md clearfix">
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
        <?php echo elgg_view('input/submit', array('value' => elgg_echo('login'), 'class' => 'btn-custom-cta mrgn-rght-sm',)); ?>
          <?php
          echo '<a href="' . $site_url . 'register" class="btn btn-default">'.elgg_echo('register').'</a>';
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



<?php
    //Nick - adding some stats to the bottom of the landing / login page (Should only appear on that page)
if(elgg_in_context('login')){
    $inside_stats =['<span class="login-big-num">3000+</span> Groups','<span class="login-big-num">174</span> Departments Across Canada','<span class="login-big-num">14,000</span> Discussion Happening Right Now'];
    foreach($inside_stats as $stat){
        $insides .='<div class="col-sm-4 text-center login-stats-child">'.$stat.'</div>';
    }
   
    $nextrow = elgg_format_element('div',array('class'=>'col-sm-6 col-sm-offset-3 mrgn-tp-lg login-stats',),$insides);

    echo elgg_format_element('div',array('class'=>'col-sm-12'),$nextrow);
}
?>
