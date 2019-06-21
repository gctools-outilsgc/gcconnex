<?php
require('lib/createObjectsFunctions.php');

elgg_register_event_handler('init','system','loadtest_init');

function loadtest_init($event, $object_type, $object = null) {
    /* page handlers */
    // for generating random test content
    elgg_register_page_handler('gen-content', 'generate_content_page_handler');

    // for simulating page load - related system load
}

function generate_content_page_handler($params) {
    // generate content of type requested
    switch ($params[0]) {   // first parameter is the content type
        case 'blog':
        case 'blogs':
            createBlogs($params[1]);
            break;case 'blog':
        case 'wire':
            createWire($params[1]);
            break;
        // the rest go here
        default:
            # nothing
            echo "usage:  .../gen-content/[blogs, bookmarks, discussions, groups, members, wire, files, polls, events, missions]/N  to create N random instances of that content type ";
            break;
    }
    return true;
}

