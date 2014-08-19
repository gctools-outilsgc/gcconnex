<?php

$cl = new SphinxClient();
$cl->setServer('localhost', 9312);
$status = $cl->Status();


if ($status) {
	echo elgg_view('output/longtext', array(
		'value' => 'IO and CPU counters will only be available if searchd was started with --iostats and --cpustats switches respectively.',
		'class' => 'elgg-message elgg-state-notice',
	));
	
	echo "<table class=\"elgg-table\">";
	foreach ($status as $row) {
		echo "<tr><th>{$row[0]}</th><td>{$row[1]}</td></tr>";
	}
	echo "</table>";
} else {
	
	echo "We got the following error when trying to connect to searchd:";
	echo elgg_view('output/longtext', array(
		'value' => $cl->GetLastError(),
		'class' => 'elgg-message elgg-state-error',
	));
	
	$dataroot = elgg_get_config('dataroot');
	
	echo "Please check that searchd is running:";
	echo "<pre>";
	echo "searchd --stop\n";
	echo "indexer --all --config {$dataroot}sphinx/sphinx.conf\n";
	echo "searchd --config {$dataroot}sphinx/sphinx.conf\n";
	echo "</pre>";
	
}
