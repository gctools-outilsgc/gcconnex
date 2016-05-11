<?php
/**
 * User hover menu
 *
 * Register for the 'register', 'menu:user_hover' plugin hook to add to the user
 * hover menu. There are three sections: action, default, and admin.
 *
 * @uses $vars['menu']      Menu array provided by elgg_view_menu()
 */

$user = $vars['entity'];
$actions = elgg_extract('action', $vars['menu'], null);
$main = elgg_extract('default', $vars['menu'], null);
$admin = elgg_extract('admin', $vars['menu'], null);



/*
 * 
 * Previous Hover Menu
echo '<ul class="elgg-menu elgg-menu-hover hover-custom">';

// name and username
$name_link = elgg_view('output/url', array(
	'href' => $user->getURL(),
	'text' => "<span class=\"elgg-heading-basic\">$user->name</span>&#64;$user->username",
	'is_trusted' => true,
));
echo "<li>$name_link</li>";

// actions
if (elgg_is_logged_in() && $actions) {
	echo '<li>';
	echo elgg_view('navigation/menu/elements/section', array(
		'class' => "elgg-menu elgg-menu-hover-actions",
		'items' => $actions,
	));
	echo '</li>';
}

// main
if ($main) {
	echo '<li>';
	
	echo elgg_view('navigation/menu/elements/section', array(
		'class' => 'elgg-menu elgg-menu-hover-default',
		'items' => $main,
	));
	
	echo '</li>';
}

// admin
if (elgg_is_admin_logged_in() && $admin) {
	echo '<li>';
	
	echo elgg_view('navigation/menu/elements/section', array(
		'class' => 'elgg-menu elgg-menu-hover-admin',
		'items' => $admin,
	));
	
	echo '</li>';
}

echo '</ul>';
*/

$site_url = elgg_get_site_url();

$displayName = $user->name;
$user_avatar = $user->geticonURL('medium');
$email = $user->email;

$department = $user->get('department');
?>


<div class="clearfix mrgn-bttm-sm">
    <div class="row mrgn-lft-0 mrgn-rght-0 mrgn-tp-sm">
        <div class="col-xs-3">
            
               
                <?php 
                    //EW - change image output so badge displays
                echo elgg_view_entity_icon($user, 'large', array('use_hover' => false, 'class' => 'pro-avatar'));
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
                <?php echo  $email ?>
            </div>
            <div style="max-width:300px;">
                <?php echo $department; ?>
            </div>

            <div>
               
            </div>

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
    if (elgg_is_admin_logged_in() && $admin) {

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
