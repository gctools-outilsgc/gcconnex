<?php
/**
 * Displays breadcrumbs.
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['breadcrumbs'] (Optional) Array of arrays with keys 'title' and 'link'
 * @uses $vars['class']
 *
 * @see elgg_push_breadcrumb
 * @see elgg_get_breadcrumbs
 *
 * GC_MODIFICATION
 * Description: breadcrumbs with the wet formatting
 * Author: GCTools Team
 */
 $site_url = elgg_get_site_url();

if (isset($vars['breadcrumbs'])) {
	$breadcrumbs = $vars['breadcrumbs'];
} else {
	$breadcrumbs = elgg_get_breadcrumbs();
}

$class = 'breadcrumb';
$additional_class = elgg_extract('class', $vars, '');
if ($additional_class) {
	$class = "$class $additional_class";
}

if (is_array($breadcrumbs) && count($breadcrumbs) > 0) {
    echo '<nav role="navigation" id="wb-bc" property="breadcrumb">';
    echo '<h2>'.elgg_echo('wet:youarehere').'</h2>';
    echo '<div class="container">';
    echo '<div class="row">';
	echo "<ol class=\"$class\">";
    
    //home breadcrumb
    echo '<li><a href="' . $site_url . '" title="Home">'.elgg_echo('breadcrum:home').'</a></li>';
    
	foreach ($breadcrumbs as $breadcrumb) {
		// We have to escape text (without double-encoding). Titles in core plugins are HTML escaped
		// on input, but we can't guarantee that other users of this view and of elgg_push_breadcrumb()
		// will do so.
		if (!empty($breadcrumb['link'])) {
			$crumb = elgg_view('output/url', array(
				'href' => $breadcrumb['link'],
				'text' => $breadcrumb['title'],
				'encode_text' => true,
				'is_trusted' => true,
			));
		} else {
			$crumb = htmlspecialchars($breadcrumb['title'], ENT_QUOTES, 'UTF-8', false);
		}
		echo "<li>$crumb</li>";
	}
	echo '</ol>';
    echo '</div>';
    echo '</div>';
    echo '</nav>';
}
