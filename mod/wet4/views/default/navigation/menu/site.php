<?php
/**
 * Site navigation menu
 *
 * @uses $vars['menu']['default']
 * @uses $vars['menu']['more']
 *
 * GC_MODIFICATION
 * Description: formats site menu to look and function like the wet template
 * Author: GCTools Team
 */

$default_items = elgg_extract('default', $vars['menu'], array());
$more_items = elgg_extract('more', $vars['menu'], array());

echo '<ul class="list-inline menu col-md-6" style="font-weight:500" tabindex="0" color:#333333;>';

foreach ($default_items as $menu_item) {
	echo elgg_view('navigation/menu/elements/item', array('item' => $menu_item, 'item-role' => 'none'));
}

echo '</ul>';

if (!elgg_is_logged_in()) {
    echo '<ul nav="navigation" class="text-right col-md-12 mrgn-tp-sm user-z-index">';
        
    echo elgg_view('page/elements/login_menu', $vars);

    echo '</nav>';
} else{
	echo '<ul class="list-inline menu col-md-4" role="menubar" align="right">';
		//echo elgg_view('page/elements/topbar', $vars);
		echo elgg_view('page/elements/user_menu', $vars);
	echo '</ul>';
}

?>

<form action="<?php echo elgg_get_site_url(); ?>search" name="cse-search-box">
        <div>
            <label for="wb-srch-q" class="wb-inv"> <?php echo elgg_echo('wet:searchweb'); ?> </label>
<?php
echo '<div class="collapse " id="collapseSearch"> <div class="well" aria-label="Search GCcollab">'; 
	echo elgg_view('input/text', array(
        'id' => 'tagSearch',
    	'name' => 'tag',
        'class' => 'elgg-input-search mbm',
    	'placeholder' => elgg_echo('wet:searchgctools'),
        'required' => true
    ));
	echo '</div>';
echo '</div>';
?>
			<input type="hidden" id="a" name="a"  value="s">
            <input type="hidden" id="s" name="s"  value="3">
            <input type="hidden" id="chk4" name="chk4"  value="on">
        </div>
	</form>
