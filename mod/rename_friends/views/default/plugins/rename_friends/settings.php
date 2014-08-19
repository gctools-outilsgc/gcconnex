<?php
// read the languages directory to get a list of existing translations

$language_files = elgg_get_file_list(elgg_get_plugins_path() . "rename_friends/languages/", array(), array(), array('.php'));

$translations = array();
foreach($language_files as $language){
  $translations[] = basename($language, '.php');
}

if(count($translations) == 0){
	echo "<h1>" . elgg_echo('rename_friends:missing:language:file') . "</h1>";
}
else{
	echo "<h1>" . elgg_echo('rename_friends:settings') . "</h1>";
	
	for($i=0; $i<count($translations); $i++){
		
		$singular = elgg_get_plugin_setting($translations[$i].'singular', 'rename_friends');
		$plural = elgg_get_plugin_setting($translations[$i].'plural', 'rename_friends');
		
		//set defaults if nothing has been set yet
		if(empty($singular)){ $singular = elgg_echo('friend'); }
		if(empty($plural)){ $plural = elgg_echo('friends'); }
		
		$language = elgg_echo('rename_friends:language');
		$html = "<div class=\"rename_friends_language_edit\"><br/>";
		$html .= "$language: <b>{$translations[$i]}</b>";
		$html .= "<table><tr><td>&nbsp;</td></tr><tr><td>";
		$html .= "<label>" . elgg_echo('rename_friends:singular') . ":&nbsp;&nbsp;</label>";
		$html .= "</td><td>";
		$html .= elgg_view('input/text', array('name' => "params[" . $translations[$i].'singular' . "]", 'value' => $singular)) . "<br>";
		$html .= "</td></tr><tr><td>";
		$html .= "<label>" . elgg_echo('rename_friends:plural') . ": </label>";
		$html .= "</td><td>";
		$html .= elgg_view('input/text', array('name' => "params[" . $translations[$i].'plural' . "]", 'value' => $plural)) . "<br>";
		$html .= "</td></tr></table>";
		$html .= "</div>";
		echo $html;
	}
}
