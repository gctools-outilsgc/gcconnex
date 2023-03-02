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
