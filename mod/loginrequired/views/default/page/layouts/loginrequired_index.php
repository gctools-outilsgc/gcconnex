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
</div>
