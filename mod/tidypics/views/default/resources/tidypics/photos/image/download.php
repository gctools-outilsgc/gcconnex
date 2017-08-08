<?php
/**
 * Download a photo
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$guid = elgg_extract('guid', $vars);
$image = get_entity($guid);

$disposition = elgg_extract('disposition', $vars, 'attachment');

if ($image && elgg_instanceof($image, 'object', 'image')) {
	$filename = $image->originalfilename;
	$mime = $image->mimetype;

	header("Content-Type: $mime");
	header("Content-Disposition: $disposition; filename=\"$filename\"");

	$contents = $image->grabFile();

	if (empty($contents)) {
		forward(elgg_get_simplecache_url("tidypics/image_error_large.png"));
	} else {
		// expires every 60 days
		$expires = 60 * 60*60*24;

		header("Content-Length: " . strlen($contents));
		header("Cache-Control: public", true);
		header("Pragma: public", true);
		header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT', true);

		echo $contents;
	}

	exit;
} else {
	register_error(elgg_echo("image:downloadfailed"));
}
