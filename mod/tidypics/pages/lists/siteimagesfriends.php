<?php

/**
 * Most recently uploaded images - logged in user's images
 *
 */

gatekeeper();

$owner = elgg_get_logged_in_user_entity();

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('photos'), 'photos/siteimagesall');
elgg_push_breadcrumb($owner->name, "photos/siteimagesfriends/$owner->username");
elgg_push_breadcrumb(elgg_echo('friends'));

$offset = (int)get_input('offset', 0);
$limit = (int)get_input('limit', 16);

if ($friends = get_user_friends($owner->guid, "", 999999, 0)) {
        $friendguids = array();
        foreach ($friends as $friend) {
                $friendguids[] = $friend->getGUID();
        }
        $result = elgg_list_entities(array(
                        'type' => 'object',
                        'subtype' => 'image',
                        'owner_guids' => $friendguids,
                        'limit' => $limit,
                        'offset' => $offset,
                        'full_view' => false,
                        'pagination' => true,
                        'list_type' => 'gallery',
                        'gallery_class' => 'tidypics-gallery'
                       ));
}
if (!empty($result)) {
        $area2 = $result;
} else {
        $area2 = elgg_echo("tidypics:siteimagesfriends:nosuccess");
}

$title = elgg_echo('tidypics:siteimagesfriends');

$owner_guid = elgg_get_logged_in_user_guid();
elgg_register_menu_item('title', array('name' => 'addphotos',
                                       'href' => "ajax/view/photos/selectalbum/?owner_guid=$owner_guid",
                                       'text' => elgg_echo("photos:addphotos"),
                                       'link_class' => 'elgg-button elgg-button-action elgg-lightbox'));

// only show slideshow link if slideshow is enabled in plugin settings and there are images
if (elgg_get_plugin_setting('slideshow', 'tidypics') && !empty($result)) {
        $url = elgg_get_site_url() . "photos/siteimagesfriends/$owner->username?limit=64&offset=$offset&view=rss";
        $url = elgg_format_url($url);
        $slideshow_link = "javascript:PicLensLite.start({maxScale:0, feedUrl:'$url'})";
        elgg_register_menu_item('title', array('name' => 'slideshow',
                                                'href' => $slideshow_link,
                                                'text' => "<img src=\"".elgg_get_site_url() ."mod/tidypics/graphics/slideshow.png\" alt=\"".elgg_echo('album:slideshow')."\">",
                                                'title' => elgg_echo('album:slideshow'),
                                                'class' => 'elgg-button elgg-button-action'));
}

$body = elgg_view_layout('content', array(
        'filter_override' => elgg_view('filter_override/siteimages', array('selected' => 'friends')),
        'content' => $area2,
        'title' => $title,
        'sidebar' => elgg_view('photos/sidebar', array('page' => 'all')),
));

// Draw it
echo elgg_view_page($title, $body);
