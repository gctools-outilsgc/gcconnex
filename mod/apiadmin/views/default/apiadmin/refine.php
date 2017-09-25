<?php
/**
 * API Access log browser search form
 *
 * @package APIAdmin
 */

$form_vars = array(
	'method' => 'get',
	'action' => 'admin/statistics/apilog',
	'disable_security' => true,
);
$form = elgg_view_form('apiadmin/refine', $form_vars, $vars);

$toggle_link = elgg_view('output/url', array(
	'href' => '#log-browser-search-form',
	'text' => elgg_echo('logbrowser:search'),
	'rel' => 'toggle',
));

$form_class = 'elgg-module elgg-module-inline';
if ( !isset($vars['api_key']) ) {
	$form_class .= ' hidden';
}
?>

<div id="logbrowser-search-area" class="mbm">
	<div>
		<?php echo $toggle_link; ?>
	</div>
	<div id="log-browser-search-form" class="<?php echo $form_class; ?>">
		<div class="elgg-head">
			<h3><?php echo elgg_echo('logbrowser:search'); ?></h3>
		</div>
		<div class="elgg-body">
			<?php echo $form; ?>
		</div>
	</div>
</div>