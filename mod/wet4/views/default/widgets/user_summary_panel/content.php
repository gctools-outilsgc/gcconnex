<?php
        /***********************************************************************
 * MODIFICATION LOG
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 *
 * USER 		DATE 			DESCRIPTION
 * MBlondin 	2016-03-11 		Creation of widget

 ***********************************************************************/
try{
   
    $user_guid = elgg_get_logged_in_user_guid();
    $site_url = elgg_get_site_url();
    $num_group = count(get_users_membership($user_guid));
    $title=get_user($user_guid)->job;
    $dept=get_user($user_guid)->department;
    $dipName=get_user($user_guid)->getDisplayName();
    $avatar=get_user($user_guid)->getIcon('medium');
    $Uname=get_user($user_guid)->username;
    $NumFriends=count(get_user_friends($user_guid));

?>
<div class="col-xs-12 col-md-12 col-lg-12 panel">
    <div class="col-lg-2 elgg-avatar elgg-avatar-medium-wet4">
        <img src="<?php echo $avatar;?>" />
    </div>
    <div class="col-lg-7 brdr-rght">
        <h2 class="h2"><?php echo $dipName;?></h2>
        <p class="text-muted"><?php echo $title . ' at '.$dept?></p>
        <a href="<?php echo $site_url. 'profile/'. $Uname?>" alt="Avatar of <?php echo $dipName;?>" class="btn btn-primary btn-sm mrgn-bttm-sm">Improve your profile</a>
    </div>
    <div class="col-lg-3">
        <small><p class="brdr-bttm">You are a member of <a href="<?php echo $site_url. '/groups/all?filter=yours'?>"><?php echo $num_group?></a> groups.</p>
        <p><?php echo $NumFriends;?> connections. <a href="<?php echo $site_url. '/members/popular'?>" >Grow your network.</a></p></small>
    </div>
    </div>

<?php
}
catch (Exception $e)
{
}
?>