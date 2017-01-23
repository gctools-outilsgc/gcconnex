<?php

$text = $_GET["q"];
$lang = $_GET["lang"];


$url="http://192.168.2.53/translate.php?q=$text&lang=$lang";
//$url="http://gcpedia.tools.gc.ca/translate.php?q=$text&lang=$lang";
$ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
  $data = curl_exec($ch);
  
if($data)
{
	echo $data;
}else{
	echo 'Curl error: ' . curl_error($ch);
}
curl_close($ch);



//header('Content-type: plain/text');
//echo file_get_contents("http://192.168.2.53/translate.php?q=$text&lang=$lang");


?>