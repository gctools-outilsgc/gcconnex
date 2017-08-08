<?php
/**
 * Tidypics ajax upload form body
 *
 * @uses $vars['entity']
 */

$album = $vars['entity'];

$ts = time();
$batch = time();
$tidypics_token = generate_action_token($ts);
$basic_uploader_url = current_page_url() . '/basic';

$maxfilesize = (float) elgg_get_plugin_setting('maxfilesize', 'tidypics');
if (!$maxfilesize) {
	$maxfilesize = 5;
}
$maxfilesize_int = (int) $maxfilesize;
$max_uploads = (int) elgg_get_plugin_setting('max_uploads', 'tidypics');
if (!$max_uploads) {
	$max_uploads = 10;
}
$client_resizing = (bool)elgg_get_plugin_setting('client_resizing', 'tidypics');
if ($client_resizing) {
	$client_resizing = "true";
} else {
	$client_resizing = "false";
}
$remove_exif = (bool)elgg_get_plugin_setting('remove_exif', 'tidypics');
if ($remove_exif) {
	$remove_exif = "true";
} else {
	$remove_exif = "false";
}
$client_image_width = (int) elgg_get_plugin_setting('client_image_width', 'tidypics');
if (!$client_image_width) {
	$client_image_width = 2000;
}
$client_image_height = (int) elgg_get_plugin_setting('client_image_height', 'tidypics');
if (!$client_image_height) {
	$client_image_height = 2000;
}

echo elgg_view('output/longtext', array('value' => elgg_echo('tidypics:uploader:instructs', array($max_uploads, $maxfilesize)), 'class' => 'mts mbm'));

?>

<div id="uploader" data-maxfilesize="<?php echo $maxfilesize_int; ?>" data-maxnumber="<?php echo $max_uploads; ?>" data-client-resizing="<?php echo $client_resizing; ?>" data-remove-exif="<?php echo $remove_exif; ?>" data-client-width="<?php echo $client_image_width; ?>" data-client-height="<?php echo $client_image_height; ?>">
	<input type="hidden" name="album_guid" value="<?php echo $album->getGUID(); ?>" />
	<input type="hidden" name="batch" value="<?php echo $batch; ?>" />
	<input type="hidden" name="tidypics_token" value="<?php echo $tidypics_token; ?>" />
	<input type="hidden" name="user_guid" value="<?php echo elgg_get_logged_in_user_guid(); ?>" />
	<input type="hidden" name="Elgg" value="<?php echo session_id(); ?>" />
	<p>
		<?php
			elgg_echo('tidypics:uploader:no_flash');
		?>
	</p>
</div>
