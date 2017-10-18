<?php
elgg_register_event_handler('init', 'system', 'merge_users_init');

function merge_users_init() {

    elgg_register_action('users/merge', elgg_get_plugins_path() . "/merge_users/actions/users/merge.php");

    elgg_register_ajax_view("merge_users/display");

    elgg_register_admin_menu_item('administer', 'merge_users', 'users');

}
