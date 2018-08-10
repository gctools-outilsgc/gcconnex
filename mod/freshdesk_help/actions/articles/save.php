<?php
$myFile = elgg_get_config("dataroot") . "freshdesk_help/articles.json";
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = $_POST["html"];
fwrite($fh, $stringData);
fclose($fh)
?>
