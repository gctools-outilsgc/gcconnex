<?php
if ( strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'solr-crawler') !== false )
	$css = "style='display:none;'";
else 
	$css = "";
?>

<div class='let_crawler_know_to_ignore_this' <?php echo $css ?>>