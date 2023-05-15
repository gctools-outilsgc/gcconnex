<?php
elgg_register_event_handler('init', 'system', 'freshdesk_help_init');

function freshdesk_help_init() {
    elgg_unregister_plugin_hook_handler('output:before', 'page', '_elgg_views_send_header_x_frame_options');

    elgg_register_page_handler('help', 'help_page_handler');

    elgg_register_action('submit-ticket', elgg_get_plugins_path() . "/freshdesk_help/actions/ticket/submit.php");
    elgg_register_action('submit-ticket-pedia', elgg_get_plugins_path() . "/freshdesk_help/actions/ticket/submit-pedia.php");
    elgg_register_action('save-articles', elgg_get_plugins_path() . "/freshdesk_help/actions/articles/save.php");
    elgg_register_action('save-articles-pedia', elgg_get_plugins_path() . "/freshdesk_help/actions/articles/pedia-save.php");

    elgg_register_action('ticket/feedback', elgg_get_plugins_path() . "/freshdesk_help/actions/ticket/feedback.php", "public");

    elgg_extend_view("js/elgg", "js/freshdesk_help/functions");
    elgg_extend_view('css/elgg', 'freshdesk/css');

    if(elgg_get_plugin_setting("custom_domain_url", "freshdesk_help")){
        $help_link = elgg_get_plugin_setting("custom_domain_url", "freshdesk_help");
    } else {
        $help_link = "help/knowledgebase";
    }

    elgg_register_menu_item('site', array(
    'name' => 'Help',
    'href' => $help_link,
    'text' => elgg_echo('freshdesk:page:title'),
    'priority' => 1000,
    'title' => elgg_echo('contactform:alttext'), 
  	));

}

function help_page_handler($page){

    switch ($page[0]) {
  		case "knowledgebase":
  			include (dirname ( __FILE__ ) . "/pages/help.php");
  			break;

  		case "embed":
  			include (dirname ( __FILE__ ) . "/pages/embed.php");
  			break;

  		default:
  			return false;
  	}
  	return true;

}
