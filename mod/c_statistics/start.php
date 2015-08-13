<?php

elgg_register_event_handler('init', 'system', 'c_statistics_init');

function c_statistics_init() 
{
	//$main_item = new ElggMenuItem('c_statistics', elgg_echo('[user] statistics'), 'c_statistics/user');
	//elgg_register_menu_item('site', $main_item);

	elgg_register_class('phpexcel', dirname(__FILE__) . '/vendors/PHPExcel-develop/Classes/PHPExcel.php');

	elgg_register_library('c_statistics', elgg_get_plugins_path() . 'c_statistics/lib/stats_query.php');
	elgg_register_library('c_statistics_html', elgg_get_plugins_path() . 'c_statistics/lib/html2text.php');

	$footer_item = new ElggMenuItem('c_statistics', elgg_echo('stats:statspage'), 'c_statistics/site');
	//elgg_register_menu_item('footer', $footer_item);



	//if (strpos($_SERVER["REQUEST_URI"],'profile') == true )
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'stats_owner_block_menu');

	elgg_register_js('jquery-c_stats-min', 'mod/c_statistics/vendors/jquery/jquery-1.7.1.min.js');
	elgg_register_js('jquery-c_stats', 'mod/c_statistics/vendors/jquery/jquery-1.7.1.js');

	// register page handler
	elgg_register_page_handler('c_statistics', 'stats_page_handler');
}

function stats_owner_block_menu($hook, $type, $return, $params)
{	
	$check_type = $params['entity']->type;
	if ($check_type === 'group')
	{
		$url = "c_statistics/group/{$params['entity']->guid}/group_stats";
		$item = new ElggMenuItem('c_statistics', elgg_echo('Group statistics'), $url);
		$return[] = $item;
		return $return;
	}
}

function stats_page_handler($page)
{
	$plugin_path = elgg_get_plugins_path();
	$pages = $plugin_path . 'c_statistics/pages/c_statistics';
	switch ($page[0])
	{
		case 'user':
			include $pages.'/site_statistics.php';
			break;
		case 'group':
			include $pages.'/group_statistics.php';
			break;
		case 'site':
			include $pages.'/overall_site_statistics.php';
			break;
		case 'xexcel':
			include $pages.'/download_excel.php';
			break;
		case 'group_stats':
			include $pages.'/group_statistics_analysis.php';
			break;
		default:
			return false;
	}	
	return true;
}

