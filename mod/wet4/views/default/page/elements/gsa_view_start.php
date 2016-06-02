<?php
if ('gsa-crawler' === strtolower($_SERVER['HTTP_USER_AGENT']))
	$css = "style='display:none;'";
else 
	$css = "";
?>

<div class='let_crawler_know_to_ignore_this' <?php echo $css ?>>