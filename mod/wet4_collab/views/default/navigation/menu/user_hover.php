<?php
/**
 * User hover menu
 *
 * Register for the 'register', 'menu:user_hover' plugin hook to add to the user
 * hover menu. There are three sections: action, default, and admin.
 *
 * @uses $vars['menu']      Menu array provided by elgg_view_menu()
 *
 * GC_MODIFICATION
 * Description: Changed the layout / grabs more profile info and department / admin options on hover 
 * Author: Your name email
 */

$user = $vars['entity'];
$actions = elgg_extract('action', $vars['menu'], null);
$main = elgg_extract('default', $vars['menu'], null);
$admin = elgg_extract('admin', $vars['menu'], null);

$site_url = elgg_get_site_url();

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
    <div class="row mrgn-lft-0 mrgn-rght-0 mrgn-tp-sm">
        <div class="col-xs-3">
            <?php
                //EW - change image output so badge displays
                echo elgg_view_entity_icon($user, 'medium', array('use_hover' => false, 'class' => 'pro-avatar', 'force_size' => true,));
            ?>
        </div>

        <div class="col-xs-9">
            <h4 class="mrgn-tp-sm mrgn-bttm-0">
            <?php
                $name_link = elgg_view('output/url', array(
                    'href' => $user->getURL(),
                    'text' => "<span class=\"elgg-heading-basic\">$user->name</span> &#64; $user->username",
                    'is_trusted' => true,
                    'style' => 'text-decoration:none;',
                ));
                echo "$name_link";
            ?>
            </h4>
            <div>
                <?php echo $email; ?>
            </div>
            <div style="max-width: 300px;"><?php echo $department; ?></div>
        </div>
    </div>

    <div class="panel-footer clearfix">
    <?php
        if($actions){
            foreach($actions as $menu_item){
                $itemName = $menu_item->getName();

                if($itemName == 'friend_request' || $itemName == 'add_friend' || $itemName == 'profile:edit'){
                    $item_class = 'btn btn-primary';
                } else {
                    $item_class = 'btn btn-default';
                }

                //change profile edit to my profile
                if($itemName == 'profile:edit'){
                    $menu_item->setText(elgg_echo('userMenu:profile'));
                    $menu_item->setHref('profile/' . $user->username);
                }

                if($itemName != 'reportuser'){
                    echo elgg_view('navigation/menu/elements/item', array(
                        'item' => $menu_item,
                        'item_class' => 'mrgn-rght-sm mrgn-bttm-sm ' . $item_class,
                    ));
                } else {
                    $reportUser = elgg_view('navigation/menu/elements/item', array(
                        'item' => $menu_item,
                        'item_class' => 'text-right',
                    ));
                }
            }
            echo $reportUser;
        }
    ?>
    </div>
</div>

<div>
    <?php
        // admin
        if( elgg_is_admin_logged_in() && $admin ){
            echo '<div class="panel-footer coll-' . $user->guid . '"><div class="text-center"><a  role="button" data-toggle="collapse" href="#adminoptions-' . $user->guid . '" aria-expanded="false" aria-controls="collapseExample">' . elgg_echo('gprofile:edit:admin') . ' <i class="fa fa-caret-down fa-lg"></i></a></div>';

            foreach($admin as $menu_item){
                $items .= elgg_view('navigation/menu/elements/item', array(
                            'item' => $menu_item,
                            'item_class' => 'mrgn-rght-sm mrgn-bttm-sm',
                        ));
            }
            echo '<div class="collapse" id="adminoptions-' . $user->guid . '">';
            echo elgg_format_element('ul', ['class' => 'list-inline', 'style' => 'max-width:450px; padding: 3px;'], $items);
            echo '</div></div>';
        }
    ?>

    <script>
        $('.coll-<?php echo $user->guid ?>').mouseover(function () {
            $('.collapse').collapse('show');
        }).mouseleave( function () {
            $('.collapse').collapse('hide');
        });
    </script>
</div>
