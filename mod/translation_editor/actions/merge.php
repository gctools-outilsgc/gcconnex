<?php 
	gatekeeper();
	
	$current_language = get_input("current_language");
	$plugin = get_input("plugin");
	
	if(translation_editor_is_translation_editor()){
		
		// We'll be outputting a CSV
		header("Content-Type: text/plain");
			
		// It will be called $lang.php
		header('Content-Disposition: attachment; filename="' . $current_language . '.php"');
		
		$translation = translation_editor_get_plugin($current_language, $plugin);
		$translation = $translation['current_language'];
		
		echo "<?php" . PHP_EOL;
		echo '$language = ';
		echo var_export($translation);
		echo ';' . PHP_EOL;
		echo 'add_translation("' . $current_language . '", $language);'  . PHP_EOL;
		
		exit();
		
	} else {
		register_error(elgg_echo("transation_editor:action:translate:error:not_authorized"));
		forward(REFERER);
	}
