<?php
if (elgg_is_active_plugin('gc_fedsearch_gsa') && ((!$gsa_usertest) && strcmp($gsa_agentstring,strtolower($_SERVER['HTTP_USER_AGENT'])) == 0) || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false )
	$css = "style='display:none;'";
else 
	$css = "";
?>

<div class='let_crawler_know_to_ignore_this' <?php echo $css ?>>