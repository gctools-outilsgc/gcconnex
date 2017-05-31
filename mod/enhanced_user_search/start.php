<?php
/**
 * Entry point for the enhanced_user_search plugin.
 *
 */

// Register the function to be called during system initialization.
elgg_register_event_handler('init', 'system', 'enhanced_user_search_init');

/**
 * Initialize the enhanced_user_search plugin
 *
 * @return void
 */
function enhanced_user_search_init() {
  // Register the plugin as a library available to the entire site.
	 elgg_register_library(
     'enhanced_user_search',
     elgg_get_plugins_path() . 'enhanced_user_search/lib/functions.php'
   );
	 elgg_load_library('enhanced_user_search');

  // Initialize the plugin.
  $search = \NRC\EUS\get();
  $search->initialize();

  // Register the cron handler
  elgg_register_plugin_hook_handler(
    'cron', 'halfhour', 'enhanced_user_search_cron', 1
  );

}

/**
 * Method called by cron to refresh the search index
 *
 * @return void
 */
function enhanced_user_search_cron() {
  $search = \NRC\EUS\get();
  $search->refresh();
}

