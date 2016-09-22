<?php
/**
 * Edit the images in a batch
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$guids = get_input('guid');
$titles = get_input('title');
$titles2 = get_input('title2');
$captions = get_input('caption');
$captions2 = get_input('caption2');
$tags = get_input('tags');

$not_updated = array();
foreach ($guids as $key => $guid) {
	$image = get_entity($guid);

	if ($image->canEdit()) {

		if ((empty($titles[$key])) || (empty($titles2[$key]))) {
                        $title = substr($image->originalfilename, 0, strrpos($image->originalfilename, '.'));
                        // remove any possible bad characters from the title
                        $image->title = preg_replace('/\W/', '', $title);
		}// set title appropriately
		if ($titles[$key]) {
			$image->title = $titles[$key];
}
		if ($titles2[$key]) {
			$image->title2 = $titles2[$key];
		
		} 



		if (($titles[$key]) && ($titles2[$key])){
			$titles3[$key] = gc_implode_translation($titles[$key],$titles2[$key]);
		}

		// set description appropriately
		$image->description = $captions[$key];
		$image->description2 = $captions2[$key];
		$image->description3 = gc_implode_translation($captions[$key],$captions2[$key]);
		$image->tags = string_to_tag_array($tags[$key]);

		if (!$image->save()) {
			array_push($not_updated, $image->getGUID());
		}
	}
}

if (count($not_updated) > 0) {
	register_error(elgg_echo("images:notedited"));
} else {
	system_message(elgg_echo("images:edited"));
}
forward($image->getContainerEntity()->getURL());
