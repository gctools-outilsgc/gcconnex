<?php
/**
 * Show the thumbnail
 */

// won"t be able to serve anything if no guid
if (!isset($_GET["guid"]) || !isset($_GET["group_guid"])) {
	header("HTTP/1.1 404 Not Found");
	exit;
}

$icontime = (int) $_GET["icontime"];
$size = strtolower($_GET["size"]);
$guid = (int) $_GET["guid"];
$group_guid = (int) $_GET["group_guid"];

// If is the same ETag, content didn"t changed.
$etag = md5($icontime . $size . $group_guid . $guid);
if (isset($_SERVER["HTTP_IF_NONE_MATCH"])) {
	list ($etag_header) = explode("-", trim($_SERVER["HTTP_IF_NONE_MATCH"], "\""));
	if ($etag_header === $etag) {
		header("HTTP/1.1 304 Not Modified");
		exit;
	}
}

$base_dir = dirname(dirname(dirname(dirname(dirname(__FILE__)))));

// Get DB settings
require_once $base_dir . '/engine/settings.php';
require_once $base_dir . '/vendor/autoload.php';

global $CONFIG;

if (isset($CONFIG->dataroot)) {
	$data_root = $CONFIG->dataroot;
}

if (!isset($data_root)) {
	$db_config = new \Elgg\Database\Config($CONFIG);
	if ($db_config->isDatabaseSplit()) {
		$read_settings = $db_config->getConnectionConfig(\Elgg\Database\Config::READ);
	} else {
		$read_settings = $db_config->getConnectionConfig(\Elgg\Database\Config::READ_WRITE);
	}
	
	$mysql_dblink = @mysql_connect($read_settings["host"], $read_settings["user"], $read_settings["password"], true);
	if ($mysql_dblink) {
		if (@mysql_select_db($read_settings["database"], $mysql_dblink)) {
			$q = "SELECT name, value FROM {$db_config->getTablePrefix()}datalists WHERE name = 'dataroot'";
			
			$result = mysql_query($q, $mysql_dblink);
			if ($result) {
				$row = mysql_fetch_object($result);
				while ($row) {
					if ($row->name == 'dataroot') {
						$data_root = $row->value;
					}
	
					$row = mysql_fetch_object($result);
				}
			}
	
			@mysql_close($mysql_dblink);
		}
	}
}

if (isset($data_root)) {
	
	$locator = new \Elgg\EntityDirLocator($guid);
	$entity_path = $data_root . $locator->getPath();
	
	$filename = $entity_path . "groups/{$group_guid}{$size}.jpg";
	$filecontents = @file_get_contents($filename);

	// try fallback size
	if (!$filecontents && $size !== "medium") {
		$filename = $entity_path . "groups/{$group_guid}medium.jpg";
		$filecontents = @file_get_contents($filename);
	}
	
	if ($filecontents) {
		$filesize = strlen($filecontents);
		
		header("Content-type: image/jpeg");
		header("Expires: " . gmdate("D, d M Y H:i:s \G\M\T", strtotime("+6 months")), true);
		header("Pragma: public");
		header("Cache-Control: public");
		header("Content-Length: $filesize");
		header("ETag: \"$etag\"");
		
		echo $filecontents;
		exit;
	}
}

// something went wrong so 404
header("HTTP/1.1 404 Not Found");
exit;
