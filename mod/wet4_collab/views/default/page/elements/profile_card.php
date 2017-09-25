<?php
/*
 * profile_card.php
 * 
 * Formats the users information and the logout / settings buttons into the profile card. This drops down from the user menu
 * 
 * @package wet4
 * @author GCTools Team
 */

$site_url = elgg_get_site_url();
$user = elgg_get_logged_in_user_entity();
$username = $user->username;
$displayName = $user->name;
$user_avatar = $user->geticonURL('medium');
$email = $user->email;

$userType = $user->user_type;
// if user is public servant
if( $userType == 'federal' ){
    $deptObj = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => 'federal_departments',
    ));
    $depts = get_entity($deptObj[0]->guid);

    $federal_departments = array();
    if (get_current_language() == 'en'){
        $federal_departments = json_decode($depts->federal_departments_en, true);
    } else {
        $federal_departments = json_decode($depts->federal_departments_fr, true);
    }

    $department = $federal_departments[$user->federal];

// otherwise if user is student or academic
} else if( $userType == 'student' || $userType == 'academic' ){
    $institution = $user->institution;
    $department = ($institution == 'university') ? $user->university : ($institution == 'college' ? $user->college : $user->highschool);

// otherwise if user is provincial employee
} else if( $userType == 'provincial' ){
    $provObj = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => 'provinces',
    ));
    $provs = get_entity($provObj[0]->guid);

    $provinces = array();
    if (get_current_language() == 'en'){
        $provinces = json_decode($provs->provinces_en, true);
    } else {
        $provinces = json_decode($provs->provinces_fr, true);
    }

    $minObj = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => 'ministries',
    ));
    $mins = get_entity($minObj[0]->guid);

    $ministries = array();
    if (get_current_language() == 'en'){
        $ministries = json_decode($mins->ministries_en, true);
    } else {
        $ministries = json_decode($mins->ministries_fr, true);
    }

    $department = $provinces[$user->provincial];
    if($user->ministry && $user->ministry !== "default_invalid_value"){ $department .= ' / ' . $ministries[$user->provincial][$user->ministry]; }

// otherwise show basic info
} else {
    $department = $user->$userType;
}
?>

<div class="clearfix mrgn-bttm-sm">
    <div class="row mrgn-lft-0 mrgn-rght-sm">
        <div class="col-xs-4">
            <div class="mrgn-tp-sm">
            <?php 
                //EW - change to display new badge
                echo elgg_view_entity_icon($user, 'medium', array('use_hover' => false, 'class' => 'pro-avatar', 'force_size' => true,)); 
            ?>
            </div>
        </div>

        <div class="col-xs-8">
            <h4 class="mrgn-tp-sm mrgn-bttm-0"><?php echo $displayName; ?></h4>
            <div><?php echo $email; ?></div>
            <div><?php echo $department; ?></div>
            <a href="<?php echo $site_url; ?>profile/<?php echo $username; ?>" class="btn btn-primary mrgn-tp-sm" style='color: white;'><?php echo elgg_echo('userMenu:profile') ?></a>
        </div>
    </div>
    
</div>

<div class="panel-footer clearfix">
    <a href="<?php echo $site_url ?>settings/user/<?php echo $username; ?>" class="btn btn-default mrgn-tp-sm pull-left"><?php echo elgg_echo('userMenu:account') ?></a>
    <a href="<?php echo $site_url ?>action/logout" class="btn btn-default mrgn-tp-sm pull-right"><?php echo elgg_echo('logout') ?></a>
</div>
