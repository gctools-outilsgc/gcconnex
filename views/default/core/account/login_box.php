<section class="panel panel-info">
	<header class="panel-heading">
		<h3 class="panel-title "><span class='glyphicon glyphicon-info-sign mrgn-rght-sm'></span><?php echo elgg_echo('notice:title') ?></h3>
	</header>
	<div class="panel-body">
		<?php echo elgg_echo('notice:paragraphe') ?>
		</div>
</section>

<?php
/**
 * Elgg login box
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['module'] The module name. Default: aside
 */

$module = elgg_extract('module', $vars, 'aside');

$login_url = elgg_get_site_url();
if (elgg_get_config('https_login')) {
	$login_url = str_replace("http:", "https:", $login_url);
}

$title = elgg_extract('title', $vars, elgg_echo('login'));

$body = elgg_view_form('login', array('action' => "{$login_url}action/login"));

echo elgg_view_module($module, $title, $body);
