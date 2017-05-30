<?php

elgg_register_event_handler('init', 'system', 'enhanced_user_search_init');

function enhanced_user_search_init() {
	 elgg_register_library(
     'enhanced_user_search',
     elgg_get_plugins_path() . 'enhanced_user_search/lib/functions.php'
   );
	 elgg_load_library('enhanced_user_search');

  $search = \NRC\EUS\get();
  $search->initialize();

  elgg_register_plugin_hook_handler(
    'cron', 'fifteenmin', 'enhanced_user_search_cron', 1
  );

}

function enhanced_user_search_cron() {
  $search = \NRC\EUS\get();
  $search->refresh();
}

