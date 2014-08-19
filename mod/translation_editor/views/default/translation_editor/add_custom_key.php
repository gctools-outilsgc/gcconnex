<?php 

	$action = $vars["url"] . "action/translation_editor/add_custom_key";
	
	$form_body .= "<div>"; 
	$form_body .= "<label>" . elgg_echo("translation_editor:custom_keys:key") . "</label>";
	$form_body .= elgg_view("input/text", array("name" => "key"));
	
	$form_body .= "<label>" . elgg_echo("translation_editor:custom_keys:translation") . "</label>";
	$form_body .= "<textarea name='translation'></textarea>";
	$form_body .= "<span id='translation_editor_custom_keys_translation_info'>" . elgg_echo("translation_editor:custom_keys:translation_info") . "</span>";
	$form_body .= "</div>";
	
	$form_body .= elgg_view("input/submit", array("value" => elgg_echo("save")));
	
	$form = elgg_view("input/form", array("body" => $form_body, "action" => $action, "id" => "translation_editor_custom_keys_form"));

?>
<h3><?php echo elgg_echo("translation_editor:custom_keys:title"); ?></h3>
<?php 
	echo $form; 