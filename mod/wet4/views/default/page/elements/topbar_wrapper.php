<?php
/**
 * Elgg topbar wrapper
 * Check if the user is logged in and display a topbar
 * @since 1.10 
 
 
 original format
 
 <div class="elgg-page-topbar">
	<div class="elgg-inner text-right mrgn-tp-sm">
		<?php
        //echo elgg_view('page/elements/topbar', $vars);
		echo elgg_view('page/elements/user_menu', $vars);
		?>
	</div>
</div>
 
 
 * GC_MODIFICATION
 * Description: Replaced topbar with user menu
 */

if (!elgg_is_logged_in()) {
    echo '<nav role="navigation" class="text-right col-md-12 mrgn-tp-sm user-z-index">';
        
    echo elgg_view('page/elements/login_menu', $vars);

    echo '</nav>';
    
	//return true;
} else {
?>


<nav role="navigation" class="text-right col-md-12 mrgn-tp-sm user-z-index">
    <h2 class="wb-invisible"><?php echo elgg_echo('wet:usermenu:helpertext'); ?></h2>
    <?php
        //echo elgg_view('page/elements/topbar', $vars);
		echo elgg_view('page/elements/user_menu', $vars);
		?>
</nav>

<?php }?>