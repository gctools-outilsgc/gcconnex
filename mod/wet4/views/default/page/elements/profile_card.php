<?php 
$site_url = elgg_get_site_url();
$user = get_loggedin_user()->username;
$displayName = get_loggedin_user()->name;
$user_avatar = get_loggedin_user()->geticonURL('medium');
$email = get_loggedin_user()->email;

$department = get_loggedin_user()->get('department');
?>


<div class="clearfix mrgn-bttm-sm">
    <div class="row mrgn-lft-0 mrgn-rght-sm">
    <div class="col-xs-4">

        <div class="mrgn-tp-sm">
            <?php 
                //EW - change to display new badge
            echo elgg_view_entity_icon(elgg_get_logged_in_user_entity(), 'medium', array('use_hover' => false, 'class' => 'pro-avatar', 'force_size' => true,)); 
                ?>
           </div>
    </div>


    <div class="col-xs-8">
        <h4 class="mrgn-tp-sm mrgn-bttm-0"><?php echo $displayName?></h4>
        <div><?php echo  $email ?></div>
        <div><?php echo $department; ?></div>
        <a href="<?php echo  $site_url ?>profile/<?php echo  $user ?>" class="btn btn-primary mrgn-tp-sm" style='color:white;'><?php echo elgg_echo('userMenu:profile') ?></a>
    </div>
    </div>
    
</div>

<div class="panel-footer clearfix">
    <a href="<?php echo  $site_url ?>settings/user/<?php echo $user ?>" class="btn btn-default mrgn-tp-sm pull-left"><?php echo elgg_echo('userMenu:account') ?></a>
    <a href="<?php echo  $site_url ?>action/logout" class="btn btn-default mrgn-tp-sm pull-right"><?php echo elgg_echo('logout') ?></a>
</div>