<?php

/**
 * Upload users form view
 *
 * @package upload_users
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jaakko Naakka / Mediamaisteri Group
 * @author Ismayil Khayredinov / Arck Interactive
 * @copyright Mediamaisteri Group 2009
 * @copyright ArckInteractive 2013
 * @link http://www.mediamaisteri.com/
 * @link http://arckinteractive.com/
 */
// CSV File Input
echo '<div>';
echo '<label>' . elgg_echo('upload_users:choose_file') . '</label>';
echo elgg_view('input/file', array('name' => 'csvfile'));
echo '</div>';

// CSV Delimiter
echo '<div>';
echo '<label>' . elgg_echo('upload_users:delimiter') . '</label>';
echo elgg_view('input/dropdown', array(
	'options_values' => array(
		'&#44;' => elgg_echo('upload_users:delimiter:comma'),
		'&#59;' => elgg_echo('upload_users:delimiter:semicolon'),
		'&#58;' => elgg_echo('upload_users:delimiter:colon'),
	),
	'name' => 'delimiter',
	'value' => '&#44;'
));
echo '</div>';

// CSV Enclosure
echo '<div>';
echo '<label>' . elgg_echo('upload_users:enclosure') . '</label>';
echo elgg_view('input/dropdown', array(
	'options_values' => array(
		'&#34;' => elgg_echo('upload_users:enclosure:doublequote'),
		'&#39;' => elgg_echo('upload_users:enclosure:singlequote'),
	),
	'name' => 'enclosure',
	'value' => '&#34;'
));
echo '</div>';

// CSV Encoding
echo '<div>';
echo '<label>' . elgg_echo('upload_users:encoding') . '</label>';
echo elgg_view('input/dropdown', array(
	'options' => array('UTF-8', 'ISO-8859-1', 'Windows-1252'),
	'name' => 'encoding',
	'value' => 'UTF-8'
));
echo '</div>';

// Field mapping templates
$templates = array(
	'new' => elgg_echo('upload_users:new_template')
);

$saved_templates = elgg_get_plugin_setting('templates', 'upload_users');
if ($saved_templates) {
	$saved_templates = unserialize($saved_templates);
	$saved_templates_names = array();
	foreach ($saved_templates as $template_name => $opts) {
		$saved_templates_names[$template_name] = $template_name;
	}
	$templates = array_merge($templates, $saved_templates_names);
}
echo '<div>';
echo '<label>' . elgg_echo('upload_users:mapping_template') . '</label>';
echo elgg_view('input/dropdown', array(
	'name' => 'template',
	'options_values' => $templates
));
echo '</div>';


$settings = array(
	'notification', // Notify users when a new account is created
	'update_existing_users', // Update user records when user account exists
	'fix_usernames', // Fix usernames if they contain illegal characters
	'fix_passwords', // Fix passwords if they are too short
);

foreach ($settings as $setting) {
	echo '<div>';
	echo '<label>' . elgg_echo("upload_users:setting:$setting") . '</label>';
	echo elgg_view('input/dropdown', array('options_values' => array(
			0 => elgg_echo('upload_users:no'),
			1 => elgg_echo('upload_users:yes'),
		),
		'name' => $setting,
	));
	echo '</div>';
}


// Submit
echo '<div class="elgg-foot">';
echo elgg_view('input/submit', array('value' => elgg_echo('next')));
echo '</div>';