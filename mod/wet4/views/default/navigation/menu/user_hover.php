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
            <a href="<?php echo $site_url ?>profile/<?php echo $user ?>" title="<?php echo elgg_echo('profile:title', array($user->name))?>">
               
                <img class="mrgn-lft-sm mrgn-bttm-sm img-circle img-responsive" src="<?php echo $user_avatar?>" alt="<?php echo $displayName ?> Profile Picture" />
            </a>
        </div>

        <div class="col-xs-9">
            <h4 class="mrgn-tp-sm mrgn-bttm-0">
                <?php
                $name_link = elgg_view('output/url', array(
                    'href' => $user->getURL(),
                    'text' => "<span class=\"elgg-heading-basic\">$user->name</span>&#64;$user->username",
                    'is_trusted' => true,
                    ));
                echo "$name_link";

                ?>
            </h4>
            <div>
                <?php echo  $email ?>
            </div>
            <div>
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

                if($itemName == 'friend_request' || $itemName == 'add_friend'){
                    $item_class = 'btn btn-primary';
                } else {
                    $item_class = 'btn btn-default';
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

        foreach($admin as $menu_item){

            $items .= elgg_view('navigation/menu/elements/item', array(
                        'item' => $menu_item,
                        'item_class' => 'mrgn-rght-sm mrgn-bttm-sm',
                    ));
        }

        echo elgg_format_element('ul', ['class' => 'list-inline', 'style' => 'max-width:500px; padding: 3px;'], $items);



    }
    
        
        ?>
    </div>
