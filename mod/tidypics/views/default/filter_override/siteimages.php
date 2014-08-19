<?php

if (elgg_is_logged_in()) {
        $base = elgg_get_site_url() . 'photos/';

        $tabs = array(
                  'all' => array('title' => elgg_echo('all'),
                                 'url' => $base . 'siteimagesall',
                                 'selected' => $vars['selected'] == 'all',
                                ),
                  'mine' => array('title' => elgg_echo('mine'),
                                  'url' => $base . 'siteimagesowner',
                                  'selected' => $vars['selected'] == 'mine',
                                 ),
                  'friends' => array('title' => elgg_echo('friends'),
                                     'url' => $base . 'siteimagesfriends',
                                     'selected' => $vars['selected'] == 'friends',
                                 )
                     );

        echo elgg_view('navigation/tabs', array('tabs' => $tabs));
}
