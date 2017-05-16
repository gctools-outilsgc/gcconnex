<?php
/**
 * Elgg login form
 *
 * @package Elgg
 * @subpackage Core



 * Removed class: 'float-alt' from line 31
 */
 /*
 * GC_MODIFICATION
 * Description: Redesigned the login form
 * Author: GCTools Team
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

<div class="col-sm-6 clearfix">
   <div class="col-sm-4 clearfix ">
    <?php
    if( _elgg_services()->session->get('language') == 'en'){//quick fix to display img on production
        $gcconnexGraphic = '<img src="'.$site_url.'mod/wet4/graphics/GCconnex_icon_slogan_Eng.png" alt="GCconnex. Connecting people and ideas." class="mrgn-tp-md center-block">';
    }else{
        $gcconnexGraphic = '<img src="'.$site_url.'mod/wet4/graphics/GCconnex_icon_slogan_Fra.png" alt="GCconnex. Branchez-vous, maximisez vos idées." class="mrgn-tp-md center-block">';
    }

    echo $gcconnexGraphic;
        //echo '<div class="col-sm-2">'.$gcconnexGraphic.'</div>';
        //echo '<div class="col-sm-12">'.elgg_format_element('div', array('class'=>'login-engage-message',), elgg_echo('wet:login_engage_0')) .'</div>';
        ?>

    </div>


<div class="clearfix col-sm-8">

    <div>
        <?php //Nick - adding list of engaging things in the center of the login / landing page

            /*echo elgg_echo('gcconnex:registerText');*/ //Nick - This replaces the older register text
            $login_list_array = ['wet:login_engage_1','wet:login_engage_2','wet:login_engage_3'];
            foreach($login_list_array as $list_text){
                $contents .='<li><i class="fa fa-circle-o pull-left mrgn-rght-sm" aria-hidden="true"></i>'.elgg_echo($list_text) .'</li>';
            }

            echo elgg_format_element('ul', array('class'=>'login-engage-list center-block'), $contents );

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
		'autofocus' => 'true',
    'required' => 'required',
        'placeholder' => elgg_echo('loginusername'),
		));
	?>
</div>
<div class="mrgn-bttm-sm">
	<label for="password_home"><?php echo elgg_echo('password'); ?></label>
        <?php echo elgg_view('input/password', array('name' => 'password', 'id' => 'password_home', 'placeholder' => elgg_echo('password'), 'required' => 'required')); ?>
</div>

<?php echo elgg_view('login/extend', $vars); ?>


	<label class="mtm">
		<input type="checkbox" name="persistent" value="true" />
		<?php echo elgg_echo('user:persistent'); ?>
	</label>
	<div>
        <?php echo elgg_view('input/submit', array('value' => elgg_echo('login'), 'class' => 'btn-primary mrgn-rght-sm',)); ?>
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
global $CONFIG;
$dbprefix = elgg_get_config('dbprefix');
$query = "SELECT COUNT(guid) FROM {$dbprefix}groups_entity";

//stat tracking groups and discussions
$groups = get_data($query);
$discussions = elgg_get_entities(array('type' => 'object', 'subtype' => 'groupforumtopic', 'count' => true));

//Nick - adding some stats to the bottom of the landing / login page (Should only appear on that page)
if(elgg_in_context('login')){
    $inside_stats =['<span class="login-big-num">'.$groups[0]->{'COUNT(guid)'}.'</span> '.elgg_echo('groups'),elgg_echo('wet:login:departments'),elgg_echo('wet:login:discussions', array($discussions))];
    foreach($inside_stats as $stat){
        $insides .='<div class="col-sm-4 text-center login-stats-child">'.$stat.'</div>';
    }

    $nextrow = elgg_format_element('div',array('class'=>'col-sm-6 col-sm-offset-3 mrgn-tp-lg login-stats',),$insides);

    echo elgg_format_element('div',array('class'=>'col-sm-12'),$nextrow);
}
?>
