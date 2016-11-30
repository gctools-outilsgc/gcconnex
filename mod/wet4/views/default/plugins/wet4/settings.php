<?php
/*
 * settings.php
 * 
 * Plugin settings for wet4 mod. Accessed through the site admin panel
 * 
 * @package wet4
 * @author GCTools Team
 */

$options = array(
	'name' => 'params[ExtTheme]',
	'value' => 1
);
if (elgg_get_plugin_setting('ExtTheme', 'wet4')) {
	$options['checked'] = 'checked';
}
echo "<div class='checkbox'>";
echo elgg_echo('wet4:ExtTheme');
echo "<label>".elgg_view('input/checkbox',$options);
echo elgg_echo('wet4:ExtThemeYes')."</label>";
echo "</div>";
?>