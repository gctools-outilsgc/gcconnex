<?php
/**
 * Adds a file input to the wire post form.
 */

echo "<label for='thewire_image_file'>" . elgg_echo('thewire_image:upload_image') . "</label>";

echo elgg_view('input/file', array(
	'id' => 'thewire_image_file',
	'name' => 'thewire_image_file',
	'class' => 'thewire-image mbm'
));
