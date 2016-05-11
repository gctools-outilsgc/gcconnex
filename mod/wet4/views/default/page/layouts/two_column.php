
<?php
/**
 * Elgg one-column layout
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['content'] Content string
 * @uses $vars['class']   Additional class to apply to layout
 * @uses $vars['nav']     Optional override of the page nav (default: breadcrumbs)
 * @uses $vars['title']   Optional title for main content area
 * @uses $vars['header']  Optional override for the header
 * @uses $vars['footer']  Optional footer
 */



//$class = 'elgg-layout elgg-layout-one-column clearfix';
//if (isset($vars['class'])) {
//    $class = "$class {$vars['class']}";
//}
echo $vars['title'];
if(elgg_get_context() =='contactform'){
	$message=elgg_get_plugin_setting('message','contactform');
	$namefr=elgg_get_plugin_setting('namefr','contactform');
	$nameeng=elgg_get_plugin_setting('nameeng','contactform');
	$linkfr=elgg_get_plugin_setting('linkfr','contactform');
	$linkeng=elgg_get_plugin_setting('linkeng','contactform');
	$lang = get_current_language();

if( $message == "yes" ) {

	echo'<section class="alert alert-warning">';
	if (empty($linkfr)){
if ($lang == 'fr'){

	echo '<h3>'.$namefr.'</h3>';
}else{

	echo '<h3>'.$nameeng.'</h3>';
}

	}else{
if ($lang == 'fr'){

	echo '<h3> <a href="'.$linkfr.'">'.$namefr.'</a></h3>';
}else{

	echo '<h3> <a href="'.$linkeng.'">'.$nameeng.'</a></h3>';
}

}

echo '</section>';
}
};
?>

<div class="<?php echo $class; ?>row">
	<?php
$context = elgg_extract('context', $vars, elgg_get_context());
		//echo elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));

		//echo elgg_view('page/layouts/elements/header', $vars);
if ($vars['context']){

	if (isset($vars['filter_override'])) {
		$vars['filter'] = $vars['filter_override'];
	}

	// register the default content filters
	if (!isset($vars['filter']) && elgg_is_logged_in() && $context) {
		$username = elgg_get_logged_in_user_entity()->username;
		$filter_context = elgg_extract('filter_context', $vars, 'all');

		$tabs = array(
			'all' => array(
				'text' => elgg_echo('all'),
				'href' => (isset($vars['all_link'])) ? $vars['all_link'] : "$context/all",
				'selected' => ($filter_context == 'all'),
				'priority' => 200,
			),
			'mine' => array(
				'text' => elgg_echo('mine'),
				'href' => (isset($vars['mine_link'])) ? $vars['mine_link'] : "$context/owner/$username",
				'selected' => ($filter_context == 'mine'),
				'priority' => 300,
			),
			'friend' => array(
				'text' => elgg_echo('friends'),
				'href' => (isset($vars['friend_link'])) ? $vars['friend_link'] : "$context/friends/$username",
				'selected' => ($filter_context == 'friends'),
				'priority' => 400,
			),
		);
	}

	foreach ($tabs as $name => $tab) {
		$tab['name'] = $name;
		elgg_register_menu_item('filter', $tab);
	}


	$filter = elgg_view('page/layouts/elements/filter', $vars);
	$vars['content'] = $filter . $vars['content'];
}

		
    echo '<section class="col-md-6">';

		echo $vars['content'];
        echo '</section>';
        echo '<section class="col-md-6">';

        echo $vars['sidebar'];
        echo '</section>';


		// @deprecated 1.8
		if (isset($vars['area1'])) {
			echo $vars['area1'];
		}

		echo elgg_view('page/layouts/elements/footer', $vars);
	?>

</div>