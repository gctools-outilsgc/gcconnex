<?php
elgg_register_event_handler('init', 'system', 'freshdesk_help_init');

function freshdesk_help_init() {

    elgg_register_page_handler('help', 'help_page_handler');

    elgg_register_action('submit-ticket', elgg_get_plugins_path() . "/freshdesk_help/actions/ticket/submit.php");
    elgg_register_action('save-articles', elgg_get_plugins_path() . "/freshdesk_help/actions/articles/save.php");

    elgg_extend_view("js/elgg", "js/freshdesk_help/functions");
    elgg_extend_view('css/elgg', 'freshdesk/css');

}

function help_page_handler(){
    @include (dirname ( __FILE__ ) . "/pages/help.php");
    return true;
}
