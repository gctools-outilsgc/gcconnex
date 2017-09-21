<?php

class ElggHybridAuth extends Hybrid_Auth {

	public function __construct() {

		$config = array(
			'base_url' => elgg_get_plugin_setting('base_url', 'linkedin_profile_importer'),
			'debug_mode' => elgg_get_plugin_setting('debug_mode', 'linkedin_profile_importer'),
			'debug_file' => elgg_get_plugin_setting('debug_file', 'linkedin_profile_importer'),
			'providers' => unserialize(elgg_get_plugin_setting('providers', 'linkedin_profile_importer'))
		);
		
		parent::__construct($config);
	}

}

?>
