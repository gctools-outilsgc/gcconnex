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

?>
<!--<div class="<?php //echo $class; ?> row">
	<div class="elgg-main">-->
<section id="wb-cont">
	<?php
$context = elgg_extract('context', $vars, elgg_get_context());
	if($params['event_page'] == true){
		echo elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));
		echo elgg_view('page/layouts/elements/header', $vars);
}else{
    if(elgg_in_context('messages')){
        echo elgg_view('page/layouts/elements/header', $vars);
        echo elgg_view_menu('page', array('sort_by' => 'priority'));
        echo elgg_view_menu('title', array('sort_by' => 'priority', 'class' => 'list-unstyled text-right', 'item_class' => 'btn btn-primary'));
    } else if(elgg_in_context('search')){
        echo ''; // remove double h1 for gsa search - Nick
    }else{
        echo '<h1>' . $vars['title'] . '</h1>';  
    }
        
}


if ($context == 'event_calendar'){
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

		echo $vars['content'];
		
		// @deprecated 1.8
		if (isset($vars['area1'])) {
			echo $vars['area1'];
		}

		echo elgg_view('page/layouts/elements/footer', $vars);
    ?>
</section>
	<!--</div>
</div>-->