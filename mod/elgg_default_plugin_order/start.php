<?php

global $elgg_default_plugin_order_generate;

# To regenerate the plugin list, uncomment the next line and activate the
# Elgg plugin reorder plugin.  (Make sure plugin_config.ini is writable)
#$elgg_default_plugin_order_generate = true;

function elgg_default_plugin_order(){
  global $elgg_default_plugin_order_generate;
  if ($elgg_default_plugin_order_generate) {
    $plugins = elgg_get_plugins('all');
    $config_file = elgg_get_config('path')."plugin_config.ini";
    $data =
      "# GCconnex plugin order.\n".
      "# See mod/elgg_default_plugin_order/start.php\n\n";
    foreach ($plugins as $plugin) {
      $enabled = (is_plugin_enabled($plugin->title)) ? 'enabled' : 'disabled';
      if ($plugin->title == 'elgg_default_plugin_order') {
        $enabled = 'disabled';
      }
      $data .= "{$plugin->title}={$enabled}\n";
    }
    file_put_contents($config_file, $data);
  } else {
	  elgg_default_plugin_order_reorder();
	  elgg_default_plugin_order_set_status();
  }

	if(is_plugin_enabled('elgg_default_plugin_order')){
		disable_plugin('elgg_default_plugin_order');
	}
}

function elgg_default_plugin_order_load_config(){
	$config_settings = array();
	$config_file = elgg_get_config('path')."plugin_config.ini";
	if(file_exists($config_file)){
	   //TODO Add sussport for sections to handle diferent environments
	   $config_settings = parse_ini_file($config_file);
	}
	$config_hash = md5(serialize($config_settings));
	$old_config = get_plugin_setting('config','elgg_default_plugin_order');
	if($old_config != $config_hash){
		set_plugin_setting('config',$config_hash,'elgg_default_plugin_order');
		return $config_settings;
	}
	return $config_settings;
	// TODO Verify problem with cache handling
	//return array();
}
function elgg_default_plugin_order_reorder(){
	$final_order = array();
	$sequence = 10;
	$config_settings = elgg_default_plugin_order_load_config();
	if(!empty($config_settings)){
		foreach($config_settings as $plugin => $status){
			$final_order[$sequence] = $plugin;
			$sequence+=10;
		}
		regenerate_plugin_list($final_order);
		elgg_filepath_cache_reset();
	}

}
function elgg_default_plugin_order_set_status(){
	$config_settings = elgg_default_plugin_order_load_config();
	if(!empty($config_settings)){
		foreach($config_settings as $plugin => $status){
			switch($status){
				case 'enabled':
					if(!is_plugin_enabled($plugin)){
						enable_plugin($plugin);
					}
				break;
				case 'disabled':
					if(is_plugin_enabled($plugin)){
						disable_plugin($plugin);
					}
				break;
			}
		}
		elgg_filepath_cache_reset();
	}
}


register_elgg_event_handler('init','system','elgg_default_plugin_order');

?>
