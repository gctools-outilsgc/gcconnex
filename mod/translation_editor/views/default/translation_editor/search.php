<?php 

	$current_language = $vars["current_language"];
	$q = $vars["query"];
	$in_search = $vars["in_search"];
	
	if(empty($q)){
		$q = elgg_echo("translation_editor:forms:search:default");
	}
	
	// build form
	$form_data .= "<table><tr><td>";
	
	$form_data .= elgg_view("input/text", array("name" => "translation_editor_search", "value" => $q));
	
	$form_data .= "</td><td>&nbsp;";
	
	$form_data .= elgg_view("input/hidden", array("name" => "language", "value" => $current_language));
	$form_data .= elgg_view("input/submit", array("value" => elgg_echo("search")));
	
	$form_data .= "</td></tr></table>"; 
	$form = elgg_view("input/form", array("body" => $form_data,
											"id" => "translation_editor_search_form",
											"action" => $vars["url"] . "translation_editor/search",
											"disable_security" => true));

	echo $form; 
	echo "<br />";
	
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#translation_editor_search_form input[name="translation_editor_search"]').focus(function(){
			if($(this).val() == "<?php echo elgg_echo("translation_editor:forms:search:default"); ?>"){
				$(this).val("");
			}
		}).blur(function(){
			if($(this).val() == ""){
				$(this).val("<?php echo elgg_echo("translation_editor:forms:search:default"); ?>");
			}
		});
	});
</script>