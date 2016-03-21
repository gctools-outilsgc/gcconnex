<?php

elgg_register_event_handler('init', 'system', 'hello_world_init');

function hello_world_init() {
    elgg_register_page_handler('hello', 'hello_world_page_handler');
}
