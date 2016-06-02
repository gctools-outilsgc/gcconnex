<?php 
$noticeEN = $vars['entity']->noticeEN;
$noticeFR = $vars['entity']->noticeFR;
$bannertype = $vars['entity']->bannertype;
$startdate = $vars['entity']->startdate;
$enddate = $vars['entity']->enddate;
$moreinfolink= $vars['entity']->moreinfolink;
$active= $vars['entity']->Banneractive;
/*if (!$loginreq) { $loginreq = 'yes'; }		*/
?>

<p>
<?php
$options = array(
	'name' => 'params[Banneractive]',
	'value' => 1
);
if (elgg_get_plugin_setting('Banneractive', 'GoC_dev_banner')) {
	$options['checked'] = 'checked';
}
echo "<div>";
echo elgg_echo('dev_banner:activate');
echo elgg_view('input/checkbox',$options);
echo "</div>";
echo "<div>";
echo elgg_echo('dev_banner:enternoticeEN');
echo elgg_view('input/text', array(
    'name'  => 'params[noticeEN]',
    'value' => $noticeEN,
));
echo "</div>";
echo "<div>";
echo elgg_echo('dev_banner:enternoticeFR');
echo elgg_view('input/text', array(
    'name'  => 'params[noticeFR]',
    'value' => $noticeFR,
));
echo "</div>";
echo "<div>";
	echo elgg_echo('dev_banner:bannertype') . ' ';
	echo elgg_view('input/dropdown', array(
		'name' => 'params[bannertype]',
		'options_values' => array(
			'info' => elgg_echo('dev_banner:info'),
			'warning' => elgg_echo('dev_banner:warning'),
			'danger' => elgg_echo('dev_banner:danger'),
			'success' => elgg_echo('dev_banner:success'),
		),
		'value' => $bannertype,
	));
echo "</div>";
echo "<div>";
echo elgg_echo('dev_banner:startdate') . ' ';
echo elgg_view('input/date', array(
        'name' => 'params[startdate]',
        'value' => $startdate,
        ));
echo "</div>";
echo "<div>";
echo elgg_echo('dev_banner:enddate') . ' ';
echo elgg_view('input/date', array(
        'name' => 'params[enddate]',
        'value' => $enddate,
        ));
echo "</div>";
echo "<div>";
echo elgg_echo('dev_banner:moreinfolink') . ' ';
echo elgg_view('input/text', array(
        'name' => 'params[moreinfolink]',
        'value' => $moreinfolink,
        ));
echo "</div>";

?>