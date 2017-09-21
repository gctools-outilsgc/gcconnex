<?php
/**
 * Loginrequired Login page layout
 *
 */

$mod_params = array('class' => 'elgg-module-highlight');
?>

<div class="loginrequired-index elgg-main elgg-grid clearfix">
	<div class="elgg-col elgg-col-1of2 loginrequired-index-col1">
		<div class="elgg-inner pvm">
<?php
// left column
			$top_box = $vars['login'];

			echo elgg_view_module('featured',  '', $top_box, $mod_params);

			echo elgg_view("index/lefthandside");
?>
		</div>
	</div>

	<div class="elgg-col elgg-col-1of2 loginrequired-index-col2">
		<div class="elgg-inner pvm">
<?php
// right column

			// a view for plugins to extend
			echo elgg_view("index/righthandside");

			$infobox = 'Text shown in right column widget.';
			$infobox .= '<img src="./frontpage_image.jpg" alt="Frontpage_Image">';

			echo elgg_view_module('featured',  elgg_echo("Title of right column widget"), $infobox, $mod_params);

?>

		</div>
	</div>
</div>
