<?php
/**
 * Adds a file input to the wire post form.
 */

$input = elgg_view('input/file', array(
	'name' => 'thewire_image_file',
	'class' => 'thewire-image'
));

echo $input;