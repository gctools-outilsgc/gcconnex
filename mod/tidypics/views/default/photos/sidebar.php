<?php
/**
 * Sidebar view
 */

$current_user_guid = elgg_get_logged_in_user_guid();

$base = elgg_get_site_url() . 'photos/';

elgg_register_menu_item('page', array('name' => 'A10_tiypics_siteimages',
                                      'text' => elgg_echo('tidypics:siteimagesall'),
                                      'href' => $base . 'siteimagesall',
                                      'section' => 'A'));
elgg_register_menu_item('page', array('name' => 'A20_tiypics_albums',
                                      'text' => elgg_echo('album:all'),
                                      'href' => $base . 'all',
                                      'section' => 'A'));

$page = elgg_extract('page', $vars);
$image = elgg_extract('image', $vars);
if ($page == 'upload') {
        if (elgg_get_plugin_setting('quota', 'tidypics')) {
                echo elgg_view('photos/sidebar/quota', $vars);
        }
} else if (($page == 'all') || ($page == 'owner') || ($page == 'friends')) {

        elgg_register_menu_item('page', array('name' => 'A30_tiypics_recentlyviewed',
                                              'text' => elgg_echo('tidypics:recentlyviewed'),
                                              'href' => $base . 'recentlyviewed',
                                              'section' => 'A'));
        elgg_register_menu_item('page', array('name' => 'A40_tiypics_recentlycommented',
                                              'text' => elgg_echo('tidypics:recentlycommented'),
                                              'href' => $base . 'recentlycommented',
                                              'section' => 'A'));

        elgg_register_menu_item('page', array('name' => 'B10_tiypics_mostviewed',
                                              'text' => elgg_echo('tidypics:mostviewed'),
                                              'href' => $base . 'mostviewed',
                                              'section' => 'B'));
        elgg_register_menu_item('page', array('name' => 'B20_tiypics_mostviewedtoday',
                                              'text' => elgg_echo('tidypics:mostviewedtoday'),
                                              'href' => $base . 'mostviewedtoday',
                                              'section' => 'B'));
        elgg_register_menu_item('page', array('name' => 'B30_tiypics_mostviewedthismonth',
                                              'text' => elgg_echo('tidypics:mostviewedthismonth'),
                                              'href' => $base . 'mostviewedthismonth',
                                              'section' => 'B'));
        elgg_register_menu_item('page', array('name' => 'B40_tiypics_mostviewedlastmonth',
                                              'text' => elgg_echo('tidypics:mostviewedlastmonth'),
                                              'href' => $base . 'mostviewedlastmonth',
                                              'section' => 'B'));
        elgg_register_menu_item('page', array('name' => 'B50_tiypics_mostviewedthisyear',
                                              'text' => elgg_echo('tidypics:mostviewedthisyear'),
                                              'href' => $base . 'mostviewedthisyear',
                                              'section' => 'B'));

        elgg_register_menu_item('page', array('name' => 'C10_tidypics_mostcommented',
                                              'text' => elgg_echo('tidypics:mostcommented'),
                                              'href' => $base . 'mostcommented',
                                              'section' => 'C'));
        elgg_register_menu_item('page', array('name' => 'C20_tidypics_mostcommentedtoday',
                                              'text' => elgg_echo('tidypics:mostcommentedtoday'),
                                              'href' => $base . 'mostcommentedtoday',
                                              'section' => 'C'));
        elgg_register_menu_item('page', array('name' => 'C30_tidypics_mostcommentedthismonth',
                                              'text' => elgg_echo('tidypics:mostcommentedthismonth'),
                                              'href' => $base . 'mostcommentedthismonth',
                                              'section' => 'C'));
        elgg_register_menu_item('page', array('name' => 'C40_tidypics_mostcommentedlastmonth',
                                              'text' => elgg_echo('tidypics:mostcommentedlastmonth'),
                                              'href' => $base . 'mostcommentedlastmonth',
                                              'section' => 'C'));
        elgg_register_menu_item('page', array('name' => 'C50_tidypics_mostcommentedthisyear',
                                              'text' => elgg_echo('tidypics:mostcommentedthisyear'),
                                              'href' => $base . 'mostcommentedthisyear',
                                              'section' => 'C'));

        if(elgg_is_active_plugin('elggx_fivestar')) {
                elgg_register_menu_item('page', array('name' => 'D10_tidypics_highestrated',
                                                      'text' => elgg_echo('tidypics:highestrated'),
                                                      'href' => $base . 'highestrated',
                                                      'section' => 'D'));
                elgg_register_menu_item('page', array('name' => 'D20_tidypics_highestvotecount',
                                                      'text' => elgg_echo('tidypics:highestvotecount'),
                                                      'href' => $base . 'highestvotecount',
                                                      'section' => 'D'));
                elgg_register_menu_item('page', array('name' => 'D30_tidypics_recentvotes',
                                                      'text' => elgg_echo('tidypics:recentlyvoted'),
                                                      'href' => $base . 'recentvotes',
                                                      'section' => 'D'));
        }

        if(elgg_is_logged_in()) {
                elgg_register_menu_item('page', array('name' => 'E10_tidypics_usertagged',
                                        'text' => elgg_echo('tidypics:usertagged'),
                                        'href' => $base . "tagged?guid=$current_user_guid",
                                        'section' => 'E'));
        }

} else if ($image && $page == 'tp_view') {
        if (elgg_get_plugin_setting('exif', 'tidypics')) {
                echo elgg_view('photos/sidebar/exif', $vars);
        }

        // list of tagged members in an image (code from Tagged people plugin by Kevin Jardine)
        if (elgg_get_plugin_setting('tagging', 'tidypics')) {
                $body = elgg_list_entities_from_relationship(array(
                        'relationship' => 'phototag',
                        'relationship_guid' => $image->guid,
                        'inverse_relationship' => true,
                        'type' => 'user',
                        'limit' => 15,
                        'list_type' => 'gallery',
                        'gallery_class' => 'elgg-gallery-users',
                        'pagination' => false
                ));
                if ($body) {
                        $title = elgg_echo('tidypics_tagged_members');
                        echo elgg_view_module('aside', $title, $body);
                }
        }
}
