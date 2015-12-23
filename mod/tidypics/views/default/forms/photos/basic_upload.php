<?php
/**
 * Basic uploader form
 *
 * This only handled uploading the images. Editing the titles and descriptions
 * are handled with the edit forms.
 *
 * @uses $vars['entity']
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$album = $vars['entity'];

$maxfilesize = (float) elgg_get_plugin_setting('maxfilesize', 'tidypics');
if (!$maxfilesize) {
	$maxfilesize = 5;
}
$max_uploads = (int) elgg_get_plugin_setting('max_uploads', 'tidypics');
if (!$max_uploads) {
	$max_uploads = 10;
}

$instructions = elgg_echo("tidypics:uploader:upload");
$max = elgg_echo('tidypics:uploader:basic', array($max_uploads, $maxfilesize));

$list = '';
for ($x = 0; $x < $max_uploads; $x++) {
	$list .= '<li>' . elgg_view('input/file', array('name' => 'images[]')) . '</li>';
}

$foot = elgg_view('input/hidden', array('name' => 'guid', 'value' => $album->getGUID()));
$foot .= elgg_view('input/submit', array('value' => elgg_echo("photos:addphotos")));

$form_body = <<<HTML
<div>
	$max
</div>
<div>
	<ol>
		$list
	</ol>
</div>
<div class='elgg-foot'>
	$foot
</div>
HTML;

echo elgg_view('input/form', array(
	'body' => $form_body,
	'action' => 'action/photos/image/upload',
	'enctype' => 'multipart/form-data',
));
