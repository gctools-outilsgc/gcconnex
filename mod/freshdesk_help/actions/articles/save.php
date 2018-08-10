<?php
$myFile = "/sites/gccollab_data/freshdesk_help/articles.json";
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = $_POST["html"];
fwrite($fh, $stringData);
fclose($fh)
?>
