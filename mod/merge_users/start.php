<?php
elgg_register_event_handler('init', 'system', 'merge_users_init');

function merge_users_init() {

    elgg_register_action('users/merge', elgg_get_plugins_path() . "/merge_users/actions/users/merge.php");

    elgg_register_ajax_view("merge_users/display");

    elgg_register_menu_item('page', array(
        'name' => 'users:merge',
        'href' => elgg_get_site_url() . 'admin/merge_users/merge',
        'text' => 'Merge users',
        'section' => 'administer',
    ));

}
